<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Cart;

class CartController extends Controller
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

    $subtotal = $cartItems->sum(function ($cartItem) {
        return $cartItem->product->price * $cartItem->quantity;
    });

    return view('cart.index', compact('cartItems', 'subtotal'));
}

public function update(Request $request, CartItem $cartItem)
{
    $request->validate([
        'quantity' => [
            'required',
            'integer',
            'min:1',
            'max:' . $cartItem->product->stock,
        ],
    ]);

    if ($cartItem->cart->user_id !== auth()->id()) {
        abort(403);
    }

    $cartItem->update([
        'quantity' => $request->quantity,
    ]);

    return back()->with('success', 'Cart quantity updated.');
}

public function destroy(CartItem $cartItem)
{
    if ($cartItem->cart->user_id !== auth()->id()) {
        abort(403);
    }

    $cartItem->delete();

    return back()->with('success', 'Product removed from cart.');
}
}
