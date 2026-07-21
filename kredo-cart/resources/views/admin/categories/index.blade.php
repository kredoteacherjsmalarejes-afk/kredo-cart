@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <div class="container-fluid px-0">
        <div class="row min-vh-100 ">

            @include('admin.layouts.sidebar')

            <div class="col-9 gx-5">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h1 class="h3 mb-1">Categories Management</h1>

                        <p class="text-muted mb-0">
                            Manage your store's categories
                        </p>
                    </div>

                    <a href="{{ route('admin.categories.create') }}" class="btn btn-warning">
                        <i class="fa-solid fa-plus me-1"></i>
                        Add New Category
                    </a>
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
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->description }}</td>
                                <td>{{ $category->status }}</td>
                                <td>
                                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                                        class="btn btn-sm btn-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
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
