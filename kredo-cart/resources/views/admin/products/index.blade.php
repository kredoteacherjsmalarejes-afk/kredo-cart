@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <div class="container-fluid px-0">
        <div class="row min-vh-100 ">

            @include('admin.layouts.sidebar')

            <div class="col-10 p-4">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h1 class="h3 mb-1">Products Management</h1>

                        <p class="text-muted mb-0">
                            Manage your store's products
                        </p>
                    </div>

                    <a href="{{ route('admin.products.create') }}" class="btn btn-warning">
                        <i class="fa-solid fa-plus me-1"></i>
                        Add New Product
                    </a>
                </div>

                <table class="table table-hover align-middle bg-white border">
                    <thead class="table-dark text-white">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->product_name }}" width="50" height="50"
                                            class="object-fit-cover rounded">
                                    @else
                                        <span class="text-muted small">
                                            No image
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->category->category_name }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    {!! $product->status === '1' || $product->status === 1 ? '<span class="badge bg-success text-white text-center rounded-2 ">Available</span>' : '<span class="badge bg-danger text-white text-center rounded-2 ">Unavailable</span>' !!}
                                </td>
                                <td></td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                        class="btn btn-primary btn-lg"><i class="fa-regular fa-pen-to-square"></i></a>
                                    <button type="button" class="btn btn-outline-danger btn-lg" data-bs-toggle="modal" data-bs-target="#delete-product-{{ $product->id }}"><i class="fa-solid fa-trash-can text-danger"></i></button>
                                    @include('admin.products.modals.delete')
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>

@endsection
