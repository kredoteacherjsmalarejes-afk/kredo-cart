@extends('layouts.app')

@section('title', $product->product_name)

@section('content')

<div class="container py-4">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item">
                <a href="{{ route('products.index') }}" class="text-decoration-none text-dark">
                    <i class="fa-solid fa-house me-1"></i>
                    Home
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('products.index') }}" class="text-decoration-none text-dark">
                    {{ $product->category?->category_name }}
                </a>
            </li>

            <li class="breadcrumb-item active" aria-current="page">
                {{ $product->product_name }}
            </li>
        </ol>
    </nav>

    <div class="container py-5">
        <div class="row g-5">
            <div class="col-md-6">
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}"
                        class="img-fluid rounded shadow-sm w-100" style="height:500px; object-fit:cover;">
                @else
                    <div class="bg-light rounded d-flex justify-content-center align-items-center" style="height: 450px;">
                        <i class="fa-solid fa-image fa-5x text-secondary"></i>
                    </div>
                @endif
            </div>

            <div class="col-md-6">
                <span class="badge-lg rounded bg-dark text-white mb-3 px-2 py-1">
                    <i class="fa-solid fa-tag"></i>
                    {{ $product->category?->category_name }}
                </span>

                <h1 class="display-6 fw-bold">
                    {{ $product->product_name }}
                </h1>

                {{-- Reviews --}}
                {{-- @foreach ($product->reviews as $review)
                    <div class="border rounded p-3 mb-3">

                        <div class="d-flex justify-content-between">

                            <strong>
                                {{ $review->user->name }}
                            </strong>

                            <div class="text-warning">

                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $review->rating)
                                        <i class="fa-solid fa-star"></i>
                                    @else
                                        <i class="fa-regular fa-star"></i>
                                    @endif
                                @endfor

                            </div>

                        </div>

                        <small class="text-muted">
                            {{ $review->created_at->format('M d, Y') }}
                        </small>

                        <p class="mt-2">
                            {{ $review->comment }}
                        </p>

                    </div>
                @endforeach --}}

                <p class="fs-3 fw-bold">
                    ${{ number_format($product->price, 2) }}
                </p>

                <p>
                    @if ($product->stock > 0)
                        <span class="badge-lg rounded text-success bg-light border border-success px-2 py-1 me-2">
                            <i class="fa-solid fa-circle-check"></i>
                            In Stock
                        </span>
                        {{ $product->stock }} units available
                    @else
                        <span class="badge bg-danger">
                            Out of Stock
                        </span>
                    @endif
                </p>
                <hr>
                <strong>Description:</strong>
                <p>
                    {{ $product->description }}
                </p>
                <hr>


                @auth
                    @if ($product->stock > 0)
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf

                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div class="mb-3">
                                <label for="quantity" class="form-label fw-bold">
                                    Quantity
                                </label>

                                <input type="number" name="quantity" id="quantity" class="form-control w-25" value="1"
                                    min="1" max="{{ $product->stock }}">
                            </div>

                            <button type="submit" class="btn btn-dark btn-lg w-100">
                                <i class="fa-solid fa-cart-plus me-2"></i>
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

                <a href="{{ route('products.index') }}" class="btn btn-outline-dark w-100 mt-3">
                    <i class="fa-solid fa-arrow-left me-2"></i>
                    Continue Shopping
                </a>


                {{-- Features --}}
                <div class="row d-flex flex-wrap gap-4 hero-features inline-block mt-4 text-center">
                    <p class="col-md-4 fw-bold">
                        <span>
                            <i class="fa-solid fa-truck-fast text-warning me-1 fa-2x"></i>
                        </span>
                        <br>
                        Free Shipping
                    </p>

                    <p class="col-md-4 fw-bold">
                        <span>
                            <i class="fa-solid fa-shield-halved text-warning me-1 fa-2x"></i>

                        </span>
                        <br>
                        Warranty
                    </p>

                    <p class="col-md-3 fw-bold">
                        <span>
                            <i class="fa-solid fa-rotate-left text-warning me-1 fa-2x"></i>

                        </span>
                        <br>
                        Easy Returns
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
