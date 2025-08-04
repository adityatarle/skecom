<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    // List all orders
    public function index()
    {
        $orders = Order::latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    // Show order details
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // Delete an order
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }

    // Update order status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->route('admin.orders.show', $order->id)->with('success', 'Order status updated successfully.');
    }

    // Export orders to CSV
    public function export()
    {
        return Excel::download(new OrdersExport, 'orders_' . date('Y-m-d') . '.csv');
    }
}