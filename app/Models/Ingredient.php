<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit',
        'quantity_in_stock',
        'minimum_quantity',
    ];

    protected $casts = [
        'quantity_in_stock' => 'decimal:2',
        'minimum_quantity' => 'decimal:2',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'ingredient_product')
            ->withPivot('quantity_needed')
            ->withTimestamps();
    }

    public function isLowStock(): bool
    {
        return $this->quantity_in_stock <= $this->minimum_quantity;
    }

    public function deductStock(float $amount): void
    {
        $this->quantity_in_stock -= $amount;
        $this->save();
    }
}