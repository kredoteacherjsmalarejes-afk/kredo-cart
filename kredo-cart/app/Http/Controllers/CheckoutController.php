<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    // Implement the order registration process here.

    return redirect()
        ->route('orders.confirmation', $order)
        ->with('success', 'Your order has been placed successfully.');
}


}
