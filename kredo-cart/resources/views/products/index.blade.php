@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="container py-4">
    <div class="row">
        {{-- Category sidebar --}}
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    Categories
                </div>

                <div class="list-group list-group-flush">
                    <a href="{{ route('products.index') }}" class="list-group-item list-group-item-action">
                        All Products
                    </a>

                    @foreach ($categories as $category)
                        <a href="{{ route('products.index', ['category' => $category->id]) }}"
                            class="list-group-item list-group-item-action d-flex justify-content-between">
                            <span>{{ $category->category_name }}</span>

                            <span class="badge bg-secondary">
                                {{ $category->products_count }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Products --}}
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h3 mb-0">Products</h1>

                <form action="{{ route('products.index') }}" method="GET" class="d-flex">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Search products">

                    <button class="btn btn-dark">
                        Search
                    </button>
                </form>
            </div>

            @if ($products->isEmpty())
                <div class="alert alert-info">
                    No products found.
                </div>
            @else
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}" class="card-img-top" style="height: 220px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex justify-content-center align-items-center" style="height: 220px;">
                                        <i class="fa-solid fa-image fa-3x text-secondary"></i>
                                    </div>
                                @endif

                                <div class="card-body d-flex flex-column">
                                    <p class="small text-muted mb-1">
                                        {{ $product->category?->category_name }}
                                    </p>

                                    <h2 class="h5">
                                        {{ $product->product_name }}
                                    </h2>

                                    <p class="text-muted">
                                        {{ \Illuminate\Support\Str::limit( $product->description, 80) }}
                                    </p>

                                    <p class="fw-bold fs-5 mt-auto">
                                        ${{ number_format($product->price, 2) }}
                                    </p>

                                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-dark w-100">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-3">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
