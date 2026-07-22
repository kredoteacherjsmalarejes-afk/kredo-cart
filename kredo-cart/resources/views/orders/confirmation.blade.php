@extends('layouts.app')

@section('title', 'Order Confirmation')

@section('content')
<div class="container py-4">

    {{-- Checkout steps --}}
    <div class="d-flex justify-content-center align-items-center mb-5">
        <div class="d-flex align-items-center">
            <span class="rounded-circle bg-success text-white d-inline-flex justify-content-center align-items-center"
                style="width: 34px; height: 34px;">
                <i class="fa-solid fa-check small"></i>
            </span>

            <span class="ms-2 small text-success">
                Cart
            </span>
        </div>

        <div class="mx-3 border-top border-success" style="width: 70px;"></div>

        <div class="d-flex align-items-center">
            <span class="rounded-circle bg-success text-white d-inline-flex justify-content-center align-items-center"
                style="width: 34px; height: 34px;">
                <i class="fa-solid fa-check small"></i>
            </span>

            <span class="ms-2 small text-success">
                Checkout
            </span>
        </div>

        <div class="mx-3 border-top border-success" style="width: 70px;"></div>

        <div class="d-flex align-items-center">
            <span class="rounded-circle bg-success text-white d-inline-flex justify-content-center align-items-center"
                style="width: 34px; height: 34px;">
                <i class="fa-solid fa-check small"></i>
            </span>

            <span class="ms-2 small text-success">
                Confirmed
            </span>
        </div>
    </div>

    {{-- Confirmation header --}}
    <div class="text-center mb-5">
        <div class="d-inline-flex justify-content-center align-items-center rounded-circle bg-success-subtle mb-3"
            style="width: 76px; height: 76px;">

            <i class="fa-solid fa-circle-check text-success fs-1"></i>
        </div>

        <h1 class="h2 fw-bold mb-2">
            Order Confirmed!
        </h1>

        <p class="text-muted mb-0">
            Order #{{ $order->id }} was placed on
            {{ $order->created_at->format('F d, Y h:i A') }}
        </p>
    </div>

    <div class="row g-4">

        {{-- Order items --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-dark text-white py-3">
                    <h2 class="h6 mb-0">
                        <i class="fa-solid fa-bag-shopping me-2"></i>
                        Order Items
                    </h2>
                </div>

                <div class="card-body p-0">

                    @foreach ($order->orderItems as $orderItem)
                        <div class="d-flex justify-content-between align-items-center p-3 border-bottom">

                            <div class="d-flex align-items-center">
                                @if ($orderItem->product && $orderItem->product->image)
                                    <img
                                        src="{{ asset('storage/' . $orderItem->product->image) }}"
                                        alt="{{ $orderItem->product->product_name }}"
                                        class="rounded me-3"
                                        style="width: 64px; height: 64px; object-fit: cover;"
                                    >
                                @else
                                    <div
                                        class="rounded bg-light d-flex justify-content-center align-items-center me-3"
                                        style="width: 64px; height: 64px;"
                                    >
                                        <i class="fa-solid fa-image text-secondary"></i>
                                    </div>
                                @endif

                                <div>
                                    <p class="fw-semibold mb-1">
                                        {{ $orderItem->product_name }}
                                    </p>

                                    <small class="text-muted">
                                        ₱{{ number_format($orderItem->price, 2) }}
                                        × {{ $orderItem->quantity }}
                                    </small>
                                </div>
                            </div>

                            <span class="fw-semibold">
                                ₱{{ number_format(
                                    $orderItem->price * $orderItem->quantity,
                                    2
                                ) }}
                            </span>
                        </div>
                    @endforeach

                    <div class="d-flex justify-content-between align-items-center p-3">
                        <span class="fw-bold">
                            Total
                        </span>

                        <span class="fw-bold fs-4">
                            ₱{{ number_format($order->total_amount, 2) }}
                        </span>
                    </div>

                </div>
            </div>
        </div>

        {{-- Order details --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3">
                <div class="card-header bg-dark text-white py-3">
                    <h2 class="h6 mb-0">
                        <i class="fa-solid fa-file-invoice me-2"></i>
                        Order Details
                    </h2>
                </div>

                <div class="card-body">

                    {{-- Status --}}
                    <div class="mb-3 pb-3 border-bottom">
                        <small class="text-muted d-block mb-2">
                            Status
                        </small>

                        @php
                            $statusClass = match ($order->status) {
                                'pending' => 'bg-warning text-dark',
                                'processing' => 'bg-primary',
                                'shipped' => 'bg-info text-dark',
                                'delivered' => 'bg-success',
                                'cancelled' => 'bg-danger',
                                default => 'bg-secondary',
                            };
                        @endphp

                        <span class="badge {{ $statusClass }} px-3 py-2">
                            <i class="fa-solid fa-circle me-1 small"></i>
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    {{-- Payment --}}
                    <div class="mb-3 pb-3 border-bottom">
                        <small class="text-muted d-block mb-2">
                            Payment Method
                        </small>

                        <p class="mb-0 fw-semibold">
                            @if ($order->payment_method === 'cash_on_delivery')
                                <i class="fa-solid fa-money-bill-wave text-success me-2"></i>
                                Cash on Delivery
                            @elseif ($order->payment_method === 'credit_card')
                                <i class="fa-solid fa-credit-card text-primary me-2"></i>
                                Credit Card
                            @elseif ($order->payment_method === 'paypal')
                                <i class="fa-brands fa-paypal text-info me-2"></i>
                                PayPal
                            @else
                                {{ ucwords(str_replace('_', ' ', $order->payment_method)) }}
                            @endif
                        </p>
                    </div>

                    {{-- Address --}}
                    <div class="mb-3 pb-3 border-bottom">
                        <small class="text-muted d-block mb-2">
                            Shipping Address
                        </small>

                        <p class="mb-0">
                            <i class="fa-solid fa-location-dot text-danger me-2"></i>
                            {{ $order->shipping_address }}
                        </p>
                    </div>

                    {{-- Date --}}
                    <div>
                        <small class="text-muted d-block mb-2">
                            Order Date
                        </small>

                        <p class="mb-0">
                            <i class="fa-solid fa-calendar-days me-2"></i>
                            {{ $order->created_at->format('F d, Y h:i A') }}
                        </p>
                    </div>

                </div>
            </div>

            <a href="{{ route('orders.index') }}" class="btn btn-dark w-100 mb-2">
                <i class="fa-solid fa-list me-2"></i>
                View All Orders
            </a>

            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100">
                <i class="fa-solid fa-bag-shopping me-2"></i>
                Continue Shopping
            </a>
        </div>

    </div>
</div>
@endsection
