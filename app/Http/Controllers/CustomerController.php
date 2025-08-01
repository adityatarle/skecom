<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', '!=', 'admin');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by registration date
        if ($request->has('date_filter')) {
            switch ($request->date_filter) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', Carbon::now()->month);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', Carbon::now()->subMonth()->month);
                    break;
            }
        }

        // Filter by status
        if ($request->has('status')) {
            switch ($request->status) {
                case 'active':
                    $query->whereHas('orders');
                    break;
                case 'inactive':
                    $query->whereDoesntHave('orders');
                    break;
            }
        }

        $customers = $query->withCount('orders')
                          ->withSum('orders', 'total_price')
                          ->orderBy('created_at', 'desc')
                          ->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer)
    {
        $customer->load(['orders' => function($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        // Get customer statistics
        $stats = [
            'total_orders' => $customer->orders->count(),
            'total_spent' => $customer->orders->sum('total_price'),
            'average_order_value' => $customer->orders->count() > 0 ? 
                round($customer->orders->sum('total_price') / $customer->orders->count(), 2) : 0,
            'last_order_date' => $customer->orders->first() ? 
                $customer->orders->first()->created_at->format('M d, Y') : 'No orders',
            'days_since_registration' => Carbon::now()->diffInDays($customer->created_at),
        ];

        return view('admin.customers.show', compact('customer', 'stats'));
    }

    public function groups()
    {
        // Customer groups based on spending
        $customerGroups = [
            'vip' => User::where('role', '!=', 'admin')
                        ->whereHas('orders', function($query) {
                            $query->where('total_price', '>=', 1000);
                        })
                        ->withCount('orders')
                        ->withSum('orders', 'total_price')
                        ->get(),
            
            'regular' => User::where('role', '!=', 'admin')
                           ->whereHas('orders', function($query) {
                               $query->where('total_price', '>=', 100)
                                     ->where('total_price', '<', 1000);
                           })
                           ->withCount('orders')
                           ->withSum('orders', 'total_price')
                           ->get(),
            
            'new' => User::where('role', '!=', 'admin')
                        ->whereHas('orders', function($query) {
                            $query->where('total_price', '<', 100);
                        })
                        ->withCount('orders')
                        ->withSum('orders', 'total_price')
                        ->get(),
            
            'inactive' => User::where('role', '!=', 'admin')
                             ->whereDoesntHave('orders')
                             ->get(),
        ];

        return view('admin.customers.groups', compact('customerGroups'));
    }

    public function export(Request $request)
    {
        $customers = User::where('role', '!=', 'admin')
                        ->withCount('orders')
                        ->withSum('orders', 'total_price')
                        ->get();

        $filename = 'customers_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($customers) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, [
                'ID', 'Name', 'Email', 'Phone', 'Registration Date', 
                'Total Orders', 'Total Spent', 'Last Order Date'
            ]);

            // Add data
            foreach ($customers as $customer) {
                $lastOrder = $customer->orders()->latest()->first();
                fputcsv($file, [
                    $customer->id,
                    $customer->name,
                    $customer->email,
                    $customer->phone ?? 'N/A',
                    $customer->created_at->format('Y-m-d'),
                    $customer->orders_count,
                    $customer->orders_sum_total_price ?? 0,
                    $lastOrder ? $lastOrder->created_at->format('Y-m-d') : 'No orders'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}