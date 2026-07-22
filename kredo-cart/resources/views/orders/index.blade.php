@extends('layouts.app')

@section('title', 'My Orders')

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
                My Orders
            </li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">
                <i class="fa-solid fa-bag-shopping text-warning me-2"></i>
                My Orders
            </h1>

            <p class="text-muted mb-0">
                Track and manage your order history
            </p>
        </div>

        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-bag-shopping me-2"></i>
            Continue Shopping
        </a>
    </div>

    @if ($orders->isEmpty())
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body text-center py-5">
                <i class="fa-solid fa-box-open fa-4x text-secondary mb-3"></i>

                <h2 class="h4 fw-bold">
                    No orders yet
                </h2>

                <p class="text-muted">
                    You have not placed any orders yet.
                </p>

                <a href="{{ route('products.index') }}" class="btn btn-warning px-4">
                    Start Shopping
                </a>
            </div>
        </div>
    @else
        <div class="d-flex flex-column gap-3">

            @foreach ($orders as $order)
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">

                        <div class="row align-items-center g-3">

                            {{-- Order number --}}
                            <div class="col-lg-2 col-md-4">
                                <small class="text-muted d-block">
                                    Order Number
                                </small>

                                <strong class="fs-5">
                                    #{{ $order->id }}
                                </strong>

                                <small class="text-muted d-block mt-1">
                                    <i class="fa-regular fa-calendar me-1"></i>
                                    {{ $order->created_at->format('M d, Y') }}
                                </small>
                            </div>

                            {{-- Items --}}
                            <div class="col-lg-3 col-md-4">
                                <small class="text-muted d-block mb-2">
                                    Items
                                </small>

                                <div class="d-flex align-items-center">
                                    <div class="d-flex align-items-center me-2">
                                        @foreach ($order->orderItems->take(3) as $orderItem)
                                            @if ($orderItem->product && $orderItem->product->image)
                                                <img
                                                    src="{{ asset('storage/' . $orderItem->product->image) }}"
                                                    alt="{{ $orderItem->product_name }}"
                                                    class="rounded-circle border bg-white"
                                                    style="
                                                        width: 38px;
                                                        height: 38px;
                                                        object-fit: cover;
                                                        margin-left: {{ $loop->first ? '0' : '-8px' }};
                                                    "
                                                >
                                            @else
                                                <div
                                                    class="rounded-circle border bg-light d-flex justify-content-center align-items-center"
                                                    style="
                                                        width: 38px;
                                                        height: 38px;
                                                        margin-left: {{ $loop->first ? '0' : '-8px' }};
                                                    "
                                                >
                                                    <i class="fa-solid fa-image text-secondary small"></i>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    <span class="small">
                                        {{ $order->orderItems->sum('quantity') }}
                                        item(s)
                                    </span>
                                </div>
                            </div>

                            {{-- Total --}}
                            <div class="col-lg-2 col-md-4">
                                <small class="text-muted d-block">
                                    Total
                                </small>

                                <strong class="fs-5">
                                    ₱{{ number_format($order->total_amount, 2) }}
                                </strong>
                            </div>

                            {{-- Status --}}
                            <div class="col-lg-2 col-md-6">
                                <small class="text-muted d-block mb-2">
                                    Status
                                </small>

                                @php
                                    $statusClass = match ($order->status) {
                                        'pending' => 'bg-warning text-dark',
                                        'processing' => 'bg-primary text-white',
                                        'shipped' => 'bg-info text-dark',
                                        'delivered' => 'bg-success text-white',
                                        'cancelled' => 'bg-danger text-white',
                                        default => 'bg-secondary text-white',
                                    };
                                @endphp

                                <span class="badge {{ $statusClass }} px-3 py-2">
                                    <i class="fa-solid fa-circle me-1 small"></i>
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>

                            {{-- Action --}}
                            <div class="col-lg-3 col-md-6 text-lg-end">
                                <a
                                    href="{{ route('orders.show', $order) }}"
                                    class="btn btn-dark"
                                >
                                    <i class="fa-solid fa-eye me-2"></i>
                                    View Details
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        @if (method_exists($orders, 'links'))
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        @endif
    @endif

</div>
@endsection
