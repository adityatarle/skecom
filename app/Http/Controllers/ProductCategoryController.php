<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductCategoryController extends Controller
{
    

public function index(Request $request)
{
    try {
        // Start with a simple query first
        $query = ProductCategory::query();
        
        // Add relationships and counts for efficient rendering
        $query->with(['parent', 'children'])
              ->withCount(['products', 'children']);
            
        // Filter by level if specified
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }
        
        // Filter by parent if specified
        if ($request->filled('parent_id')) {
            $query->where('parent_id', $request->parent_id);
        }
        
        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }
        
        // Add ordering
        $query->orderBy('level')->orderBy('sort_order')->orderBy('name');
        
        // Paginate
        $categories = $query->paginate(15);

        // Transform categories to add short fields
        $categories->getCollection()->transform(function ($category) {
            $category->short_name = Str::limit($category->name, 20); // 20 chars max
            $category->short_description = Str::limit($category->description, 50); // 50 chars max
            return $category;
        });
        
        // Get parent categories for filter dropdown
        $parentCategories = ProductCategory::whereIn('level', [1, 2])
                                ->orderBy('name')
                                ->get();
        
        // Ensure categories is a paginator instance
        if (!$categories instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            \Log::error('Categories is not a paginator instance', [
                'type' => get_class($categories),
                'categories' => $categories
            ]);
            $categories = $query->get();
        }
        
        return view('admin.category.index', compact('categories', 'parentCategories'));
        
    } catch (\Exception $e) {
        \Log::error('Error in ProductCategoryController@index: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);
        
        $categories = collect();
        $parentCategories = collect();
        
        return view('admin.category.index', compact('categories', 'parentCategories'))
            ->with('error', 'An error occurred while loading categories. Please try again.');
    }
}


    public function create(Request $request)
    {
        $level = $request->get('level', ProductCategory::LEVEL_TOP);
        $parentCategories = collect();
        
        // Get available parent categories based on level
        if ($level == ProductCategory::LEVEL_PARENT) {
            $parentCategories = ProductCategory::where('level', ProductCategory::LEVEL_TOP)
                ->active()
                ->orderBy('name')
                ->get();
        } elseif ($level == ProductCategory::LEVEL_CHILD) {
            $parentCategories = ProductCategory::where('level', ProductCategory::LEVEL_PARENT)
                ->active()
                ->orderBy('name')
                ->get();
        }
        
        return view('admin.category.create', compact('level', 'parentCategories'))
        ->with('Str', Str::class);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'level' => 'required|integer|in:1,2,3',
            'parent_id' => 'nullable|exists:product_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0'
        ];
        
        // Validate parent_id based on level
        if ($request->level == ProductCategory::LEVEL_PARENT) {
            $rules['parent_id'] = 'required|exists:product_categories,id';
        } elseif ($request->level == ProductCategory::LEVEL_CHILD) {
            $rules['parent_id'] = 'required|exists:product_categories,id';
        } elseif ($request->level == ProductCategory::LEVEL_TOP) {
            $rules['parent_id'] = 'nullable';
        }
        
        $validated = $request->validate($rules);
        
        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);
        
        // Ensure unique slug
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (ProductCategory::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validated['name']) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/categories'), $imageName);
            $validated['image'] = 'images/categories/' . $imageName;
        }
        
        // Set default values
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        
        // Validate hierarchy logic
        if ($validated['level'] == ProductCategory::LEVEL_TOP) {
            $validated['parent_id'] = null;
        }
        
        $category = ProductCategory::create($validated);
        
        return redirect()->route('admin.category.index')
            ->with('success', 'Category created successfully!');
    }

    public function show(ProductCategory $category)
    {
        $category->load(['parent', 'children.children', 'products']);
        
        $stats = [
            'total_products' => $category->allProducts()->count(),
            'direct_products' => $category->products()->count(),
            'child_categories' => $category->children()->count(),
            'total_descendants' => $this->countDescendants($category)
        ];
        
        return view('admin.category.show', compact('category', 'stats'));
    }

    public function edit(ProductCategory $category)
    {
        $parentCategories = collect();
        
        // Get available parent categories based on level
        if ($category->level == ProductCategory::LEVEL_PARENT) {
            $parentCategories = ProductCategory::where('level', ProductCategory::LEVEL_TOP)
                ->where('id', '!=', $category->id)
                ->active()
                ->orderBy('name')
                ->get();
        } elseif ($category->level == ProductCategory::LEVEL_CHILD) {
            $parentCategories = ProductCategory::where('level', ProductCategory::LEVEL_PARENT)
                ->where('id', '!=', $category->id)
                ->active()
                ->orderBy('name')
                ->get();
        }
        
        return view('admin.category.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, ProductCategory $category)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'level' => 'required|integer|in:1,2,3',
            'parent_id' => 'nullable|exists:product_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0'
        ];
        
        // Validate parent_id based on level
        if ($request->level == ProductCategory::LEVEL_PARENT) {
            $rules['parent_id'] = 'required|exists:product_categories,id';
        } elseif ($request->level == ProductCategory::LEVEL_CHILD) {
            $rules['parent_id'] = 'required|exists:product_categories,id';
        } elseif ($request->level == ProductCategory::LEVEL_TOP) {
            $rules['parent_id'] = 'nullable';
        }
        
        $validated = $request->validate($rules);
        
        // Generate slug if name changed
        if ($category->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Ensure unique slug
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (ProductCategory::where('slug', $validated['slug'])->where('id', '!=', $category->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validated['name']) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/categories'), $imageName);
            $validated['image'] = 'images/categories/' . $imageName;
        }
        
        // Set default values
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        
        // Validate hierarchy logic
        if ($validated['level'] == ProductCategory::LEVEL_TOP) {
            $validated['parent_id'] = null;
        }
        
        $category->update($validated);
        
        return redirect()->route('admin.category.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(ProductCategory $category)
    {
        // Check if category has children
        if ($category->hasChildren()) {
            return redirect()->back()
                ->with('error', 'Cannot delete category that has child categories. Please delete or move child categories first.');
        }
        
        // Check if category has products
        if ($category->products()->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete category that has products. Please move or delete products first.');
        }
        
        // Delete image if exists
        if ($category->image && file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }
        
        $category->delete();
        
        return redirect()->route('admin.category.index')
            ->with('success', 'Category deleted successfully!');
    }

    public function getByParent(Request $request)
    {
        $parentId = $request->get('parent_id');
        $level = $request->get('level', 2);
        
        $categories = ProductCategory::where('parent_id', $parentId)
            ->where('level', $level)
            ->active()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name', 'level']);
            
        return response()->json($categories);
    }

    public function toggleStatus(ProductCategory $category)
    {
        $category->update(['is_active' => !$category->is_active]);
        
        return response()->json([
            'success' => true,
            'status' => $category->is_active,
            'message' => $category->is_active ? 'Category activated' : 'Category deactivated'
        ]);
    }

    private function countDescendants(ProductCategory $category)
    {
        $count = $category->children()->count();
        foreach ($category->children as $child) {
            $count += $this->countDescendants($child);
        }
        return $count;
    }

    /**
     * Test method for debugging pagination issues
     */
    public function testPagination()
    {
        try {
            // Simple query without any relationships
            $categories = ProductCategory::query()->paginate(15);
            
            return response()->json([
                'success' => true,
                'type' => get_class($categories),
                'hasPages' => method_exists($categories, 'hasPages') ? $categories->hasPages() : 'Method not found',
                'count' => $categories->count(),
                'total' => $categories->total(),
                'perPage' => $categories->perPage(),
                'currentPage' => $categories->currentPage(),
                'lastPage' => $categories->lastPage(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}