@extends('layouts.app')

@section('title', 'Product Reviews')

@section('content')
    <div class="container py-5">

        <div class="mb-4">
            <a href="{{ route('products.show', $product) }}" class="btn btn-outline-dark">
                <i class="fa-solid fa-arrow-left me-2"></i>
                Back to Product
            </a>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">

                <div class="row g-4 align-items-center">

                    <div class="col-md-3 text-center">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}"
                                class="img-fluid rounded" style="max-height: 220px; object-fit: contain;">
                        @else
                            <div class="bg-light rounded d-flex justify-content-center align-items-center"
                                style="height: 220px;">
                                <i class="fa-solid fa-image fa-3x text-secondary"></i>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-9">
                        <span class="badge-lg rounded bg-dark text-white mb-3 px-2 py-1">
                            <i class="fa-solid fa-tag"></i>
                            {{ $product->category?->category_name ?? 'Uncategorized' }}
                        </span>

                        <h1 class="display-6 fw-bold mt-3">
                            {{ $product->product_name }}
                        </h1>

                        @php
                            $displayAverage = round($averageRating ?? 0, 1);
                            $roundedRating = (int) round($displayAverage);
                        @endphp

                        <div class="d-flex align-items-center gap-2 mb-2">

                            <div class="text-warning fs-5">
                                @for ($star = 1; $star <= 5; $star++)
                                    @if ($star <= $roundedRating)
                                        <i class="fa-solid fa-star"></i>
                                    @else
                                        <i class="fa-regular fa-star"></i>
                                    @endif
                                @endfor
                            </div>

                            <span class="fs-4 fw-bold">
                                {{ number_format($displayAverage, 1) }}
                            </span>
                        </div>

                        <p class="text-muted mb-0">
                            Based on {{ $reviewsCount }}
                            {{ $reviewsCount === 1 ? 'review' : 'reviews' }}
                        </p>
                    </div>

                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 fw-bold mb-0">
                Customer Reviews
            </h2>

            <span class="text-muted">
                {{ $reviews->total() }}
                {{ $reviews->total() === 1 ? 'review' : 'reviews' }}
            </span>
        </div>

        @forelse ($reviews as $review)

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start mb-3">

                        <div class="d-flex align-items-center gap-3">

                            <div class="bg-dark text-white rounded-circle d-flex justify-content-center align-items-center fw-bold"
                                style="width: 45px; height: 45px;">
                                {{ strtoupper(substr($review->user?->name ?? 'U', 0, 1)) }}
                            </div>

                            <div>
                                <h3 class="h6 fw-bold mb-1">
                                    {{ $review->user?->name ?? 'Unknown User' }}
                                </h3>

                                <small class="text-muted">
                                    Reviewed:
                                    {{ $review->created_at->format('M d, Y g:i A') }}

                                    @if ($review->updated_at->ne($review->created_at))
                                        <br>
                                        <span class="text-primary">
                                            <i class="fa-solid fa-pen-to-square me-1"></i>
                                            Updated:
                                            {{ $review->updated_at->format('M d, Y g:i A') }}
                                        </span>
                                    @endif
                                </small>
                            </div>

                        </div>

                        <div class="text-end">

                            <div class="text-warning mb-2">
                                @for ($star = 1; $star <= 5; $star++)
                                    @if ($star <= $review->rating)
                                        <i class="fa-solid fa-star"></i>
                                    @else
                                        <i class="fa-regular fa-star"></i>
                                    @endif
                                @endfor
                            </div>

                            @auth
                                @if ($review->user_id === auth()->id())
                                    <a href="{{ route('reviews.edit', $review) }}" class="btn btn-sm btn-outline-dark">
                                        <i class="fa-solid fa-pen-to-square me-1"></i>
                                        Edit
                                    </a>
                                @endif
                            @endauth

                        </div>

                    </div>

                    @if ($review->comment)
                        <p class="mb-0">
                            {{ $review->comment }}
                        </p>
                    @else
                        <p class="text-muted fst-italic mb-0">
                            No written comment was provided.
                        </p>
                    @endif

                </div>
            </div>

        @empty

            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">

                    <i class="fa-regular fa-star fa-3x text-muted mb-3"></i>

                    <h2 class="h5 fw-bold">
                        No reviews yet
                    </h2>

                    <p class="text-muted mb-0">
                        This product has not received any reviews yet.
                    </p>

                </div>
            </div>

        @endforelse

        @if ($reviews->hasPages())
            <div class="mt-4">
                {{ $reviews->links() }}
            </div>
        @endif

    </div>
@endsection
