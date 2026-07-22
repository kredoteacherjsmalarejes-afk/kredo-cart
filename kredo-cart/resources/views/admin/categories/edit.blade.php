@extends('layouts.app')

@section('title', 'Categories_Edit')

@section('content')
    <div class="container-fluid px-0">
        <div class="row min-vh-100 ">

            @include('admin.layouts.sidebar')

            <div class="col-9 gx-5 p-2">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h1 class="h3 mb-1">Edit Category</h1>

                        <p class="text-muted mb-0">
                            Update the category information to organize your products.
                        </p>
                    </div>

                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left me-1"></i>
                        Back to Categories
                    </a>
                </div>


                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="card shadow rounded-0 p-4">
                    @csrf
                    @method('PATCH')
                    <div class="card-title fs-3">Category Information</div>
                    <div class="card-body">
                        <label for="category_name" class="form-label">Category Name</label>
                        <input type="text" name="category_name" id="category_name" class="form-control" value="{{ old('category_name', $category->category_name) }}">

                        <label for="description" class="form-label mt-3">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $category->description) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-warning">Update Category</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary ms-2">
                            Cancel
                        </a>
                    </div>
                </form>


            </div>
        </div>
    </div>

@endsection
