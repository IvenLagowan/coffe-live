@extends('layouts.app')

@section('title', 'Ingredients')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold text-gray-800">Ingredients Inventory</h2>
    <a href="{{ route('ingredients.create') }}" class="btn-primary">➕ Add Ingredient</a>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="table-header">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Unit</th>
                    <th class="px-4 py-3 text-left">Stock</th>
                    <th class="px-4 py-3 text-left">Min. Stock</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ingredients as $ingredient)
                    <tr class="table-row {{ $ingredient->isLowStock() ? 'bg-red-50' : '' }}">
                        <td class="px-4 py-3">{{ $ingredient->id }}</td>
                        <td class="px-4 py-3 font-semibold">{{ $ingredient->name }}</td>
                        <td class="px-4 py-3">{{ $ingredient->unit }}</td>
                        <td class="px-4 py-3 {{ $ingredient->isLowStock() ? 'text-red-600 font-bold' : 'text-gray-800' }}">
                            {{ $ingredient->quantity_in_stock }} {{ $ingredient->unit }}
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $ingredient->minimum_quantity }} {{ $ingredient->unit }}</td>
                        <td class="px-4 py-3">
                            @if($ingredient->isLowStock())
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">
                                    ⚠️ Low Stock
                                </span>
                            @else
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                    ✅ In Stock
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-2">
                                <a href="{{ route('ingredients.edit', $ingredient) }}" class="text-blue-600 hover:text-blue-800 font-semibold">Edit</a>
                                <form action="{{ route('ingredients.destroy', $ingredient) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">No ingredients found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection