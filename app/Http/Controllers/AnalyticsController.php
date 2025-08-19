<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function sales()
    {
        return view('admin.analytics.sales');
    }

    public function products()
    {
        return view('admin.analytics.products');
    }

    public function customers()
    {
        return view('admin.analytics.customers');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Subcategory;
use App\Models\Order;
use App\Models\User;
use App\Models\Review;
use App\Models\ProductInquiry;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function dashboard()
    {
        // Get date ranges
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        $thisYear = Carbon::now()->startOfYear();

        // Basic metrics
        $metrics = [
            'total_products' => Product::count(),
            'total_categories' => ProductCategory::count(),
            'total_subcategories' => Subcategory::count(),
            'total_orders' => Order::count(),
            'total_users' => User::count(),
            'total_reviews' => Review::count(),
            'pending_inquiries' => ProductInquiry::whereNull('responded_at')->count(),
        ];

        // Growth metrics (compared to last month)
        $growth = [
            'products' => $this->calculateGrowth(
                Product::whereMonth('created_at', $thisMonth->month)->count(),
                Product::whereMonth('created_at', $lastMonth->month)->count()
            ),
            'orders' => $this->calculateGrowth(
                Order::whereMonth('created_at', $thisMonth->month)->count(),
                Order::whereMonth('created_at', $lastMonth->month)->count()
            ),
            'users' => $this->calculateGrowth(
                User::whereMonth('created_at', $thisMonth->month)->count(),
                User::whereMonth('created_at', $lastMonth->month)->count()
            ),
            'reviews' => $this->calculateGrowth(
                Review::whereMonth('created_at', $thisMonth->month)->count(),
                Review::whereMonth('created_at', $lastMonth->month)->count()
            ),
        ];

        // Recent activities
        $recentActivities = $this->getRecentActivities();

        // Top categories by product count
        $topCategories = ProductCategory::withCount('products')
            ->orderBy('products_count', 'desc')
            ->limit(5)
            ->get();

        // Monthly order trends (last 6 months)
        $orderTrends = $this->getOrderTrends();

        // Sales data (if available)
        $salesData = $this->getSalesData();

        return view('admin.analytics.dashboard', compact(
            'metrics',
            'growth',
            'recentActivities',
            'topCategories',
            'orderTrends',
            'salesData'
        ));
    }

    public function reports()
    {
        return view('admin.analytics.reports');
    }

    public function salesReport(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());

        // Daily sales for the period
        $dailySales = Order::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as orders, SUM(total_amount) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top selling products
        $topProducts = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->selectRaw('products.name, SUM(order_items.quantity) as total_sold, SUM(order_items.quantity * order_items.price) as revenue')
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        // Category performance
        $categoryPerformance = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->selectRaw('product_categories.name, COUNT(*) as orders, SUM(order_items.quantity * order_items.price) as revenue')
            ->groupBy('product_categories.id', 'product_categories.name')
            ->orderBy('revenue', 'desc')
            ->get();

        return response()->json([
            'daily_sales' => $dailySales,
            'top_products' => $topProducts,
            'category_performance' => $categoryPerformance
        ]);
    }

    public function inventoryReport()
    {
        // Products with low stock (if stock management is implemented)
        $lowStockProducts = Product::where('stock_quantity', '<', 10)
            ->orWhereNull('stock_quantity')
            ->with('category')
            ->get();

        // Products by category
        $productsByCategory = ProductCategory::withCount('products')
            ->orderBy('products_count', 'desc')
            ->get();

        // Recently added products
        $recentProducts = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.analytics.inventory', compact(
            'lowStockProducts',
            'productsByCategory',
            'recentProducts'
        ));
    }

    public function customerReport()
    {
        // Customer metrics
        $customerMetrics = [
            'total_customers' => User::where('role', '!=', 'admin')->count(),
            'new_customers_this_month' => User::where('role', '!=', 'admin')
                ->whereMonth('created_at', Carbon::now()->month)
                ->count(),
            'active_customers' => User::where('role', '!=', 'admin')
                ->whereHas('orders')
                ->count(),
        ];

        // Top customers by orders
        $topCustomers = User::where('role', '!=', 'admin')
            ->withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->limit(10)
            ->get();

        // Customer registration trends
        $registrationTrends = User::where('role', '!=', 'admin')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as registrations')
            ->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.analytics.customers', compact(
            'customerMetrics',
            'topCustomers',
            'registrationTrends'
        ));
    }

    private function calculateGrowth($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        return round((($current - $previous) / $previous) * 100, 1);
    }

    private function getRecentActivities()
    {
        $activities = collect();

        // Recent orders
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get()
            ->map(function ($order) {
                return [
                    'type' => 'order',
                    'title' => 'New Order Received',
                    'description' => "Order #{$order->id} from {$order->user->name}",
                    'time' => $order->created_at->diffForHumans(),
                    'icon' => 'shopping-cart',
                    'color' => 'primary'
                ];
            });

        // Recent products
        $recentProducts = Product::orderBy('created_at', 'desc')
            ->limit(2)
            ->get()
            ->map(function ($product) {
                return [
                    'type' => 'product',
                    'title' => 'New Product Added',
                    'description' => "Product '{$product->name}' was added",
                    'time' => $product->created_at->diffForHumans(),
                    'icon' => 'box',
                    'color' => 'success'
                ];
            });

        // Recent reviews
        $recentReviews = Review::with('product', 'user')
            ->orderBy('created_at', 'desc')
            ->limit(2)
            ->get()
            ->map(function ($review) {
                return [
                    'type' => 'review',
                    'title' => 'New Review Posted',
                    'description' => "{$review->user->name} reviewed {$review->product->name}",
                    'time' => $review->created_at->diffForHumans(),
                    'icon' => 'star',
                    'color' => 'warning'
                ];
            });

        return $activities->concat($recentOrders)
            ->concat($recentProducts)
            ->concat($recentReviews)
            ->sortByDesc('time')
            ->take(10)
            ->values();
    }

    private function getOrderTrends()
    {
        return Order::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as count')
            ->whereBetween('created_at', [Carbon::now()->subMonths(6), Carbon::now()])
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => Carbon::createFromDate($item->year, $item->month, 1)->format('M Y'),
                    'count' => $item->count
                ];
            });
    }

    private function getSalesData()
    {
        // This would contain actual sales data if order amounts are tracked
        return [
            'total_revenue' => Order::sum('total_amount') ?? 0,
            'monthly_revenue' => Order::whereMonth('created_at', Carbon::now()->month)
                ->sum('total_amount') ?? 0,
            'average_order_value' => Order::avg('total_amount') ?? 0,
        ];
    }
}
