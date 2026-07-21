@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <div class="container-fluid px-0">
        <div class="row min-vh-100 ">
            <aside class="col-md-2 bg-dark text-white p-3">
                <h4>Admin</h4>

                <nav class="nav flex-column">
                    <a href="{{ route('admin.products.index') }}" class="nav-link text-white">
                        Products
                    </a>

                    <a href="{{ route('admin.categories.index') }}" class="nav-link text-white">
                        Categories
                    </a>

                    <a href="{{ route('admin.orders.index') }}" class="nav-link text-white">
                        Orders
                    </a>

                    <a href="#" class="nav-link text-white">
                        Customers
                    </a>
                </nav>
            </aside>


            <div class="col-9 gx-5">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h1 class="h3 mb-1">Categories Management</h1>

                        <p class="text-muted mb-0">
                            Manage your store's product categories
                        </p>
                    </div>

                    <a href="" class="btn btn-warning">
                        <i class="fa-solid fa-plus me-1"></i>
                        Add New Category
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
                            <th></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td><img src="{{ $product->image_url }}" alt="{{ $product->name }}" width="50"></td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->status }}</td>
                                <td></td>
                                <td></td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                        class="btn btn-sm btn-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i
                                                class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>

@endsection
