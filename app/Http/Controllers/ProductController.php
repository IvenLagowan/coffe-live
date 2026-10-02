<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $ingredients = Ingredient::all();
        return view('products.create', compact('categories', 'ingredients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'is_available' => 'boolean',
            'ingredients' => 'nullable|array',
            'ingredients.*' => 'exists:ingredients,id',
            'quantities' => 'nullable|array',
            'quantities.*' => 'nullable|numeric|min:0',
        ]);

        $product = Product::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'is_available' => $request->has('is_available'),
        ]);

        if ($request->has('ingredients')) {
            $ingredientData = [];
            foreach ($request->ingredients as $index => $ingredientId) {
                if (isset($request->quantities[$index]) && $request->quantities[$index] > 0) {
                    $ingredientData[$ingredientId] = ['quantity_needed' => $request->quantities[$index]];
                }
            }
            $product->ingredients()->sync($ingredientData);
        }

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $ingredients = Ingredient::all();
        return view('products.edit', compact('product', 'categories', 'ingredients'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'is_available' => 'boolean',
            'ingredients' => 'nullable|array',
            'ingredients.*' => 'exists:ingredients,id',
            'quantities' => 'nullable|array',
            'quantities.*' => 'nullable|numeric|min:0',
        ]);

        $product->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'is_available' => $request->has('is_available'),
        ]);

        if ($request->has('ingredients')) {
            $ingredientData = [];
            foreach ($request->ingredients as $index => $ingredientId) {
                if (isset($request->quantities[$index]) && $request->quantities[$index] > 0) {
                    $ingredientData[$ingredientId] = ['quantity_needed' => $request->quantities[$index]];
                }
            }
            $product->ingredients()->sync($ingredientData);
        } else {
            $product->ingredients()->detach();
        }

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}