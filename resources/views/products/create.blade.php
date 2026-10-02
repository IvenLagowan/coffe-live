@extends('layouts.app')

@section('title', 'Create Product')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Create New Product</h2>
    </div>

    <div class="card">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="label">Product Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="input-field" placeholder="e.g., Cappuccino">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="label">Category</label>
                    <select name="category_id" required class="input-field">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="label">Description</label>
                <textarea name="description" rows="3" class="input-field" placeholder="Brief description">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="label">Price ($)</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" required class="input-field" placeholder="0.00">
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="flex items-center pt-8">
                        <input type="checkbox" name="is_available" value="1" {{ old('is_available', true) ? 'checked' : '' }} class="mr-2">
                        <span class="text-gray-700 font-semibold">Available for sale</span>
                    </label>
                </div>
            </div>

            <div class="mb-6">
                <label class="label">Ingredients (Optional)</label>
                <div id="ingredients-container" class="space-y-2">
                    <div class="flex gap-2 ingredient-row">
                        <select name="ingredients[]" class="input-field flex-1">
                            <option value="">Select Ingredient</option>
                            @foreach($ingredients as $ingredient)
                                <option value="{{ $ingredient->id }}">{{ $ingredient->name }} ({{ $ingredient->unit }})</option>
                            @endforeach
                        </select>
                        <input type="number" step="0.01" name="quantities[]" placeholder="Quantity" class="input-field w-32">
                        <button type="button" onclick="removeIngredient(this)" class="btn-danger">Remove</button>
                    </div>
                </div>
                <button type="button" onclick="addIngredient()" class="btn-secondary mt-2">+ Add Ingredient</button>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="btn-primary">Create Product</button>
                <a href="{{ route('products.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
function addIngredient() {
    const container = document.getElementById('ingredients-container');
    const newRow = container.firstElementChild.cloneNode(true);
    newRow.querySelectorAll('input, select').forEach(el => el.value = '');
    container.appendChild(newRow);
}

function removeIngredient(btn) {
    const container = document.getElementById('ingredients-container');
    if (container.children.length > 1) {
        btn.closest('.ingredient-row').remove();
    }
}
</script>
@endsection