@extends('layouts.app')

@section('title', 'Write a Review')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">

                <div class="mb-4">
                    <a href="{{ route('orders.show', $order) }}"
                        class="text-decoration-none text-dark">
                        <i class="fa-solid fa-arrow-left me-1"></i>
                        Back to Order
                    </a>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">

                        <h1 class="h3 fw-bold mb-4">
                            Write a Review
                        </h1>

                        {{-- Product information --}}
                        <div class="d-flex align-items-center border rounded p-3 mb-4">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->product_name }}"
                                    class="rounded me-3"
                                    style="width: 90px; height: 90px; object-fit: contain;">
                            @else
                                <div class="bg-light rounded d-flex justify-content-center align-items-center me-3"
                                    style="width: 90px; height: 90px;">
                                    <i class="fa-solid fa-image fa-2x text-muted"></i>
                                </div>
                            @endif

                            <div>
                                <h2 class="h6 fw-bold mb-1">
                                    {{ $product->product_name }}
                                </h2>

                                <p class="text-muted mb-0">
                                    Order #{{ $order->id }}
                                </p>
                            </div>
                        </div>

                        <form action="{{ route('reviews.store', ['order' => $order->id,'product' => $product->id,]) }}"
                            method="POST">
                            @csrf

                            {{-- Rating --}}
                            <div class="mb-4">
                                <label for="rating" class="form-label fw-semibold">
                                    Rating
                                </label>

                                <select name="rating"
                                    id="rating"
                                    class="form-select @error('rating') is-invalid @enderror"
                                    required>
                                    <option value="" selected disabled>
                                        Select a rating
                                    </option>

                                    <option value="5" @selected(old('rating') == 5)>
                                        ★★★★★ Excellent
                                    </option>

                                    <option value="4" @selected(old('rating') == 4)>
                                        ★★★★☆ Good
                                    </option>

                                    <option value="3" @selected(old('rating') == 3)>
                                        ★★★☆☆ Average
                                    </option>

                                    <option value="2" @selected(old('rating') == 2)>
                                        ★★☆☆☆ Poor
                                    </option>

                                    <option value="1" @selected(old('rating') == 1)>
                                        ★☆☆☆☆ Very Poor
                                    </option>
                                </select>

                                @error('rating')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Comment --}}
                            <div class="mb-4">
                                <label for="comment" class="form-label fw-semibold">
                                    Comment
                                </label>

                                <textarea name="comment"
                                    id="comment"
                                    rows="6"
                                    maxlength="1000"
                                    class="form-control @error('comment') is-invalid @enderror"
                                    placeholder="Tell us what you thought about this product...">{{ old('comment') }}</textarea>

                                @error('comment')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div class="form-text">
                                    Maximum 1,000 characters.
                                </div>
                            </div>

                            <button type="submit" class="btn btn-dark w-100">
                                <i class="fa-solid fa-star me-1 text-warning"></i>
                                Submit Review
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
