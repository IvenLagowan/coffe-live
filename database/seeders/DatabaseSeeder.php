<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@lifecaffe.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create Staff User
        User::create([
            'name' => 'Staff User',
            'email' => 'staff@lifecaffe.com',
            'password' => bcrypt('password'),
            'role' => 'staff',
        ]);

        // Create Categories
        $hotDrinks = Category::create([
            'name' => 'Hot Drinks',
            'description' => 'Freshly brewed hot beverages',
        ]);

        $coldDrinks = Category::create([
            'name' => 'Cold Drinks',
            'description' => 'Refreshing iced beverages',
        ]);

        $pastries = Category::create([
            'name' => 'Pastries',
            'description' => 'Delicious baked goods',
        ]);

        // Create Ingredients
        $coffeeBeans = Ingredient::create([
            'name' => 'Coffee Beans',
            'unit' => 'g',
            'quantity_in_stock' => 5000,
            'minimum_quantity' => 500,
        ]);

        $milk = Ingredient::create([
            'name' => 'Milk',
            'unit' => 'ml',
            'quantity_in_stock' => 10000,
            'minimum_quantity' => 1000,
        ]);

        $sugar = Ingredient::create([
            'name' => 'Sugar',
            'unit' => 'g',
            'quantity_in_stock' => 2000,
            'minimum_quantity' => 200,
        ]);

        $chocolate = Ingredient::create([
            'name' => 'Chocolate Syrup',
            'unit' => 'ml',
            'quantity_in_stock' => 1500,
            'minimum_quantity' => 150,
        ]);

        $ice = Ingredient::create([
            'name' => 'Ice',
            'unit' => 'g',
            'quantity_in_stock' => 8000,
            'minimum_quantity' => 1000,
        ]);

        // Create Products - Hot Drinks
        $espresso = Product::create([
            'category_id' => $hotDrinks->id,
            'name' => 'Espresso',
            'description' => 'Strong and bold coffee shot',
            'price' => 2.50,
            'is_available' => true,
        ]);
        $espresso->ingredients()->attach([
            $coffeeBeans->id => ['quantity_needed' => 18],
        ]);

        $cappuccino = Product::create([
            'category_id' => $hotDrinks->id,
            'name' => 'Cappuccino',
            'description' => 'Espresso with steamed milk and foam',
            'price' => 4.00,
            'is_available' => true,
        ]);
        $cappuccino->ingredients()->attach([
            $coffeeBeans->id => ['quantity_needed' => 18],
            $milk->id => ['quantity_needed' => 150],
        ]);

        $latte = Product::create([
            'category_id' => $hotDrinks->id,
            'name' => 'Latte',
            'description' => 'Espresso with steamed milk',
            'price' => 4.50,
            'is_available' => true,
        ]);
        $latte->ingredients()->attach([
            $coffeeBeans->id => ['quantity_needed' => 18],
            $milk->id => ['quantity_needed' => 200],
        ]);

        $mocha = Product::create([
            'category_id' => $hotDrinks->id,
            'name' => 'Mocha',
            'description' => 'Chocolate-flavored latte',
            'price' => 5.00,
            'is_available' => true,
        ]);
        $mocha->ingredients()->attach([
            $coffeeBeans->id => ['quantity_needed' => 18],
            $milk->id => ['quantity_needed' => 200],
            $chocolate->id => ['quantity_needed' => 30],
        ]);

        // Create Products - Cold Drinks
        $icedCoffee = Product::create([
            'category_id' => $coldDrinks->id,
            'name' => 'Iced Coffee',
            'description' => 'Chilled coffee with ice',
            'price' => 3.50,
            'is_available' => true,
        ]);
        $icedCoffee->ingredients()->attach([
            $coffeeBeans->id => ['quantity_needed' => 20],
            $ice->id => ['quantity_needed' => 100],
        ]);

        $icedLatte = Product::create([
            'category_id' => $coldDrinks->id,
            'name' => 'Iced Latte',
            'description' => 'Cold latte with ice',
            'price' => 4.50,
            'is_available' => true,
        ]);
        $icedLatte->ingredients()->attach([
            $coffeeBeans->id => ['quantity_needed' => 18],
            $milk->id => ['quantity_needed' => 200],
            $ice->id => ['quantity_needed' => 100],
        ]);

        // Create Products - Pastries
        Product::create([
            'category_id' => $pastries->id,
            'name' => 'Croissant',
            'description' => 'Buttery French pastry',
            'price' => 3.00,
            'is_available' => true,
        ]);

        Product::create([
            'category_id' => $pastries->id,
            'name' => 'Chocolate Muffin',
            'description' => 'Rich chocolate muffin',
            'price' => 3.50,
            'is_available' => true,
        ]);
    }
}