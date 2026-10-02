@extends('layouts.app')

@section('title', 'Edit Ingredient')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Edit Ingredient</h2>
    </div>

    <div class="card">
        <form action="{{ route('ingredients.update', $ingredient) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="label">Ingredient Name</label>
                    <input type="text" name="name" value="{{ old('name', $ingredient->name) }}" required class="input-field">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="label">Unit of Measurement</label>
                    <select name="unit" required class="input-field">
                        <option value="">Select Unit</option>
                        <option value="g" {{ old('unit', $ingredient->unit) == 'g' ? 'selected' : '' }}>Grams (g)</option>
                        <option value="kg" {{ old('unit', $ingredient->unit) == 'kg' ? 'selected' : '' }}>Kilograms (kg)</option>
                        <option value="ml" {{ old('unit', $ingredient->unit) == 'ml' ? 'selected' : '' }}>Milliliters (ml)</option>
                        <option value="l" {{ old('unit', $ingredient->unit) == 'l' ? 'selected' : '' }}>Liters (l)</option>
                        <option value="pcs" {{ old('unit', $ingredient->unit) == 'pcs' ? 'selected' : '' }}>Pieces (pcs)</option>
                    </select>
                    @error('unit')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="label">Quantity in Stock</label>
                    <input type="number" step="0.01" name="quantity_in_stock" value="{{ old('quantity_in_stock', $ingredient->quantity_in_stock) }}" required class="input-field">
                    @error('quantity_in_stock')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="label">Minimum Quantity (Alert Threshold)</label>
                    <input type="number" step="0.01" name="minimum_quantity" value="{{ old('minimum_quantity', $ingredient->minimum_quantity) }}" required class="input-field">
                    @error('minimum_quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="btn-primary">Update Ingredient</button>
                <a href="{{ route('ingredients.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection