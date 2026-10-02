@extends('layouts.app')

@section('title', 'Create Order')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Create New Order</h2>
    </div>

    <div class="card">
        <form action="{{ route('orders.store') }}" method="POST" id="order-form">
            @csrf
            
            <div class="mb-6">
                <label class="label">Customer Name</label>
                <input type="text" name="customer_name" value="{{ old('customer_name') }}" required class="input-field" placeholder="Enter customer name">
                @error('customer_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="label mb-4">Select Products</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="products-container">
                    @foreach($products as $product)
                        <div class="border border-gray-300 rounded-lg p-4 hover:border-coffee-500 transition product-item">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="font-bold text-gray-800">{{ $product->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $product->category->name }}</p>
                                </div>
                                <p class="text-lg font-bold text-coffee-500">${{ number_format($product->price, 2) }}</p>
                            </div>
                            <p class="text-sm text-gray-600 mb-3">{{ $product->description }}</p>
                            <div class="flex items-center space-x-2">
                                <input type="number" 
                                       class="input-field w-20 product-quantity" 
                                       min="0" 
                                       value="0" 
                                       data-product-id="{{ $product->id }}"
                                       data-product-price="{{ $product->price }}"
                                       placeholder="Qty">
                                <span class="text-sm text-gray-600">Quantity</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-coffee-50 border border-coffee-200 rounded-lg p-6 mb-6">
                <div class="flex justify-between items-center text-xl font-bold">
                    <span class="text-gray-800">Total Amount:</span>
                    <span class="text-coffee-600" id="total-amount">$0.00</span>
                </div>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="btn-primary" id="submit-btn">Create Order</button>
                <a href="{{ route('orders.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInputs = document.querySelectorAll('.product-quantity');
    const totalAmountEl = document.getElementById('total-amount');
    const form = document.getElementById('order-form');
    
    quantityInputs.forEach(input => {
        input.addEventListener('input', calculateTotal);
    });
    
    function calculateTotal() {
        let total = 0;
        quantityInputs.forEach(input => {
            const quantity = parseInt(input.value) || 0;
            const price = parseFloat(input.dataset.productPrice) || 0;
            total += quantity * price;
        });
        totalAmountEl.textContent = '$' + total.toFixed(2);
    }
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const products = [];
        quantityInputs.forEach(input => {
            const quantity = parseInt(input.value) || 0;
            if (quantity > 0) {
                products.push({
                    id: input.dataset.productId,
                    quantity: quantity
                });
            }
        });
        
        if (products.length === 0) {
            alert('Please select at least one product');
            return;
        }
        
        // Add products as hidden inputs
        products.forEach((product, index) => {
            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = `products[${index}][id]`;
            idInput.value = product.id;
            form.appendChild(idInput);
            
            const qtyInput = document.createElement('input');
            qtyInput.type = 'hidden';
            qtyInput.name = `products[${index}][quantity]`;
            qtyInput.value = product.quantity;
            form.appendChild(qtyInput);
        });
        
        form.submit();
    });
});
</script>
@endsection