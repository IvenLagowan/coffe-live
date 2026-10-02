@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Edit Category</h2>
    </div>

    <div class="card">
        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="label">Category Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="input-field">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="label">Description (Optional)</label>
                <textarea name="description" rows="4" class="input-field">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="btn-primary">Update Category</button>
                <a href="{{ route('categories.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection