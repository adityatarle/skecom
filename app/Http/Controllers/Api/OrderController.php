<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Get user's orders
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $perPage = $request->get('per_page', 10);
        $status = $request->get('status');

        $query = $user->orders();

        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => [
                'orders' => $orders->items(),
                'pagination' => [
                    'current_page' => $orders->currentPage(),
                    'last_page' => $orders->lastPage(),
                    'per_page' => $orders->perPage(),
                    'total' => $orders->total(),
                ]
            ]
        ]);
    }

    /**
     * Get specific order
     */
    public function show(Order $order)
    {
        // Check if user owns this order
        if ($order->user_id !== auth()->id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access'
            ], 403);
        }

        $order->load(['orderItems.product']);

        return response()->json([
            'status' => 'success',
            'data' => [
                'order' => $order
            ]
        ]);
    }

    /**
     * Create new order
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'street_address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'payment_method' => 'required|in:cash_on_delivery,razorpay',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $user = auth()->user();
            $products = $request->products;
            $totalPrice = 0;
            $orderProducts = [];

            // Calculate total and validate products
            foreach ($products as $item) {
                $product = Product::find($item['product_id']);
                
                if (!$product || $product->status !== 'active') {
                    throw new \Exception("Product {$product->name} is not available");
                }

                $price = $product->price;
                $quantity = $item['quantity'];
                $subtotal = $price * $quantity;
                $totalPrice += $subtotal;

                $orderProducts[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $price,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ];
            }

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'products' => $orderProducts,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'street_address' => $request->street_address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
            ]);

            // Create order items
            foreach ($orderProducts as $item) {
                $order->orderItems()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            // Clear user's cart after successful order
            $user->cart()->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Order placed successfully',
                'data' => [
                    'order' => $order->load(['orderItems.product']),
                    'order_id' => $order->id,
                    'total_amount' => $totalPrice,
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to place order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reorder - add all items from a previous order to cart
     */
    public function reorder(Order $order)
    {
        // Check if user owns this order
        if ($order->user_id !== auth()->id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access'
            ], 403);
        }

        try {
            $user = auth()->user();
            $addedItems = 0;

            foreach ($order->products as $item) {
                $product = Product::find($item['product_id']);
                
                if ($product && $product->status === 'active') {
                    // Check if product already exists in cart
                    $existingCartItem = $user->cart()->where('product_id', $product->id)->first();

                    if ($existingCartItem) {
                        $existingCartItem->update([
                            'quantity' => $existingCartItem->quantity + $item['quantity']
                        ]);
                    } else {
                        $user->cart()->create([
                            'product_id' => $product->id,
                            'quantity' => $item['quantity'],
                            'price' => $product->price,
                        ]);
                    }
                    $addedItems++;
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => "Added {$addedItems} items to cart",
                'data' => [
                    'items_added' => $addedItems,
                    'cart_count' => $user->cart()->count()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to reorder',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Track order status
     */
    public function track(Order $order)
    {
        // Check if user owns this order
        if ($order->user_id !== auth()->id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access'
            ], 403);
        }

        $statusHistory = [
            'pending' => 'Order placed and awaiting confirmation',
            'confirmed' => 'Order confirmed and being processed',
            'processing' => 'Order is being prepared',
            'shipped' => 'Order has been shipped',
            'delivered' => 'Order has been delivered',
            'cancelled' => 'Order has been cancelled',
            'failed' => 'Order payment failed',
        ];

        return response()->json([
            'status' => 'success',
            'data' => [
                'order_id' => $order->id,
                'current_status' => $order->status,
                'status_description' => $statusHistory[$order->status] ?? 'Unknown status',
                'order_date' => $order->created_at,
                'last_updated' => $order->updated_at,
                'estimated_delivery' => $this->getEstimatedDelivery($order),
            ]
        ]);
    }

    /**
     * Admin: Get all orders
     */
    public function adminIndex(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $status = $request->get('status');
        $search = $request->get('search');

        $query = Order::with(['user', 'orderItems.product']);

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%");
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => [
                'orders' => $orders->items(),
                'pagination' => [
                    'current_page' => $orders->currentPage(),
                    'last_page' => $orders->lastPage(),
                    'per_page' => $orders->perPage(),
                    'total' => $orders->total(),
                ]
            ]
        ]);
    }

    /**
     * Admin: Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled,failed',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $order->update([
                'status' => $request->status,
                'notes' => $request->notes,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Order status updated successfully',
                'data' => [
                    'order' => $order->load(['user', 'orderItems.product'])
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update order status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Admin: Delete order
     */
    public function destroy(Order $order)
    {
        try {
            $order->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Order deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get estimated delivery date
     */
    private function getEstimatedDelivery($order)
    {
        $orderDate = $order->created_at;
        
        switch ($order->status) {
            case 'pending':
            case 'confirmed':
                return $orderDate->addDays(7)->format('Y-m-d');
            case 'processing':
                return $orderDate->addDays(5)->format('Y-m-d');
            case 'shipped':
                return $orderDate->addDays(2)->format('Y-m-d');
            case 'delivered':
                return 'Delivered on ' . $order->updated_at->format('Y-m-d');
            default:
                return null;
        }
    }
}