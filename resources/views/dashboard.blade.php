@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h2 class="text-3xl font-bold text-gray-800">Dashboard</h2>
    <p class="text-gray-600">Welcome back, {{ auth()->user()->name }}!</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-coffee-500">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-gray-600 text-sm">Total Orders</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalOrders }}</p>
            </div>
            <div class="text-coffee-500 text-4xl">📦</div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-gray-600 text-sm">Today's Orders</p>
                <p class="text-3xl font-bold text-gray-800">{{ $todayOrders }}</p>
            </div>
            <div class="text-blue-500 text-4xl">📋</div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-gray-600 text-sm">Total Revenue</p>
                <p class="text-3xl font-bold text-gray-800">${{ number_format($totalRevenue, 2) }}</p>
            </div>
            <div class="text-green-500 text-4xl">💰</div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-gray-600 text-sm">Today's Revenue</p>
                <p class="text-3xl font-bold text-gray-800">${{ number_format($todayRevenue, 2) }}</p>
            </div>
            <div class="text-yellow-500 text-4xl">💵</div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Orders -->
    <div class="card">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Recent Orders</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="table-header">
                    <tr>
                        <th class="px-4 py-3 text-left">Order #</th>
                        <th class="px-4 py-3 text-left">Customer</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr class="table-row">
                            <td class="px-4 py-3">{{ $order->order_number }}</td>
                            <td class="px-4 py-3">{{ $order->customer_name }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    @if($order->status === 'completed') bg-green-100 text-green-800
                                    @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">${{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-center text-gray-500">No orders yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            <a href="{{ route('orders.index') }}" class="text-coffee-500 hover:text-coffee-600 font-semibold">View All Orders →</a>
        </div>
    </div>

    <!-- Low Stock Alerts -->
    @if(auth()->user()->isAdmin())
        <div class="card">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Low Stock Alerts</h3>
            @if($lowStockIngredients->count() > 0)
                <div class="space-y-3">
                    @foreach($lowStockIngredients as $ingredient)
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $ingredient->name }}</p>
                                    <p class="text-sm text-gray-600">Current: {{ $ingredient->quantity_in_stock }} {{ $ingredient->unit }}</p>
                                </div>
                                <span class="text-red-600 font-bold">⚠️</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <a href="{{ route('ingredients.index') }}" class="text-coffee-500 hover:text-coffee-600 font-semibold">Manage Inventory →</a>
                </div>
            @else
                <p class="text-green-600">✅ All ingredients are well stocked!</p>
            @endif
        </div>
    @endif
</div>

<!-- Quick Actions -->
<div class="mt-8">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h3>
    <div class="flex flex-wrap gap-4">
        <a href="{{ route('orders.create') }}" class="btn-primary">➕ New Order</a>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('products.create') }}" class="btn-secondary">➕ New Product</a>
            <a href="{{ route('reports.index') }}" class="btn-secondary">📊 View Reports</a>
        @endif
    </div>
</div>
@endsection