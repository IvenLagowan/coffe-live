<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', today()->toDateString());
        $endDate = $request->input('end_date', today()->toDateString());

        $orders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->with('orderItems.product')
            ->get();

        $totalOrders = $orders->count();
        $completedOrders = $orders->where('status', 'completed')->count();
        $canceledOrders = $orders->where('status', 'canceled')->count();
        $totalRevenue = $orders->where('status', 'completed')->sum('total_amount');

        $productSales = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', 'completed')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_quantity'), DB::raw('SUM(order_items.subtotal) as total_sales'))
            ->groupBy('products.name')
            ->orderByDesc('total_quantity')
            ->get();

        return view('reports.index', compact(
            'orders',
            'totalOrders',
            'completedOrders',
            'canceledOrders',
            'totalRevenue',
            'productSales',
            'startDate',
            'endDate'
        ));
    }
}