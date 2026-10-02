@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold text-gray-800">Products</h2>
    <a href="{{ route('products.create') }}" class="btn-primary">➕ Add Product</a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($products as $product)
        <div class="card hover:shadow-lg transition">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $product->category->name }}</p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-semibold 
                    {{ $product->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $product->is_available ? 'Available' : 'Unavailable' }}
                </span>
            </div>
            
            <p class="text-gray-600 mb-4">{{ $product->description }}</p>
            
            <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                <p class="text-2xl font-bold text-coffee-500">${{ number_format($product->price, 2) }}</p>
                <div class="flex space-x-2">
                    <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:text-blue-800 font-semibold">Edit</a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-3">
            <div class="card text-center py-12">
                <p class="text-gray-500 text-lg">No products found.</p>
                <a href="{{ route('products.create') }}" class="btn-primary mt-4 inline-block">Create Your First Product</a>
            </div>
        </div>
    @endforelse
</div>
@endsection