@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Order Details</h2>
        <a href="{{ route('orders.index') }}" class="btn-secondary">← Back to Orders</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="card">
            <h3 class="font-semibold text-gray-600 mb-2">Order Number</h3>
            <p class="text-2xl font-bold text-gray-800">{{ $order->order_number }}</p>
        </div>
        <div class="card">
            <h3 class="font-semibold text-gray-600 mb-2">Customer</h3>
            <p class="text-2xl font-bold text-gray-800">{{ $order->customer_name }}</p>
        </div>
        <div class="card">
            <h3 class="font-semibold text-gray-600 mb-2">Total Amount</h3>
            <p class="text-2xl font-bold text-coffee-600">${{ number_format($order->total_amount, 2) }}</p>
        </div>
    </div>

    <div class="card mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-800">Order Status</h3>
            <span class="px-4 py-2 rounded-full text-sm font-semibold
                @if($order->status === 'completed') bg-green-100 text-green-800
                @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                @else bg-red-100 text-red-800
                @endif">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        @if($order->status !== 'canceled')
            <form action="{{ route('orders.updateStatus', $order) }}" method="POST" class="flex space-x-2">
                @csrf
                <select name="status" class="input-field flex-1">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="canceled" {{ $order->status === 'canceled' ? 'selected' : '' }}>Canceled</option>
                </select>
                <button type="submit" class="btn-primary">Update Status</button>
            </form>
        @endif

        <div class="mt-4 pt-4 border-t border-gray-200 text-sm text-gray-600">
            <p>Created by: <span class="font-semibold">{{ $order->user->name }}</span></p>
            <p>Created at: <span class="font-semibold">{{ $order->created_at->format('F d, Y H:i:s') }}</span></p>
        </div>
    </div>

    <div class="card">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Order Items</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="table-header">
                    <tr>
                        <th class="px-4 py-3 text-left">Product</th>
                        <th class="px-4 py-3 text-left">Price</th>
                        <th class="px-4 py-3 text-left">Quantity</th>
                        <th class="px-4 py-3 text-left">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                        <tr class="table-row">
                            <td class="px-4 py-3">
                                <div>
                                    <p class="font-semibold">{{ $item->product->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $item->product->category->name }}</p>
                                </div>
                            </td>
                            <td class="px-4 py-3">${{ number_format($item->price, 2) }}</td>
                            <td class="px-4 py-3">{{ $item->quantity }}</td>
                            <td class="px-4 py-3 font-bold text-coffee-600">${{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="px-4 py-4 text-right font-bold text-gray-800">Total:</td>
                        <td class="px-4 py-4 font-bold text-2xl text-coffee-600">${{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="mt-6 flex space-x-4">
        @if($order->status !== 'completed')
            <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">Delete Order</button>
            </form>
        @endif
    </div>
</div>
@endsection