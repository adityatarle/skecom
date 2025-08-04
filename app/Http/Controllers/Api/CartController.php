<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Add item to guest cart (session-based)
     */
    public function addToCart(Request $request)
    {
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
        
        if (!$product || $product->status !== 'active') {
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
    }

    /**
     * Get guest cart
     */
    public function index()
    {
        $cart = session('cart', []);

        return response()->json([
            'status' => 'success',
            'data' => [
                'items' => array_values($cart),
                'total_items' => count($cart),
                'subtotal' => $this->calculateCartTotal($cart),
                'total' => $this->calculateCartTotal($cart), // Add tax/shipping if needed
            ]
        ]);
    }

    /**
     * Remove item from guest cart
     */
    public function removeFromCart($id)
    {
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
    }

    /**
     * Update quantity in guest cart
     */
    public function updateQuantity(Request $request, $id)
    {
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
    }

    /**
     * Clear guest cart
     */
    public function clearCart()
    {
        session()->forget('cart');

        return response()->json([
            'status' => 'success',
            'message' => 'Cart cleared successfully'
        ]);
    }

    /**
     * Get guest cart count
     */
    public function getCount()
    {
        $cart = session('cart', []);

        return response()->json([
            'status' => 'success',
            'data' => [
                'count' => count($cart)
            ]
        ]);
    }

    /**
     * Add item to authenticated user cart (database-based)
     */
    public function addToUserCart(Request $request)
    {
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
        
        if (!$product || $product->status !== 'active') {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not available'
            ], 404);
        }

        // Check if product already exists in user's cart
        $existingCartItem = $user->cart()->where('product_id', $productId)->first();

        if ($existingCartItem) {
            $existingCartItem->update([
                'quantity' => $existingCartItem->quantity + $quantity
            ]);
        } else {
            $user->cart()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        }

        $cartCount = $user->cart()->count();

        return response()->json([
            'status' => 'success',
            'message' => 'Product added to cart',
            'data' => [
                'cart_count' => $cartCount,
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image_path' => $product->image_path,
                    'quantity' => $quantity,
                ]
            ]
        ]);
    }

    /**
     * Get authenticated user cart
     */
    public function userCart()
    {
        $user = auth()->user();
        $cartItems = $user->cart()->with(['product.category', 'product.images'])->get();

        $cartData = $cartItems->map(function ($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'product' => [
                    'id' => $item->product->id,
                    'name' => $item->product->name,
                    'description' => $item->product->description,
                    'image_path' => $item->product->image_path,
                    'category' => $item->product->category ? $item->product->category->name : null,
                ]
            ];
        });

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return response()->json([
            'status' => 'success',
            'data' => [
                'items' => $cartData,
                'total_items' => $cartItems->count(),
                'subtotal' => $subtotal,
                'total' => $subtotal, // Add tax/shipping if needed
            ]
        ]);
    }

    /**
     * Remove item from authenticated user cart
     */
    public function removeFromUserCart($id)
    {
        $user = auth()->user();
        $cartItem = $user->cart()->find($id);

        if ($cartItem) {
            $cartItem->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Item removed from cart',
                'data' => [
                    'cart_count' => $user->cart()->count()
                ]
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Item not found in cart'
        ], 404);
    }

    /**
     * Update quantity in authenticated user cart
     */
    public function updateUserCartQuantity(Request $request, $id)
    {
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
        $cartItem = $user->cart()->find($id);

        if ($cartItem) {
            $cartItem->update(['quantity' => $request->quantity]);

            return response()->json([
                'status' => 'success',
                'message' => 'Quantity updated',
                'data' => [
                    'cart_count' => $user->cart()->count(),
                    'updated_item' => [
                        'id' => $cartItem->id,
                        'product_id' => $cartItem->product_id,
                        'quantity' => $cartItem->quantity,
                        'price' => $cartItem->price,
                    ]
                ]
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Item not found in cart'
        ], 404);
    }

    /**
     * Clear authenticated user cart
     */
    public function clearUserCart()
    {
        $user = auth()->user();
        $user->cart()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Cart cleared successfully'
        ]);
    }

    /**
     * Calculate cart total
     */
    private function calculateCartTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}