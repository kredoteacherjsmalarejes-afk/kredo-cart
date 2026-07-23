@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">
                Order Details
            </h1>

            <p class="text-muted mb-0">
                Order #{{ $order->id }}
            </p>
        </div>

        <a href="{{ route('orders.index') }}"
           class="btn btn-outline-dark">
            <i class="fa-solid fa-arrow-left me-2"></i>
            Back to Orders
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">

            <div class="row g-3">
                <div class="col-md-4">
                    <small class="text-muted d-block">
                        Order Date
                    </small>

                    <strong>
                        {{ $order->created_at->format('M d, Y') }}
                    </strong>
                </div>

                <div class="col-md-4">
                    <small class="text-muted d-block">
                        Status
                    </small>

                    <span class="badge bg-warning text-dark">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <div class="col-md-4">
                    <small class="text-muted d-block">
                        Payment Method
                    </small>

                    <strong>
                        {{ ucwords(str_replace('_', ' ', $order->payment_method)) }}
                    </strong>
                </div>
            </div>

        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-dark text-white">
            <h2 class="h5 mb-0">
                Order Items
            </h2>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-end">Subtotal</th>
                            <th class="text-center">Review</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($order->orderItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">

                                        @if ($item->product?->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                                 alt="{{ $item->product->product_name }}"
                                                 class="rounded"
                                                 style="width: 70px; height: 70px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex justify-content-center align-items-center"
                                                 style="width: 70px; height: 70px;">
                                                <i class="fa-solid fa-image text-secondary"></i>
                                            </div>
                                        @endif

                                        <strong>
                                            {{ $item->product?->product_name ?? 'Product unavailable' }}
                                        </strong>
                                    </div>
                                </td>

                                <td class="text-center">
                                    ${{ number_format($item->price, 2) }}
                                </td>

                                <td class="text-center">
                                    {{ $item->quantity }}
                                </td>

                                <td class="text-end fw-bold">
                                    ${{ number_format($item->subtotal, 2) }}
                                </td>
                                <td class="text-center">
    @if (!$item->product)
        <span class="text-muted small">
            Unavailable
        </span>
    @elseif ($order->status !== 'completed')
        <span class="text-muted small">
            Available after completion
        </span>
    @else
        @php
            $review = auth()->user()
                ->reviews()
                ->where('product_id', $item->product_id)
                ->first();
        @endphp

        @if ($review)
            <span class="badge bg-success">
                <i class="fa-solid fa-check me-1"></i>
                Reviewed
            </span>
        @else
            <a href="{{ route('reviews.create', [
                'order' => $order,
                'product' => $item->product,
            ]) }}"
               class="btn btn-outline-dark btn-sm">
                <i class="fa-regular fa-star me-1"></i>
                Write a Review
            </a>
        @endif
    @endif
</td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot class="table-light">
                        <tr>
                            <th colspan="3" class="text-end">
                                Total
                            </th>

                            <th class="text-end">
                                ${{ number_format($order->total_amount, 2) }}
                            </th>

                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h2 class="h5 fw-bold">
                Shipping Address
            </h2>

            <p class="mb-0">
                {{ $order->shipping_address }}
            </p>
        </div>
    </div>

</div>
@endsection
