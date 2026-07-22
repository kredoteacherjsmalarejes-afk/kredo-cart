<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
{
    $cart = auth()->user()
        ->cart()
        ->with('cartItems.product')
        ->first();

    $cartItems = $cart
        ? $cart->cartItems
        : collect();

    if ($cartItems->isEmpty()) {
        return redirect()
            ->route('cart.index')
            ->with('error', 'Your cart is empty.');
    }

    $subtotal = $cartItems->sum(function ($cartItem) {
        return $cartItem->product->price * $cartItem->quantity;
    });

    return view('checkout.index', compact('cartItems', 'subtotal'));
}

public function store(Request $request)
{
    $request->validate([
        'shipping_address' => [
            'required',
            'string',
            'max:1000',
        ],
        'payment_method' => [
            'required',
            'in:cash_on_delivery,credit_card,paypal',
        ],
    ]);

    $cart = auth()->user()
            ->cart()
            ->with('cartItems.product')
            ->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $subtotal = $cart->cartItems->sum(function ($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        });

        $order = DB::transaction(function () use ($request, $cart, $subtotal) {

            $order = Order::create([
                'user_id' => auth()->id(),
                'shipping_address' => $request->shipping_address,
                'payment_method' => $request->payment_method,
                'total_amount' => $subtotal,
                'status' => 'pending',
            ]);

            foreach ($cart->cartItems as $cartItem) {
                $product = $cartItem->product;

                if ($cartItem->quantity > $product->stock) {
                    throw new \Exception(
                        $product->product_name . ' does not have enough stock.'
                    );
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $cartItem->quantity,
                    'price' => $product->price,
                    'subtotal' => $product->price * $cartItem->quantity,
                ]);

                $product->decrement('stock', $cartItem->quantity);
            }

            $cart->cartItems()->delete();

            return $order;
        });

    // Implement the order registration process here.

    return redirect()
        ->route('orders.confirmation', $order)
        ->with('success', 'Your order has been placed successfully.');
}


}
