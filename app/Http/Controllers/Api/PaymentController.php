<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    /**
     * Create Razorpay order
     */
    public function createOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|string|size:3',
            'receipt' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $razorpay = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            $orderData = [
                'receipt' => $request->receipt,
                'amount' => $request->amount * 100, // Convert to paise
                'currency' => $request->currency,
                'notes' => [
                    'source' => 'mobile_app'
                ]
            ];

            $razorpayOrder = $razorpay->order->create($orderData);

            return response()->json([
                'status' => 'success',
                'message' => 'Payment order created successfully',
                'data' => [
                    'order_id' => $razorpayOrder->id,
                    'amount' => $razorpayOrder->amount,
                    'currency' => $razorpayOrder->currency,
                    'receipt' => $razorpayOrder->receipt,
                    'key' => env('RAZORPAY_KEY'),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create payment order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify payment signature
     */
    public function verifyPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'razorpay_order_id' => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature' => 'required|string',
            'order_id' => 'required|exists:orders,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $razorpay = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            // Verify signature
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ];

            $razorpay->utility->verifyPaymentSignature($attributes);

            // Update order with payment details
            $order = Order::find($request->order_id);
            
            // Check if user owns this order
            if ($order->user_id !== auth()->id()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $order->update([
                'status' => 'confirmed',
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Payment verified successfully',
                'data' => [
                    'order' => $order->load(['orderItems.product']),
                    'payment_id' => $request->razorpay_payment_id,
                    'order_id' => $request->razorpay_order_id,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment verification failed',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}