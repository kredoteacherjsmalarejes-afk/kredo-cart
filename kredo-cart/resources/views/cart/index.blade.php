@extends('layouts.app')

@section('title', 'Shopping Cart')

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

            <li class="breadcrumb-item active" aria-current="page">
                Shopping Cart
            </li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">
                <i class="fa-solid fa-cart-shopping text-warning me-2"></i>
                Shopping Cart
            </h1>

            <p class="text-muted mb-0">
                You have {{ $cartItems->count() }}
                {{ $cartItems->count() === 1 ? 'item' : 'items' }} in your cart
            </p>
        </div>

        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>
            Continue Shopping
        </a>
    </div>

    @if ($cartItems->isEmpty())
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body text-center py-5">
                <i class="fa-solid fa-cart-shopping fa-4x text-secondary mb-3"></i>

                <h2 class="h4 fw-bold">
                    Your cart is empty
                </h2>

                <p class="text-muted">
                    Add some products to your cart and come back here.
                </p>

                <a href="{{ route('products.index') }}" class="btn btn-warning px-4">
                    Start Shopping
                </a>
            </div>
        </div>
    @else
        <div class="row g-4">

            {{-- Cart items --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                    {{-- Table header --}}
                    <div class="bg-dark text-white px-3 py-3">
                        <div class="row align-items-center small fw-semibold">
                            <div class="col-5">
                                Product
                            </div>

                            <div class="col-2 text-center">
                                Price
                            </div>

                            <div class="col-3 text-center">
                                Quantity
                            </div>

                            <div class="col-2 text-end">
                                Subtotal
                            </div>
                        </div>
                    </div>

                    {{-- Products --}}
                    @foreach ($cartItems as $cartItem)
                        <div class="px-3 py-3 border-bottom">
                            <div class="row align-items-center">

                                {{-- Product --}}
                                <div class="col-5">
                                    <div class="d-flex align-items-center">
                                        @if ($cartItem->product->image)
                                            <img
                                                src="{{ asset('storage/' . $cartItem->product->image) }}"
                                                alt="{{ $cartItem->product->product_name }}"
                                                class="rounded me-3"
                                                style="width: 70px; height: 70px; object-fit: cover;"
                                            >
                                        @else
                                            <div
                                                class="rounded bg-light text-secondary d-flex justify-content-center align-items-center me-3"
                                                style="width: 70px; height: 70px;"
                                            >
                                                <i class="fa-solid fa-image"></i>
                                            </div>
                                        @endif

                                        <div>
                                            <a
                                                href="{{ route('products.show', $cartItem->product) }}"
                                                class="text-dark text-decoration-none fw-semibold"
                                            >
                                                {{ $cartItem->product->product_name }}
                                            </a>

                                            <form
                                                action="{{ route('cart.destroy', $cartItem) }}"
                                                method="POST"
                                                class="mt-1"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-link text-danger text-decoration-none p-0 small"
                                                    onclick="return confirm('Remove this product from your cart?')"
                                                >
                                                    <i class="fa-solid fa-trash-can me-1"></i>
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                {{-- Price --}}
                                <div class="col-2 text-center">
                                    ${{ number_format($cartItem->product->price, 2) }}
                                </div>

                                {{-- Quantity --}}
                                <div class="col-3">
                                    <div class="d-flex justify-content-center align-items-center gap-2">

                                        {{-- Decrease --}}
                                        <form
                                            action="{{ route('cart.update', $cartItem) }}"
                                            method="POST"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <input
                                                type="hidden"
                                                name="quantity"
                                                value="{{ max(1, $cartItem->quantity - 1) }}"
                                            >

                                            <button
                                                type="submit"
                                                class="btn btn-outline-secondary rounded-circle p-0"
                                                style="width: 34px; height: 34px;"
                                                {{ $cartItem->quantity <= 1 ? 'disabled' : '' }}
                                            >
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                        </form>

                                        <span class="fw-semibold">
                                            {{ $cartItem->quantity }}
                                        </span>

                                        {{-- Increase --}}
                                        <form
                                            action="{{ route('cart.update', $cartItem) }}"
                                            method="POST"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <input
                                                type="hidden"
                                                name="quantity"
                                                value="{{ $cartItem->quantity + 1 }}"
                                            >

                                            <button
                                                type="submit"
                                                class="btn btn-dark rounded-circle p-0"
                                                style="width: 34px; height: 34px;"
                                                {{ $cartItem->quantity >= $cartItem->product->stock ? 'disabled' : '' }}
                                            >
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                {{-- Subtotal --}}
                                <div class="col-2 text-end fw-semibold">
                                    ${{ number_format(
                                        $cartItem->product->price * $cartItem->quantity,
                                        2
                                    ) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Order summary --}}
            <div class="col-lg-4">

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3">
                    <div class="card-header bg-dark text-white py-3">
                        <h2 class="h6 mb-0">
                            <i class="fa-solid fa-receipt me-2"></i>
                            Order Summary
                        </h2>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">
                                Items ({{ $cartItems->sum('quantity') }})
                            </span>

                            <span>
                                ${{ number_format($subtotal, 2) }}
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

                            <span class="fw-bold fs-5">
                                ${{ number_format($subtotal, 2) }}
                            </span>
                        </div>

                        <a
                            href="{{ route('checkout.index') }}"
                            class="btn btn-warning w-100 fw-semibold py-2"
                        >
                            <i class="fa-solid fa-lock me-2"></i>
                            Proceed to Checkout
                        </a>

                        <a
                            href="{{ route('products.index') }}"
                            class="btn btn-outline-secondary w-100 mt-2"
                        >
                            <i class="fa-solid fa-arrow-left me-2"></i>
                            Continue Shopping
                        </a>
                    </div>
                </div>

                {{-- Security information --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body">

                        <div class="d-flex align-items-start mb-3">
                            <i class="fa-solid fa-shield-halved text-success fs-5 me-3 mt-1"></i>

                            <div>
                                <p class="fw-semibold mb-0">
                                    Secure Checkout
                                </p>

                                <small class="text-muted">
                                    Your data is protected
                                </small>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-3">
                            <i class="fa-solid fa-truck-fast text-primary fs-5 me-3 mt-1"></i>

                            <div>
                                <p class="fw-semibold mb-0">
                                    Fast Delivery
                                </p>

                                <small class="text-muted">
                                    2–5 business days
                                </small>
                            </div>
                        </div>

                        <div class="d-flex align-items-start">
                            <i class="fa-solid fa-rotate-left text-warning fs-5 me-3 mt-1"></i>

                            <div>
                                <p class="fw-semibold mb-0">
                                    Easy Returns
                                </p>

                                <small class="text-muted">
                                    30-day return policy
                                </small>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    @endif

</div>
@endsection
