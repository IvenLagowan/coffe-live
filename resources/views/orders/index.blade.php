@extends('layouts.app')

@section('title', 'Orders')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold text-gray-800">Orders</h2>
    <a href="{{ route('orders.create') }}" class="btn-primary">➕ New Order</a>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="table-header">
                <tr>
                    <th class="px-4 py-3 text-left">Order #</th>
                    <th class="px-4 py-3 text-left">Customer</th>
                    <th class="px-4 py-3 text-left">Items</th>
                    <th class="px-4 py-3 text-left">Total</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Created By</th>
                    <th class="px-4 py-3 text-left">Date</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="table-row">
                        <td class="px-4 py-3 font-semibold">{{ $order->order_number }}</td>
                        <td class="px-4 py-3">{{ $order->customer_name }}</td>
                        <td class="px-4 py-3">{{ $order->orderItems->count() }} items</td>
                        <td class="px-4 py-3 font-bold text-coffee-600">${{ number_format($order->total_amount, 2) }}</td>
                        <td class="px-4 py-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($order->status === 'completed') bg-green-100 text-green-800
                                @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $order->user->name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $order->created_at->format('M d, Y H:i') }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:text-blue-800 font-semibold">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-500">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection