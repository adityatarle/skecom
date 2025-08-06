<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
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


            return response()->json([
                'status' => 'success',
                'data' => [
                    'categories' => $categories
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch categories',
                'error' => $e->getMessage()
            ], 500);
        }
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


            return response()->json([
                'status' => 'success',
                'data' => [
                    'category' => [
                        'id' => $category->id,
                        'name' => $category->name,
                        'description' => $category->description ?? '',
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
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch products by category',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}