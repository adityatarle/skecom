<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductCategory;

class AnalyticsController extends Controller
{
    public function sales()
    {
        $today = Carbon::today();
        $startMonth = Carbon::now()->startOfMonth();
        $endMonth = Carbon::now()->endOfMonth();

        $totals = [
            'orders_today' => Order::whereDate('created_at', $today)->count(),
            'revenue_today' => Order::whereDate('created_at', $today)->sum('total_price'),
            'orders_month' => Order::whereBetween('created_at', [$startMonth, $endMonth])->count(),
            'revenue_month' => Order::whereBetween('created_at', [$startMonth, $endMonth])->sum('total_price'),
            'orders_total' => Order::count(),
            'revenue_total' => Order::sum('total_price'),
        ];

        $dailySales = Order::selectRaw('DATE(created_at) as date, COUNT(*) as orders, SUM(total_price) as revenue')
            ->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->selectRaw('products.name, SUM(order_items.quantity) as qty, SUM(order_items.quantity * order_items.price) as revenue')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('qty')
            ->limit(10)
            ->get();

        $categoryPerformance = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->selectRaw('product_categories.name as category, SUM(order_items.quantity) as qty, SUM(order_items.quantity * order_items.price) as revenue')
            ->groupBy('product_categories.id', 'product_categories.name')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get();

        return view('admin.analytics.sales', compact('totals', 'dailySales', 'topProducts', 'categoryPerformance'));
    }

    public function products()
    {
        $productCounts = Product::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $byCategory = ProductCategory::withCount('products')
            ->orderByDesc('products_count')
            ->get(['id','name']);

        $topViewed = Product::orderByDesc('id') // placeholder for views if not tracked
            ->limit(10)
            ->get(['id','name','price']);

        return view('admin.analytics.products', compact('productCounts', 'byCategory', 'topViewed'));
    }

    public function customers()
    {
        $customersWithOrders = DB::table('orders')
            ->selectRaw('email, COUNT(*) as orders, SUM(total_price) as spent, MAX(created_at) as last_order')
            ->groupBy('email')
            ->orderByDesc('spent')
            ->limit(20)
            ->get();

        $signupsLast30 = DB::table('users')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.analytics.customers', compact('customersWithOrders', 'signupsLast30'));
    }
}

