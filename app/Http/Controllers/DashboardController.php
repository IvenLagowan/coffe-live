<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Ingredient;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $todayOrders = Order::whereDate('created_at', today())->count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        $todayRevenue = Order::where('status', 'completed')
            ->whereDate('created_at', today())
            ->sum('total_amount');
        
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();
        
        $lowStockIngredients = Ingredient::whereColumn('quantity_in_stock', '<=', 'minimum_quantity')
            ->get();
        
        $totalProducts = Product::count();
        $totalStaff = User::where('role', 'staff')->count();

        return view('dashboard', compact(
            'totalOrders',
            'todayOrders',
            'totalRevenue',
            'todayRevenue',
            'recentOrders',
            'lowStockIngredients',
            'totalProducts',
            'totalStaff'
        ));
    }
}