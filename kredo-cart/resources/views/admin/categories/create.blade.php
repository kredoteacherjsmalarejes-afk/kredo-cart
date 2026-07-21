@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <div class="container-fluid px-0">
        <div class="row min-vh-100 ">

            @include('admin.layouts.sidebar')

            <div class="col-10 gx-5">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h1 class="h3 mb-1">Add New Category</h1>

                        <p class="text-muted mb-0">
                            Create a new category to organize your products.
                        </p>
                    </div>

                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left me-1"></i>
                        Back to Categories
                    </a>

                    <div class="card">
                        <h4 class="card-title">Category Information</h4>

                        <div class="card-body">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">

                            <label for="description" class="form-label mt-3">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection
