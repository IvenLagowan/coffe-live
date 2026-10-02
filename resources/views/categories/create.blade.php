@extends('layouts.app')

@section('title', 'Create Category')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Create New Category</h2>
    </div>

    <div class="card">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="label">Category Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="input-field" placeholder="e.g., Hot Drinks">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="label">Description (Optional)</label>
                <textarea name="description" rows="4" class="input-field" placeholder="Brief description of this category">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="btn-primary">Create Category</button>
                <a href="{{ route('categories.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection