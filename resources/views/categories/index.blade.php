@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold text-gray-800">Categories</h2>
    <a href="{{ route('categories.create') }}" class="btn-primary">➕ Add Category</a>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="table-header">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Description</th>
                    <th class="px-4 py-3 text-left">Products</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr class="table-row">
                        <td class="px-4 py-3">{{ $category->id }}</td>
                        <td class="px-4 py-3 font-semibold">{{ $category->name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $category->description ?? 'N/A' }}</td>
                        <td class="px-4 py-3">
                            <span class="bg-coffee-100 text-coffee-800 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $category->products_count }} products
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-2">
                                <a href="{{ route('categories.edit', $category) }}" class="text-blue-600 hover:text-blue-800 font-semibold">Edit</a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">No categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection