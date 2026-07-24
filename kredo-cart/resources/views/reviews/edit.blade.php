@extends('layouts.app')

@section('title', 'Edit Review')

@section('content')
<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="mb-4">
                <a href="{{ route('products.reviews', $review->product) }}"
                   class="btn btn-outline-dark">
                    <i class="fa-solid fa-arrow-left me-2"></i>
                    Back to Reviews
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">

                    <div class="row g-4 mb-4 align-items-center">

                        <div class="col-md-3 text-center">
                            @if ($review->product->image)
                                <img
                                    src="{{ asset('storage/' . $review->product->image) }}"
                                    alt="{{ $review->product->product_name }}"
                                    class="img-fluid rounded"
                                    style="max-height: 180px; object-fit: contain;">
                            @else
                                <div class="bg-light rounded d-flex justify-content-center align-items-center"
                                     style="height: 180px;">
                                    <i class="fa-solid fa-image fa-3x text-secondary"></i>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-9">
                            <span class="rounded bg-dark text-white px-2 py-1">
                                <i class="fa-solid fa-tag me-1"></i>
                                {{ $review->product->category?->category_name ?? 'Uncategorized' }}
                            </span>

                            <h1 class="h3 fw-bold mt-3 mb-2">
                                Edit Your Review
                            </h1>

                            <p class="text-muted mb-0">
                                {{ $review->product->product_name }}
                            </p>
                        </div>

                    </div>

                    <form action="{{ route('reviews.update', $review) }}"
                          method="POST">

                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                Rating
                            </label>

                            <div class="d-flex flex-wrap gap-2">

                                @for ($rating = 1; $rating <= 5; $rating++)
                                    <div>
                                        <input
                                            type="radio"
                                            class="btn-check"
                                            name="rating"
                                            id="rating-{{ $rating }}"
                                            value="{{ $rating }}"
                                            autocomplete="off"
                                            {{ (int) old('rating', $review->rating) === $rating ? 'checked' : '' }}>

                                        <label
                                            class="btn btn-outline-warning"
                                            for="rating-{{ $rating }}">

                                            @for ($star = 1; $star <= $rating; $star++)
                                                <i class="fa-solid fa-star"></i>
                                            @endfor

                                            <span class="ms-1">
                                                {{ $rating }}
                                            </span>
                                        </label>
                                    </div>
                                @endfor

                            </div>

                            @error('rating')
                                <div class="text-danger small mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="comment" class="form-label fw-bold">
                                Comment
                            </label>

                            <textarea
                                name="comment"
                                id="comment"
                                rows="6"
                                maxlength="1000"
                                class="form-control @error('comment') is-invalid @enderror"
                                placeholder="Tell us what you think about this product...">{{ old('comment', $review->comment) }}</textarea>

                            <div class="form-text">
                                Maximum 1,000 characters.
                            </div>

                            @error('comment')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit"
                                    class="btn btn-dark flex-grow-1">
                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                Update Review
                            </button>

                            <a href="{{ route('products.reviews', $review->product) }}"
                               class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection
