<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Get all categories
     */
    public function index(Request $request)
    {
        $categories = ProductCategory::with(['subcategories'])
            ->where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'categories' => $categories
            ]
        ]);
    }

    /**
     * Get specific category
     */
    public function show(ProductCategory $category)
    {
        $category->load(['subcategories']);

        return response()->json([
            'status' => 'success',
            'data' => [
                'category' => $category
            ]
        ]);
    }

    /**
     * Get products by category
     */
    public function products(Request $request, ProductCategory $category)
    {
        $perPage = $request->get('per_page', 12);
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $subCategoryId = $request->get('sub_category_id');

        $query = $category->products()
            ->with(['subcategory', 'images'])
            ->where('status', 'active');

        // Filter by subcategory if provided
        if ($subCategoryId) {
            $query->where('sub_category_id', $subCategoryId);
        }

        // Apply sorting
        if (in_array($sortBy, ['name', 'price', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $products = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => [
                'category' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'description' => $category->description,
                    'image_path' => $category->image_path,
                ],
                'products' => $products->items(),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                    'from' => $products->firstItem(),
                    'to' => $products->lastItem(),
                ]
            ]
        ]);
    }
}