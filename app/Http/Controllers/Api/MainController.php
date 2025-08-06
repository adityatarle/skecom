<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Get home page data
     */
    public function home()
    {
        try {
            // Fix: Remove status filters as 'status' column doesn't exist
            
            // Get featured products
            $featuredProducts = Product::orderBy('created_at', 'desc')
                ->limit(8)
                ->get();

            // Get categories
            $categories = ProductCategory::orderBy('name', 'asc')->get();

            // Get latest products
            $latestProducts = Product::orderBy('created_at', 'desc')
                ->limit(6)
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => [
                    'featured_products' => $featuredProducts,
                    'categories' => $categories,
                    'latest_products' => $latestProducts,
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch home data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get about page content
     */
    public function about()
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'title' => 'About Us',
                'content' => 'Welcome to our ecommerce store. We provide high-quality products with excellent customer service.',
                'mission' => 'To provide the best shopping experience to our customers.',
                'vision' => 'To become the leading ecommerce platform in the region.',
            ]
        ]);
    }

    /**
     * Get contact information
     */
    public function contact()
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'title' => 'Contact Us',
                'address' => '123 Main Street, City, State, Country',
                'phone' => '+1 234 567 8900',
                'email' => 'contact@example.com',
                'working_hours' => 'Monday - Friday: 9:00 AM - 6:00 PM',
            ]
        ]);
    }

    /**
     * Store contact form submission
     */
    public function contactStore(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Here you would typically save the contact form to database
        // For now, we'll just return success

        return response()->json([
            'status' => 'success',
            'message' => 'Thank you for your message. We will get back to you soon.'
        ]);
    }

    /**
     * Get privacy policy
     */
    public function privacyPolicy()
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'title' => 'Privacy Policy',
                'content' => 'This privacy policy describes how we collect, use, and protect your personal information.',
                'last_updated' => '2024-01-01',
            ]
        ]);
    }

    /**
     * Get terms and conditions
     */
    public function termsConditions()
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'title' => 'Terms and Conditions',
                'content' => 'By using our services, you agree to these terms and conditions.',
                'last_updated' => '2024-01-01',
            ]
        ]);
    }

    /**
     * Get shipping policy
     */
    public function shippingPolicy()
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'title' => 'Shipping Policy',
                'content' => 'We offer fast and reliable shipping to all locations.',
                'delivery_time' => '3-5 business days',
                'shipping_cost' => 'Free shipping on orders above $50',
            ]
        ]);
    }

    /**
     * Get return policy
     */
    public function returnPolicy()
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'title' => 'Return Policy',
                'content' => 'We accept returns within 30 days of purchase.',
                'return_period' => '30 days',
                'conditions' => 'Product must be in original condition with all tags attached.',
            ]
        ]);
    }

    /**
     * Admin: Get dashboard statistics
     */
    public function adminDashboard()
    {
        // Get total orders
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'delivered')->count();

        // Get total revenue
        $totalRevenue = Order::where('status', 'delivered')->sum('total_price');

        // Get total users
        $totalUsers = User::where('role', 'customer')->count();
        $newUsers = User::where('role', 'customer')
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        // Get total products
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', 'active')->count();

        // Get recent orders
        $recentOrders = Order::with(['user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get top selling products
        $topProducts = Product::withCount(['orderItems'])
            ->orderBy('order_items_count', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'statistics' => [
                    'total_orders' => $totalOrders,
                    'pending_orders' => $pendingOrders,
                    'completed_orders' => $completedOrders,
                    'total_revenue' => $totalRevenue,
                    'total_users' => $totalUsers,
                    'new_users' => $newUsers,
                    'total_products' => $totalProducts,
                    'active_products' => $activeProducts,
                ],
                'recent_orders' => $recentOrders,
                'top_products' => $topProducts,
            ]
        ]);
    }
}