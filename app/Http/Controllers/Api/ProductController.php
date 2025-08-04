<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Get all products with pagination
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 12);
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $query = Product::with(['category', 'subcategory', 'images'])
            ->where('status', 'active');

        // Apply sorting
        if (in_array($sortBy, ['name', 'price', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $products = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => [
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

    /**
     * Get a specific product
     */
    public function show(Product $product)
    {
        $product->load(['category', 'subcategory', 'images', 'pricingDetails']);

        // Get pricing breakdown
        $pricingBreakup = $product->getPricingBreakup();

        // Get related products
        $relatedProducts = Product::with(['category', 'images'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'product' => $product,
                'pricing_breakup' => $pricingBreakup,
                'related_products' => $relatedProducts
            ]
        ]);
    }

    /**
     * Search products
     */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'query' => 'required|string|min:2',
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $perPage = $request->get('per_page', 12);
        $query = $request->get('query');

        $products = Product::with(['category', 'subcategory', 'images'])
            ->where('status', 'active')
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhereHas('category', function ($categoryQuery) use ($query) {
                      $categoryQuery->where('name', 'LIKE', "%{$query}%");
                  });
            })
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => [
                'products' => $products->items(),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                    'from' => $products->firstItem(),
                    'to' => $products->lastItem(),
                ],
                'search_query' => $query
            ]
        ]);
    }

    /**
     * Filter products
     */
    public function filter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'nullable|integer|exists:product_categories,id',
            'sub_category_id' => 'nullable|integer|exists:subcategories,id',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'per_page' => 'nullable|integer|min:1|max:50',
            'sort_by' => 'nullable|in:name,price,created_at',
            'sort_order' => 'nullable|in:asc,desc',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $perPage = $request->get('per_page', 12);
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $query = Product::with(['category', 'subcategory', 'images'])
            ->where('status', 'active');

        // Apply filters
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('sub_category_id')) {
            $query->where('sub_category_id', $request->sub_category_id);
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Apply sorting
        $query->orderBy($sortBy, $sortOrder);

        $products = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => [
                'products' => $products->items(),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                    'from' => $products->firstItem(),
                    'to' => $products->lastItem(),
                ],
                'filters_applied' => $request->only(['category_id', 'sub_category_id', 'min_price', 'max_price'])
            ]
        ]);
    }

    /**
     * Store product inquiry
     */
    public function storeInquiry(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|max:1000',
            'quantity' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $inquiry = ProductInquiry::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'message' => $request->message,
                'quantity' => $request->quantity ?? 1,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Inquiry submitted successfully',
                'data' => [
                    'inquiry' => $inquiry
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to submit inquiry',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Admin: Get all products (for admin panel)
     */
    public function adminIndex(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $search = $request->get('search');
        $categoryId = $request->get('category_id');
        $status = $request->get('status');

        $query = Product::with(['category', 'subcategory', 'images']);

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => [
                'products' => $products->items(),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                ]
            ]
        ]);
    }

    /**
     * Admin: Store new product
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:product_categories,id',
            'sub_category_id' => 'nullable|exists:subcategories,id',
            'labour_charges' => 'nullable|numeric|min:0',
            'gst_percentage' => 'nullable|numeric|min:0|max:100',
            'status' => 'required|in:active,inactive',
            'image_path' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $product = Product::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Product created successfully',
                'data' => [
                    'product' => $product->load(['category', 'subcategory'])
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Admin: Update product
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:product_categories,id',
            'sub_category_id' => 'nullable|exists:subcategories,id',
            'labour_charges' => 'nullable|numeric|min:0',
            'gst_percentage' => 'nullable|numeric|min:0|max:100',
            'status' => 'required|in:active,inactive',
            'image_path' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $product->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Product updated successfully',
                'data' => [
                    'product' => $product->load(['category', 'subcategory'])
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Admin: Delete product
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Product deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete product',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}