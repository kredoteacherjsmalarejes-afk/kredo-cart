@extends('layouts.app')

@section('title', 'Customers')

@section('content')
    <div class="container-fluid px-0">
        <div class="row min-vh-100 ">

            @include('admin.layouts.sidebar')

            <div class="col-9 gx-5">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h1 class="h3 mb-1">Customers Management</h1>

                        <p class="text-muted mb-0">
                            Manage your store's customers
                        </p>
                    </div>
                </div>

                <table class="table table-hover align-middle bg-white border">
                    <thead class="table-dark text-white">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->category_name }}</td>
                                <td>{{ $category->description }}</td>
                                <td>{{ $category->status }}</td>
                                <td>
                                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                                        class="btn btn-lg btn-primary"><i class="fa-regular fa-pen-to-square"></i></a>

                                      <button type="button" class="btn btn-outline-danger btn-lg" data-bs-toggle="modal" data-bs-target="#delete-category-{{ $category->id }}"><i class="fa-solid fa-trash-can text-danger"></i></button>
                                    @include('admin.categories.modals.delete')

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>

@endsection
