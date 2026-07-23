<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function create(Order $order, Product $product): View|RedirectResponse
    {
        // prevent accessing the review page from someone else's order
        abort_unless($order->user_id === auth()->id(), 403);

        // confirm that the product was part of the order
        $productWasOrdered = $order->orderItems()
            ->where('product_id', $product->id)
            ->exists();

        abort_unless($productWasOrdered, 403);

        // only allow reviews for completed orders
        abort_unless($order->status === 'completed', 403);

        // confirm that the user has not already reviewed this product in this order
        $existingReview = Review::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($existingReview) {
            return redirect()
                ->route('orders.show', $order)
                ->with('error', 'You have already reviewed this product.');
        }

        return view('reviews.create', compact('order', 'product'));
    }

    /**
     * store a newly created resource in storage.
     */
    public function store(Request $request, Order $order, Product $product): RedirectResponse
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $productWasOrdered = $order->orderItems()
            ->where('product_id', $product->id)
            ->exists();

        abort_unless($productWasOrdered, 403);
        abort_unless($order->status === 'completed', 403);

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Your review has been submitted.');
    }
}
