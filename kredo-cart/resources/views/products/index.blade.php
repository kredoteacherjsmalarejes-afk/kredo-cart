@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="container">

        {{-- Hero section --}}
        <section class="hero-section mb-5 bg-dark text-white mt-5 p-5 rounded-4 shadow-sm">
            <div class="row align-items-stretch g-4">

                {{-- Left content --}}
                <div class="col-lg-7">
                    <span class="badge bg-warning text-dark mb-3 px-3 py-2">
                        <i class="fa-solid fa-circle-check me-1"></i>
                        Welcome to Our Store
                    </span>

                    <h1 class="hero-title mb-3" style="font-size: 3.5rem;">
                        Discover Amazing
                        <br>

                        <span class="text-warning">
                            Products
                        </span>

                        Today
                    </h1>

                    <p class="hero-description mb-4">
                        Shop the latest trends with quality products at prices
                        you’ll love. Free shipping on orders over $1,000!
                    </p>

                    {{-- Search --}}
                    <form action="{{ route('products.index') }}" method="GET">

                        @if (request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif

                        <div class="input-group hero-search mb-3">
                            <span class="input-group-text bg-white border-0">
                                <i class="fa-solid fa-magnifying-glass text-secondary"></i>
                            </span>

                            <input type="text" name="search" value="{{ request('search') }}"
                                class="form-control border-0 rounded-start" placeholder="Search for products...">

                            <button type="submit" class="btn btn-warning px-4">
                                <i class="fa-solid fa-magnifying-glass me-1"></i>
                                Search
                            </button>
                        </div>
                    </form>

                    {{-- Features --}}
                    <div class="d-flex flex-wrap gap-4 hero-features">
                        <span>
                            <i class="fa-solid fa-truck-fast text-warning me-1"></i>
                            Fast Delivery
                        </span>

                        <span>
                            <i class="fa-solid fa-shield-halved text-warning me-1"></i>
                            Secure Payment
                        </span>

                        <span>
                            <i class="fa-solid fa-rotate-left text-warning me-1"></i>
                            Easy Returns
                        </span>
                    </div>
                </div>

                {{-- Right side --}}
                <a href="{{ route('products.index') }}"
                    class="col-lg-5 bg-warning rounded-4 p-4 d-flex justify-content-center align-items-center text-decoration-none">
                    <span class="display-3 fw-bold text-dark">
                        Shop Now
                    </span>
                </a>
            </div>
        </section>

        {{-- Categories --}}
        <section class="mb-5">
            <h2 class="section-title mb-3">
                <i class="fa-solid fa-layer-group text-warning me-2"></i>
                Shop by Category
            </h2>

            <div class="category-scroll d-flex flex-nowrap gap-3 overflow-auto pb-2">

                {{-- All products --}}
                <a href="{{ route('products.index',  ['search' => request('search')]) }}" class="category-card text-decoration-none px-3 py-1 border rounded {{ request()->filled('category') ? 'bg-white text-dark' : 'bg-dark text-white border-dark' }}">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-border-all text-warning me-2"></i>

                        <strong>All Products</strong>
                        {{-- <small>Browse everything</small> --}}
   
                    </div>
                </a>

                @foreach ($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->id]) }}"
                        class="category-card text-decoration-none text-dark border rounded p-2 {{ request('category') == $category->id ? 'bg-dark text-white border-dark' : 'bg-white text-dark' }}">
                        <div class="category-icon d-flex justify-content-center align-items-center me-2">
                            <i class="fa-solid fa-tag text-warning me-2"></i>
                            <strong class="small">
                                {{ $category->category_name }}
                            </strong>
                        </div>

                        <div>
                            @php
                                $isSelected = request('category') == $category->id;
                            @endphp
                            <small class="{{ $isSelected ? 'text-white-50' : 'text-muted' }}">
                                {{ $category->description }}
                            </small>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        {{-- Featured products --}}
        <section>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="section-title mb-0">
                    <i class="fa-solid fa-fire text-warning me-2"></i>
                    Featured Products
                </h2>

                <span class="badge bg-dark">
                    {{ $products->count() }}
                    {{ Str::plural('Product', $products->count()) }}
                </span>
            </div>

            @if ($products->isEmpty())
                <div class="alert alert-info">
                    No products found.
                </div>
            @else
                <div class="row g-4">
                    @foreach ($products as $product)
                        <div class="col-sm-6 col-lg-3">
                            <div class="card product-card h-100 border-0 shadow-sm">

                                <div class="product-image-wrapper position-relative">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->product_name }}" class="card-img-top"
                                            style="height: 220px; object-fit: cover;">
                                    @else
                                        <div class="product-placeholder">
                                            <i class="fa-solid fa-image fa-3x"></i>
                                        </div>
                                    @endif

                                    @if ($product->stock > 0)
                                        <span class="badge rounded-pill bg-success position-absolute top-0 end-0 m-2">
                                            <i class="fa-solid fa-check me-1"></i>
                                            Available
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-danger position-absolute top-0 end-0 m-2">
                                            Out of Stock
                                        </span>
                                    @endif
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <small class="text-muted mb-1">
                                        {{ $product->category?->category_name }}
                                    </small>

                                    <h3 class="h6 fw-bold">
                                        {{ Str::limit($product->product_name, 30) }}
                                    </h3>

                                    <p class="text-muted small">
                                        {{ \Illuminate\Support\Str::limit($product->description, 65) }}
                                    </p>

                                    <div class="mt-auto">
                                        <p class="fw-bold fs-5 mb-3">
                                            ${{ number_format($product->price, 2) }}
                                        </p>

                                        <a href="{{ route('products.show', $product) }}" class="btn btn-dark w-100">
                                            View Details
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

    </div>
@endsection
