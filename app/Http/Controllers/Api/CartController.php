<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Add item to guest cart (session-based)
     */
    public function addToCart(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1|max:99',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $productId = $request->product_id;
            $quantity = $request->quantity;

            // Get product details
            $product = Product::with(['category', 'images'])->find($productId);
            
            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not available'
                ], 404);
            }

            // Get current cart from session
            $cart = session('cart', []);

            // Check if product already exists in cart
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += $quantity;
            } else {
                $cart[$productId] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image_path' => $product->image_path,
                    'quantity' => $quantity,
                    'category' => $product->category ? $product->category->name : null,
                ];
            }

            // Save cart to session
            session(['cart' => $cart]);

            return response()->json([
                'status' => 'success',
                'message' => 'Product added to cart',
                'data' => [
                    'cart_count' => count($cart),
                    'cart_total' => $this->calculateCartTotal($cart),
                    'added_item' => $cart[$productId]
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add product to cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get guest cart
     */
    public function index()
    {
        try {
            $cart = session('cart', []);

            return response()->json([
                'status' => 'success',
                'message' => 'Cart retrieved successfully',
                'data' => [
                    'items' => array_values($cart),
                    'total_items' => count($cart),
                    'subtotal' => $this->calculateCartTotal($cart),
                    'total' => $this->calculateCartTotal($cart), // Add tax/shipping if needed
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove item from guest cart
     */
    public function removeFromCart($id)
    {
        try {
            $cart = session('cart', []);

            if (isset($cart[$id])) {
                unset($cart[$id]);
                session(['cart' => $cart]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Item removed from cart',
                    'data' => [
                        'cart_count' => count($cart),
                        'cart_total' => $this->calculateCartTotal($cart)
                    ]
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Item not found in cart'
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to remove item from cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update quantity in guest cart
     */
    public function updateQuantity(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'quantity' => 'required|integer|min:1|max:99',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $cart = session('cart', []);

            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $request->quantity;
                session(['cart' => $cart]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Quantity updated',
                    'data' => [
                        'cart_count' => count($cart),
                        'cart_total' => $this->calculateCartTotal($cart),
                        'updated_item' => $cart[$id]
                    ]
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Item not found in cart'
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update quantity',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear guest cart
     */
    public function clearCart()
    {
        try {
            session()->forget('cart');

            return response()->json([
                'status' => 'success',
                'message' => 'Cart cleared successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to clear cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get guest cart count
     */
    public function getCount()
    {
        try {
            $cart = session('cart', []);

            return response()->json([
                'status' => 'success',
                'message' => 'Cart count retrieved successfully',
                'data' => [
                    'count' => count($cart)
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get cart count',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add item to authenticated user cart (database-based)
     */
    public function addToUserCart(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1|max:99',
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
            $quantity = $request->quantity;

            // Get product details
            $product = Product::with(['category', 'images'])->find($productId);
            
            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not available'
                ], 404);
            }

            // Check if product already exists in user's cart
            $existingCartItem = Cart::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->first();

            if ($existingCartItem) {
                $existingCartItem->update([
                    'quantity' => $existingCartItem->quantity + $quantity
                ]);
            } else {
                Cart::create([
                    'user_id' => $user->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }

            $cartCount = Cart::where('user_id', $user->id)->count();
            $cartTotal = $this->calculateUserCartTotal($user->id);

            return response()->json([
                'status' => 'success',
                'message' => 'Product added to cart',
                'data' => [
                    'cart_count' => $cartCount,
                    'cart_total' => $cartTotal,
                    'product' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'image_path' => $product->image_path,
                        'quantity' => $quantity,
                        'category' => $product->category ? $product->category->name : null,
                    ]
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add product to cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get authenticated user cart
     */
    public function userCart()
    {
        try {
            $user = auth()->user();
            
            $cartItems = Cart::where('user_id', $user->id)
                ->with(['product.category', 'product.images'])
                ->get();

            $items = $cartItems->map(function ($item) {
                return [
                    'id' => $item->product->id,
                    'name' => $item->product->name,
                    'price' => $item->product->price,
                    'image_path' => $item->product->image_path,
                    'quantity' => $item->quantity,
                    'category' => $item->product->category ? $item->product->category->name : null,
                ];
            });

            $cartTotal = $this->calculateUserCartTotal($user->id);

            return response()->json([
                'status' => 'success',
                'message' => 'User cart retrieved successfully',
                'data' => [
                    'items' => $items,
                    'total_items' => $cartItems->count(),
                    'subtotal' => $cartTotal,
                    'total' => $cartTotal,
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve user cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove item from authenticated user cart
     */
    public function removeFromUserCart($id)
    {
        try {
            $user = auth()->user();
            
            $cartItem = Cart::where('user_id', $user->id)
                ->where('product_id', $id)
                ->first();

            if ($cartItem) {
                $cartItem->delete();

                $cartCount = Cart::where('user_id', $user->id)->count();
                $cartTotal = $this->calculateUserCartTotal($user->id);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Item removed from cart',
                    'data' => [
                        'cart_count' => $cartCount,
                        'cart_total' => $cartTotal
                    ]
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Item not found in cart'
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to remove item from cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update quantity in authenticated user cart
     */
    public function updateUserCartQuantity(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'quantity' => 'required|integer|min:1|max:99',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = auth()->user();
            
            $cartItem = Cart::where('user_id', $user->id)
                ->where('product_id', $id)
                ->first();

            if ($cartItem) {
                $cartItem->update(['quantity' => $request->quantity]);

                $cartCount = Cart::where('user_id', $user->id)->count();
                $cartTotal = $this->calculateUserCartTotal($user->id);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Quantity updated',
                    'data' => [
                        'cart_count' => $cartCount,
                        'cart_total' => $cartTotal,
                        'updated_item' => [
                            'id' => $cartItem->product->id,
                            'name' => $cartItem->product->name,
                            'price' => $cartItem->product->price,
                            'quantity' => $request->quantity,
                        ]
                    ]
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Item not found in cart'
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update quantity',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear authenticated user cart
     */
    public function clearUserCart()
    {
        try {
            $user = auth()->user();
            Cart::where('user_id', $user->id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Cart cleared successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to clear cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate guest cart total
     */
    private function calculateCartTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    /**
     * Calculate user cart total
     */
    private function calculateUserCartTotal($userId)
    {
        $cartItems = Cart::where('user_id', $userId)
            ->with('product')
            ->get();

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->product->price * $item->quantity;
        }
        return $total;
    }
}