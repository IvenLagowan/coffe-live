@extends('layouts.app')

@section('title', 'Sales Reports')

@section('content')
<div class="mb-6">
    <h2 class="text-3xl font-bold text-gray-800">Sales Reports</h2>
</div>

<div class="card mb-6">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Filter by Date Range</h3>
    <form method="GET" action="{{ route('reports.index') }}" class="flex flex-wrap gap-4 items-end">
        <div>
            <label class="label">Start Date</label>
            <input type="date" name="start_date" value="{{ $startDate }}" class="input-field">
        </div>
        <div>
            <label class="label">End Date</label>
            <input type="date" name="end_date" value="{{ $endDate }}" class="input-field">
        </div>
        <button type="submit" class="btn-primary">Generate Report</button>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card border-l-4 border-blue-500">
        <h3 class="text-gray-600 text-sm mb-2">Total Orders</h3>
        <p class="text-3xl font-bold text-gray-800">{{ $totalOrders }}</p>
    </div>
    <div class="card border-l-4 border-green-500">
        <h3 class="text-gray-600 text-sm mb-2">Completed Orders</h3>
        <p class="text-3xl font-bold text-green-600">{{ $completedOrders }}</p>
    </div>
    <div class="card border-l-4 border-red-500">
        <h3 class="text-gray-600 text-sm mb-2">Canceled Orders</h3>
        <p class="text-3xl font-bold text-red-600">{{ $canceledOrders }}</p>
    </div>
    <div class="card border-l-4 border-coffee-500">
        <h3 class="text-gray-600 text-sm mb-2">Total Revenue</h3>
        <p class="text-3xl font-bold text-coffee-600">${{ number_format($totalRevenue, 2) }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="card">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Product Sales</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="table-header">
                    <tr>
                        <th class="px-4 py-3 text-left">Product</th>
                        <th class="px-4 py-3 text-left">Quantity Sold</th>
                        <th class="px-4 py-3 text-left">Total Sales</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productSales as $sale)
                        <tr class="table-row">
                            <td class="px-4 py-3 font-semibold">{{ $sale->name }}</td>
                            <td class="px-4 py-3">{{ $sale->total_quantity }}</td>
                            <td class="px-4 py-3 font-bold text-coffee-600">${{ number_format($sale->total_sales, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-gray-500">No sales data available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

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
                    @forelse($orders->take(10) as $order)
                        <tr class="table-row">
                            <td class="px-4 py-3">
                                <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                    {{ $order->order_number }}
                                </a>
                            </td>
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
                            <td class="px-4 py-3 font-bold text-coffee-600">${{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500">No orders in this period</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection