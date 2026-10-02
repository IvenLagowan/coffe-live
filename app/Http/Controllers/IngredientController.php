<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::all();
        return view('ingredients.index', compact('ingredients'));
    }

    public function create()
    {
        return view('ingredients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'quantity_in_stock' => 'required|numeric|min:0',
            'minimum_quantity' => 'required|numeric|min:0',
        ]);

        Ingredient::create($validated);

        return redirect()->route('ingredients.index')
            ->with('success', 'Ingredient created successfully.');
    }

    public function edit(Ingredient $ingredient)
    {
        return view('ingredients.edit', compact('ingredient'));
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'quantity_in_stock' => 'required|numeric|min:0',
            'minimum_quantity' => 'required|numeric|min:0',
        ]);

        $ingredient->update($validated);

        return redirect()->route('ingredients.index')
            ->with('success', 'Ingredient updated successfully.');
    }

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();
        return redirect()->route('ingredients.index')
            ->with('success', 'Ingredient deleted successfully.');
    }
}