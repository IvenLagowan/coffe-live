<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'orderItems')
            ->latest()
            ->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::where('is_available', true)
            ->with('category')
            ->get();
        return view('orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => auth()->id(),
                'customer_name' => $validated['customer_name'],
                'status' => 'pending',
            ]);

            $totalAmount = 0;

            foreach ($validated['products'] as $productData) {
                $product = Product::findOrFail($productData['id']);
                $quantity = $productData['quantity'];
                $price = $product->price;
                $subtotal = $price * $quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ]);

                $totalAmount += $subtotal;
            }

            $order->update(['total_amount' => $totalAmount]);

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Order created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create order.']);
        }
    }

    public function show(Order $order)
    {
        $order->load('user', 'orderItems.product');
        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,completed,canceled',
        ]);

        if ($validated['status'] === 'completed' && $order->status !== 'completed') {
            foreach ($order->orderItems as $item) {
                $product = $item->product;
                foreach ($product->ingredients as $ingredient) {
                    $quantityNeeded = $ingredient->pivot->quantity_needed * $item->quantity;
                    $ingredient->deductStock($quantityNeeded);
                }
            }
        }

        $order->update(['status' => $validated['status']]);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order status updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')
            ->with('success', 'Order deleted successfully.');
    }
}