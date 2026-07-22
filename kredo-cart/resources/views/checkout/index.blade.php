@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-4">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none text-dark">
                    <i class="fa-solid fa-house me-1"></i>
                    Home
                </a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('cart.index') }}" class="text-decoration-none text-dark">
                    Cart
                </a>
            </li>

            <li class="breadcrumb-item active" aria-current="page">
                Checkout
            </li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">
            <i class="fa-solid fa-credit-card text-warning me-2"></i>
            Checkout
        </h1>

        <p class="text-muted mb-0">
            Complete your order by filling in the details below
        </p>
    </div>

    {{-- Checkout Steps --}}
    <div class="d-flex justify-content-center align-items-center mb-5">
        <div class="d-flex align-items-center">
            <span class="rounded-circle bg-success text-white d-inline-flex justify-content-center align-items-center"
                style="width: 34px; height: 34px;">
                <i class="fa-solid fa-check small"></i>
            </span>

            <span class="ms-2 small">
                Cart
            </span>
        </div>

        <div class="mx-3 border-top" style="width: 70px;"></div>

        <div class="d-flex align-items-center">
            <span class="rounded-circle bg-dark text-white d-inline-flex justify-content-center align-items-center"
                style="width: 34px; height: 34px;">
                2
            </span>

            <span class="ms-2 small">
                Checkout
            </span>
        </div>

        <div class="mx-3 border-top" style="width: 70px;"></div>

        <div class="d-flex align-items-center">
            <span class="rounded-circle bg-secondary-subtle text-secondary d-inline-flex justify-content-center align-items-center"
                style="width: 34px; height: 34px;">
                3
            </span>

            <span class="ms-2 small text-muted">
                Confirmation
            </span>
        </div>
    </div>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf

        <div class="row g-4">

            {{-- Left side --}}
            <div class="col-lg-7">

                {{-- Shipping Address --}}
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-dark text-white py-3">
                        <h2 class="h6 mb-0">
                            <i class="fa-solid fa-location-dot me-2"></i>
                            Shipping Address
                        </h2>
                    </div>

                    <div class="card-body p-4">
                        <label for="shipping_address" class="form-label fw-semibold">
                            Full Delivery Address
                            <span class="text-danger">*</span>
                        </label>

                        <textarea
                            name="shipping_address"
                            id="shipping_address"
                            rows="4"
                            class="form-control @error('shipping_address') is-invalid @enderror"
                            placeholder="Enter building name, street, city, postal code..."
                            required
                        >{{ old('shipping_address') }}</textarea>

                        @error('shipping_address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-dark text-white py-3">
                        <h2 class="h6 mb-0">
                            <i class="fa-solid fa-wallet me-2"></i>
                            Payment Method
                        </h2>
                    </div>

                    <div class="card-body p-4">

                        {{-- Cash on Delivery --}}
                        <label class="border rounded-3 p-3 d-flex align-items-center mb-3 w-100">
                            <input
                                type="radio"
                                name="payment_method"
                                value="cash_on_delivery"
                                class="form-check-input me-3"
                                {{ old('payment_method', 'cash_on_delivery') === 'cash_on_delivery' ? 'checked' : '' }}
                            >

                            <span class="rounded-circle bg-success-subtle text-success d-inline-flex justify-content-center align-items-center me-3"
                                style="width: 42px; height: 42px;">
                                <i class="fa-solid fa-money-bill-wave"></i>
                            </span>

                            <span>
                                <strong class="d-block">
                                    Cash on Delivery
                                </strong>

                                <small class="text-muted">
                                    Pay when your order arrives
                                </small>
                            </span>
                        </label>

                        {{-- Credit Card --}}
                        <label class="border rounded-3 p-3 d-flex align-items-center mb-3 w-100">
                            <input
                                type="radio"
                                name="payment_method"
                                value="credit_card"
                                class="form-check-input me-3"
                                {{ old('payment_method') === 'credit_card' ? 'checked' : '' }}
                            >

                            <span class="rounded-circle bg-primary-subtle text-primary d-inline-flex justify-content-center align-items-center me-3"
                                style="width: 42px; height: 42px;">
                                <i class="fa-solid fa-credit-card"></i>
                            </span>

                            <span>
                                <strong class="d-block">
                                    Credit Card
                                </strong>

                                <small class="text-muted">
                                    Visa, Mastercard, AMEX
                                </small>
                            </span>
                        </label>

                        {{-- PayPal --}}
                        <label class="border rounded-3 p-3 d-flex align-items-center w-100">
                            <input
                                type="radio"
                                name="payment_method"
                                value="paypal"
                                class="form-check-input me-3"
                                {{ old('payment_method') === 'paypal' ? 'checked' : '' }}
                            >

                            <span class="rounded-circle bg-info-subtle text-info d-inline-flex justify-content-center align-items-center me-3"
                                style="width: 42px; height: 42px;">
                                <i class="fa-brands fa-paypal"></i>
                            </span>

                            <span>
                                <strong class="d-block">
                                    PayPal
                                </strong>

                                <small class="text-muted">
                                    Pay with your PayPal account
                                </small>
                            </span>
                        </label>

                        @error('payment_method')
                            <div class="text-danger small mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary mt-3">
                    <i class="fa-solid fa-arrow-left me-2"></i>
                    Back to Cart
                </a>
            </div>

            {{-- Right side --}}
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-dark text-white py-3">
                        <h2 class="h6 mb-0">
                            <i class="fa-solid fa-receipt me-2"></i>
                            Order Summary
                        </h2>
                    </div>

                    <div class="card-body p-0">

                        {{-- Products --}}
                        @foreach ($cartItems as $cartItem)
                            <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
                                <div class="d-flex align-items-center">
                                    @if ($cartItem->product->image)
                                        <img
                                            src="{{ asset('storage/' . $cartItem->product->image) }}"
                                            alt="{{ $cartItem->product->product_name }}"
                                            class="rounded me-3"
                                            style="width: 58px; height: 58px; object-fit: cover;"
                                        >
                                    @else
                                        <div class="rounded bg-light d-flex justify-content-center align-items-center me-3"
                                            style="width: 58px; height: 58px;">
                                            <i class="fa-solid fa-image text-secondary"></i>
                                        </div>
                                    @endif

                                    <div>
                                        <p class="fw-semibold mb-1">
                                            {{ $cartItem->product->product_name }}
                                        </p>

                                        <small class="text-muted">
                                            Qty: {{ $cartItem->quantity }}
                                        </small>
                                    </div>
                                </div>

                                <span class="fw-semibold">
                                    ₱{{ number_format(
                                        $cartItem->product->price * $cartItem->quantity,
                                        2
                                    ) }}
                                </span>
                            </div>
                        @endforeach

                        {{-- Totals --}}
                        <div class="p-3">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">
                                    Subtotal
                                </span>

                                <span>
                                    ₱{{ number_format($subtotal, 2) }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">
                                    Shipping
                                </span>

                                <span class="text-success">
                                    Free
                                </span>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="fw-bold">
                                    Total
                                </span>

                                <span class="fw-bold fs-4">
                                    ₱{{ number_format($subtotal, 2) }}
                                </span>
                            </div>

                            <button
                                type="submit"
                                class="btn btn-warning w-100 py-2 fw-semibold"
                            >
                                <i class="fa-solid fa-lock me-2"></i>
                                Place Order
                            </button>

                            <p class="text-center text-muted small mt-3 mb-0">
                                <i class="fa-solid fa-shield-halved me-1"></i>
                                Your payment info is secure & encrypted
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection
