@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-2">


            </div>
            <div class="col-10">
                <h1>Products Management</h1>
                <table class="table">
                    <thead>
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
                        @foreach($products as $product)
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
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i></button>
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
