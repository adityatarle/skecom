<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    /**
     * Add item to guest wishlist (session-based)
     */
    public function addToWishlist(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $productId = $request->product_id;

            // Get product details
            $product = Product::with(['category', 'images'])->find($productId);
            
            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not available'
                ], 404);
            }

            // Get current wishlist from session
            $wishlist = session('wishlist', []);

            // Check if product already exists in wishlist
            if (!in_array($productId, $wishlist)) {
                $wishlist[] = $productId;
                session(['wishlist' => $wishlist]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Product added to wishlist',
                'data' => [
                    'wishlist_count' => count($wishlist),
                    'product' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'image_path' => $product->image_path,
                        'category' => $product->category ? $product->category->name : null,
                    ]
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add product to wishlist',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get guest wishlist
     */
    public function index()
    {
        try {
            $wishlistIds = session('wishlist', []);
            
            $products = Product::with(['category', 'images'])
                ->whereIn('id', $wishlistIds)
                ->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Wishlist retrieved successfully',
                'data' => [
                    'products' => $products,
                    'total_items' => $products->count(),
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve wishlist',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove item from guest wishlist
     */
    public function remove($productId)
    {
        try {
            $wishlist = session('wishlist', []);

            if (in_array($productId, $wishlist)) {
                $wishlist = array_diff($wishlist, [$productId]);
                session(['wishlist' => array_values($wishlist)]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Product removed from wishlist',
                    'data' => [
                        'wishlist_count' => count($wishlist)
                    ]
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Product not found in wishlist'
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to remove product from wishlist',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get guest wishlist count
     */
    public function getCount()
    {
        try {
            $wishlist = session('wishlist', []);

            return response()->json([
                'status' => 'success',
                'message' => 'Wishlist count retrieved successfully',
                'data' => [
                    'count' => count($wishlist)
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get wishlist count',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add item to authenticated user wishlist (database-based)
     */
    public function addToUserWishlist(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = auth()->user();
            $productId = $request->product_id;

            // Get product details
            $product = Product::with(['category', 'images'])->find($productId);
            
            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not available'
                ], 404);
            }

            // Check if product already exists in user's wishlist
            $existingWishlistItem = Wishlist::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->first();

            if (!$existingWishlistItem) {
                Wishlist::create([
                    'user_id' => $user->id,
                    'product_id' => $productId,
                ]);
            }

            $wishlistCount = Wishlist::where('user_id', $user->id)->count();

            return response()->json([
                'status' => 'success',
                'message' => 'Product added to wishlist',
                'data' => [
                    'wishlist_count' => $wishlistCount,
                    'product' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'image_path' => $product->image_path,
                        'category' => $product->category ? $product->category->name : null,
                    ]
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add product to wishlist',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get authenticated user wishlist
     */
    public function userWishlist()
    {
        try {
            $user = auth()->user();
            
            $wishlistItems = Wishlist::where('user_id', $user->id)
                ->with(['product.category', 'product.images'])
                ->get();

            $products = $wishlistItems->map(function ($item) {
                return $item->product;
            })->filter(function ($product) {
                return $product;
            });

            return response()->json([
                'status' => 'success',
                'message' => 'User wishlist retrieved successfully',
                'data' => [
                    'products' => $products,
                    'total_items' => $products->count(),
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve user wishlist',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove item from authenticated user wishlist
     */
    public function removeFromUserWishlist($productId)
    {
        try {
            $user = auth()->user();
            
            $wishlistItem = Wishlist::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->first();

            if ($wishlistItem) {
                $wishlistItem->delete();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Product removed from wishlist',
                    'data' => [
                        'wishlist_count' => Wishlist::where('user_id', $user->id)->count()
                    ]
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Product not found in wishlist'
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to remove product from wishlist',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if product is in user wishlist
     */
    public function checkWishlist($productId)
    {
        try {
            $user = auth()->user();
            
            $isInWishlist = Wishlist::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->exists();

            return response()->json([
                'status' => 'success',
                'message' => 'Wishlist status checked successfully',
                'data' => [
                    'is_in_wishlist' => $isInWishlist
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to check wishlist status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear authenticated user wishlist
     */
    public function clearUserWishlist()
    {
        try {
            $user = auth()->user();
            Wishlist::where('user_id', $user->id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Wishlist cleared successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to clear wishlist',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}