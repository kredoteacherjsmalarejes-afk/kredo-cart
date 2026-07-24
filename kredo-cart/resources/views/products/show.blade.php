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
                    @if ($product->category)
                        <a href="{{ route('products.index', [
                            'category' => $product->category->id,
                        ]) }}"
                            class="text-decoration-none text-dark">

                            {{ $product->category->category_name }}
                        </a>
                    @else
                        <span class="text-muted">
                            Uncategorized
                        </span>
                    @endif
                </li>

                <li class="breadcrumb-item active" aria-current="page">
                    {{ $product->product_name }}
                </li>
            </ol>
        </nav>

        <div class="row g-5">
            <div class="col-md-5">
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}"
                        class="img-fluid rounded shadow-sm bg-light" style="object-fit: contain;">
                @else
                    <div class="bg-light rounded d-flex justify-content-center align-items-center" style="height: 450px;">
                        <i class="fa-solid fa-image fa-5x text-secondary"></i>
                    </div>
                @endif
            </div>

            <div class="col-md-7">
                <span class="badge-lg rounded bg-dark text-white mb-3 px-2 py-1">
                    <i class="fa-solid fa-tag"></i>
                    {{ $product->category?->category_name ?? 'Uncategorized' }}
                </span>

                <h1 class="display-6 fw-bold">
                    {{ $product->product_name }}
                </h1>

                {{-- Average rating --}}
                <div class="d-flex align-items-center flex-wrap gap-2 mb-3">
                    @php
                        $averageRating = (float) ($product->reviews_avg_rating ?? 0);
                        $reviewCount = (int) ($product->reviews_count ?? 0);
                        $roundedRating = (int) round($averageRating);
                    @endphp

                    <div class="text-warning">
                        @for ($star = 1; $star <= 5; $star++)
                            @if ($star <= $roundedRating)
                                <i class="fa-solid fa-star"></i>
                            @else
                                <i class="fa-regular fa-star"></i>
                            @endif
                        @endfor
                    </div>

                    <span class="fw-bold">
                        {{ number_format($averageRating, 1) }}
                    </span>

                    @if ($reviewCount > 0)
                        <a href="{{ route('products.reviews', $product) }}" class="text-dark text-decoration-underline">
                            {{ $reviewCount }}
                            {{ Str::plural('Review', $reviewCount) }}
                        </a>
                    @else
                        <span class="text-muted">
                            No reviews yet
                        </span>
                    @endif
                </div>

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
                        <span class="badge-lg rounded text-success bg-success-subtle border border-success px-2 py-1 me-2">
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
                                    min="1" max="{{ $product->stock }}" required>

                                @error('quantity')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
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
                <div class="row g-3 mt-4 text-center">

                    <div class="col-4">
                        <i class="fa-solid fa-truck-fast text-warning fa-2x mb-2"></i>

                        <p class="fw-bold small mb-0">
                            Free Shipping
                        </p>
                    </div>

                    <div class="col-4">
                        <i class="fa-solid fa-shield-halved text-warning fa-2x mb-2"></i>

                        <p class="fw-bold small mb-0">
                            Warranty
                        </p>
                    </div>

                    <div class="col-4">
                        <i class="fa-solid fa-rotate-left text-warning fa-2x mb-2"></i>

                        <p class="fw-bold small mb-0">
                            Easy Returns
                        </p>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
