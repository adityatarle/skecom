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

        // Aggregate top products and categories from JSON cart stored in orders.products
        $ordersForAggregation = Order::whereBetween('created_at', [Carbon::now()->subMonths(6), Carbon::now()])->get(['products']);

        $productTotals = [];
        $allProductIds = [];
        foreach ($ordersForAggregation as $order) {
            if (!is_array($order->products)) {
                continue;
            }
            foreach ($order->products as $productId => $data) {
                $quantity = (int)($data['quantity'] ?? 0);
                $price = (float)($data['price'] ?? 0);
                if ($quantity <= 0) continue;
                if (!isset($productTotals[$productId])) {
                    $productTotals[$productId] = ['qty' => 0, 'revenue' => 0.0];
                }
                $productTotals[$productId]['qty'] += $quantity;
                $productTotals[$productId]['revenue'] += $quantity * $price;
                $allProductIds[] = (int)$productId;
            }
        }

        $allProductIds = array_values(array_unique($allProductIds));
        $productMeta = Product::whereIn('id', $allProductIds)->get(['id','name','category_id'])->keyBy('id');

        // Build top products list
        $topProducts = collect($productTotals)
            ->map(function ($stats, $productId) use ($productMeta) {
                $meta = $productMeta->get((int)$productId);
                return (object) [
                    'id' => (int)$productId,
                    'name' => $meta?->name ?? ('Product #'.$productId),
                    'qty' => $stats['qty'],
                    'revenue' => $stats['revenue'],
                    'category_id' => $meta?->category_id,
                ];
            })
            ->sortByDesc('qty')
            ->take(10)
            ->values();

        // Category performance
        $categoryAgg = [];
        if ($productMeta->isNotEmpty()) {
            foreach ($productTotals as $productId => $stats) {
                $categoryId = optional($productMeta->get((int)$productId))->category_id;
                if (!$categoryId) continue;
                if (!isset($categoryAgg[$categoryId])) {
                    $categoryAgg[$categoryId] = ['qty' => 0, 'revenue' => 0.0];
                }
                $categoryAgg[$categoryId]['qty'] += $stats['qty'];
                $categoryAgg[$categoryId]['revenue'] += $stats['revenue'];
            }
        }

        $categoryNames = ProductCategory::whereIn('id', array_keys($categoryAgg))->pluck('name','id');
        $categoryPerformance = collect($categoryAgg)
            ->map(function ($stats, $categoryId) use ($categoryNames) {
                return (object) [
                    'category' => $categoryNames[$categoryId] ?? ('Category #'.$categoryId),
                    'qty' => $stats['qty'],
                    'revenue' => $stats['revenue'],
                ];
            })
            ->sortByDesc('revenue')
            ->take(10)
            ->values();

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

