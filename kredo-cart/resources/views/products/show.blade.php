@extends('layouts.app')

@section('title', $product->product_name)

@section('content')
<div class="container py-5">
    <div class="row g-5">
        <div class="col-md-6">
            @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}" class="img-fluid rounded shadow-sm w-100">
            @else
                <div class="bg-light rounded d-flex justify-content-center align-items-center" style="height: 450px;">
                    <i class="fa-solid fa-image fa-5x text-secondary"></i>
                </div>
            @endif
        </div>

        <div class="col-md-6">
            <p class="text-muted mb-1">
                {{ $product->category?->category_name }}
            </p>

            <h1 class="display-6 fw-bold">
                {{ $product->product_name }}
            </h1>

            <p class="fs-3 fw-bold">
                ${{ number_format($product->price, 2) }}
            </p>

            <p>
                {{ $product->description }}
            </p>

            <p>
                <strong>Stock:</strong>
                {{ $product->stock }}
            </p>

            @auth
                @if ($product->stock > 0)
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="mb-3">
                            <label for="quantity" class="form-label">
                                Quantity
                            </label>

                            <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" max="{{ $product->stock }}">
                        </div>

                        <button type="submit" class="btn btn-dark w-100">
                            <i class="fa-solid fa-cart-plus"></i>
                            Add to Cart
                        </button>
                    </form>
                @else
                    <button class="btn btn-secondary w-100" disabled>
                        Out of Stock
                    </button>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-dark w-100">
                    Login to Add to Cart
                </a>
            @endauth
        </div>
    </div>
</div>
@endsection
