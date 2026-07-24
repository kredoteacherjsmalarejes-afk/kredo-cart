<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function confirmation(Order $order)
{
    if ($order->user_id !== auth()->id()) {
        abort(403);
    }

    $order->load('orderItems.product');

    return view('orders.confirmation', compact('order'));
}

public function index()
{
    $orders = Order::with([
            'orderItems.product',
        ])
        ->where('user_id', auth()->id())
        ->latest()
        ->paginate(10);

    return view('orders.index', compact('orders'));
}

public function show(Order $order)
{
    if ($order->user_id !== auth()->id()) {
        abort(403);
    }

    $order->load('orderItems.product');

    return view('orders.show', compact('order'));
}


}
