<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * List all active categories
     */
    public function index()
    {
        try {
            $categories = ProductCategory::where('is_active', true)
                ->orderBy('sort_order')
                ->get();
            return response()->json([
                'status' => 'success',
                'message' => 'Categories retrieved successfully',
                'data' => [
                    'categories' => $categories
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show a specific category
     */
    public function show($id)
    {
        try {
            $category = ProductCategory::with('subcategories')
                ->where('is_active', true)
                ->find($id);
            if (!$category) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Category not found'
                ], 404);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Category retrieved successfully',
                'data' => [
                    'category' => $category
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * List all active subcategories for a category
     */
    public function subcategories($categoryId)
    {
        try {
            $subcategories = Subcategory::where('category_id', $categoryId)
                ->where('is_active', true)
                ->orderBy('name')
                ->get();
            return response()->json([
                'status' => 'success',
                'message' => 'Subcategories retrieved successfully',
                'data' => [
                    'subcategories' => $subcategories
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve subcategories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show a specific subcategory
     */
    public function showSubcategory($id)
    {
        try {
            $subcategory = Subcategory::find($id);
            if (!$subcategory || !$subcategory->is_active) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Subcategory not found'
                ], 404);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Subcategory retrieved successfully',
                'data' => [
                    'subcategory' => $subcategory
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve subcategory',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}