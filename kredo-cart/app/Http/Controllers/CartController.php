<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Cart;
use App\Models\Product;

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

public function store(Request $request)
    {
        $request->validate([
            'product_id' => [
                'required',
                'exists:products,id',
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock <= 0) {
            return back()->with('error', 'This product is out of stock.');
        }

        if ($request->quantity > $product->stock) {
            return back()->with(
                'error',
                'The requested quantity exceeds the available stock.'
            );
        }

        // ログインユーザーのカートを取得。なければ作成
        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        // 同じ商品がすでにカートにあるか確認
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;

            if ($newQuantity > $product->stock) {
                return back()->with(
                    'error',
                    'The total quantity exceeds the available stock.'
                );
            }

            $cartItem->update([
                'quantity' => $newQuantity,
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()
            ->route('cart.index')
            ->with('success', 'Product added to cart.');
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
