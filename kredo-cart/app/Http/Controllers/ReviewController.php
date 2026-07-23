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
    /**
     * レビュー作成画面
     */
    public function create(
        Order $order,
        Product $product
    ): View|RedirectResponse {

        // 自分の注文か確認
        if ((int) $order->user_id !== (int) auth()->id()) {
            return redirect()
                ->route('orders.index')
                ->with('error', 'You cannot review this order.');
        }

        // 注文の中に対象商品が含まれているか確認
        $productWasOrdered = $order->orderItems()
            ->where('product_id', $product->id)
            ->exists();

        if (!$productWasOrdered) {
            return redirect()
                ->route('orders.show', $order)
                ->with('error', 'This product is not included in this order.');
        }

        // レビュー可能な注文ステータスか確認
        $reviewableStatuses = [
            'paid',
            'completed',
            'delivered',
        ];

        if (!in_array($order->status, $reviewableStatuses)) {
            return redirect()
                ->route('orders.show', $order)
                ->with(
                    'error',
                    'You can review this product after the order is completed.'
                );
        }

        // すでにレビュー済みか確認
        $existingReview = Review::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($existingReview) {
            return redirect()
                ->route('orders.show', $order)
                ->with('error', 'You have already reviewed this product.');
        }

        return view(
            'reviews.create',
            compact('order', 'product')
        );
    }

    /**
     * レビューを保存
     */
    public function store(
        Request $request,
        Order $order,
        Product $product
    ): RedirectResponse {

        // 自分の注文か確認
        if ((int) $order->user_id !== (int) auth()->id()) {
            return redirect()
                ->route('orders.index')
                ->with('error', 'You cannot review this order.');
        }

        // 注文の中に商品が含まれているか確認
        $productWasOrdered = $order->orderItems()
            ->where('product_id', $product->id)
            ->exists();

        if (!$productWasOrdered) {
            return redirect()
                ->route('orders.show', $order)
                ->with('error', 'This product is not included in this order.');
        }

        // 注文ステータスを確認
        $reviewableStatuses = [
            'paid',
            'completed',
            'delivered',
        ];

        if (!in_array($order->status, $reviewableStatuses)) {
            return redirect()
                ->route('orders.show', $order)
                ->with(
                    'error',
                    'You can review this product after the order is completed.'
                );
        }

        // 入力内容を確認
        $validated = $request->validate([
            'rating' => [
                'required',
                'integer',
                'between:1,5',
            ],
            'comment' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        // 同じ商品への重複レビューを防ぐ
        $alreadyReviewed = Review::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->exists();

        if ($alreadyReviewed) {
            return redirect()
                ->route('orders.show', $order)
                ->with('error', 'You have already reviewed this product.');
        }

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
