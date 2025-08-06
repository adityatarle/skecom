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
     * List user's orders
     */
    public function index(Request $request)
    {
        try {
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
                'message' => 'Orders retrieved successfully',
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
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve orders',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show a specific order
     */
    public function show($id)
    {
        try {
            $order = Order::with(['orderItems.product'])->find($id);
            if (!$order || $order->user_id !== auth()->id()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order not found or unauthorized'
                ], 404);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Order retrieved successfully',
                'data' => [
                    'order' => $order
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Place a new order
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
            $orderItems = [];
            $totalPrice = 0;
            foreach ($products as $item) {
                $product = Product::find($item['product_id']);
                if (!$product || $product->status !== 'active') {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Product not available',
                        'product_id' => $item['product_id']
                    ], 404);
                }
                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ];
                $totalPrice += $product->price * $item['quantity'];
            }
            $order = Order::create([
                'user_id' => $user->id,
                'products' => json_encode($products),
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
            // Save order items (if you have an order_items table)
            if (method_exists($order, 'orderItems')) {
                foreach ($orderItems as $item) {
                    $order->orderItems()->create($item);
                }
            }
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Order placed successfully',
                'data' => [
                    'order' => $order
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
     * Track an order
     */
    public function track($id)
    {
        try {
            $order = Order::find($id);
            if (!$order || $order->user_id !== auth()->id()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order not found or unauthorized'
                ], 404);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Order status retrieved successfully',
                'data' => [
                    'order_id' => $order->id,
                    'status' => $order->status,
                    'updated_at' => $order->updated_at,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to track order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel an order (if allowed)
     */
    public function cancel($id)
    {
        try {
            $order = Order::find($id);
            if (!$order || $order->user_id !== auth()->id()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order not found or unauthorized'
                ], 404);
            }
            if (!in_array($order->status, ['pending', 'processing'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order cannot be cancelled at this stage'
                ], 400);
            }
            $order->update(['status' => 'cancelled']);
            return response()->json([
                'status' => 'success',
                'message' => 'Order cancelled successfully',
                'data' => [
                    'order' => $order
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to cancel order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Admin: Update order status
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        try {
            $order = Order::find($id);
            if (!$order) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order not found'
                ], 404);
            }
            $order->update(['status' => $request->status]);
            return response()->json([
                'status' => 'success',
                'message' => 'Order status updated successfully',
                'data' => [
                    'order' => $order
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
}