@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="container-fluid px-0">
    <div class="row min-vh-100 ">

       @include('admin.layouts.sidebar')

{{-- Main content --}}
        <main class="col-md-9 bg-light p-4">
            <div class="d-flex justify-content-between align-items-start mb-4">

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb small mb-2">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.products.index') }}"
                                   class="text-decoration-none text-muted">
                                    Products
                                </a>
                            </li>

                            <li class="breadcrumb-item active">
                                Edit Product
                            </li>
                        </ol>
                    </nav>

                    <h1 class="h3 mb-1">Edit Product</h1>

                    <p class="text-muted mb-0">
                        Edit the details of your marketplace item.
                    </p>

                <a href="{{ route('admin.products.index') }}"
                   class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i>
                    Back to Products
                </a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Please correct the following errors:</strong>

                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                action="{{ route('admin.products.update', $product->id) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PATCH')

                <div class="row g-3">
                    {{-- Left side --}}
                    <div class="col-lg-8">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white fw-bold py-3">
                                Product Information
                            </div>

                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="product_name" class="form-label">
                                        Product Name
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        id="product_name"
                                        name="product_name"
                                        value="{{ old('product_name', $product->product_name) }}"
                                        class="form-control @error('product_name') is-invalid @enderror"
                                        placeholder="e.g. Wireless Noise-Canceling Headphones"
                                        required
                                    >

                                    @error('product_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="category_id" class="form-label">
                                        Category
                                        <span class="text-danger">*</span>
                                    </label>

                                    <select
                                        id="category_id"
                                        name="category_id"
                                        class="form-select @error('category_id') is-invalid @enderror"
                                        required
                                    >
                                        <option value="">
                                            Select a Category
                                        </option>

                                        @foreach ($categories as $category)
                                            <option
                                                value="{{ $category->id }}"
                                                @selected(old('category_id', $product->category_id) == $category->id)
                                            >
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('category_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="description" class="form-label">
                                        Description
                                        <span class="text-danger">*</span>
                                    </label>

                                    <textarea
                                        id="description"
                                        name="description"
                                        rows="6"
                                        class="form-control @error('description') is-invalid @enderror"
                                        placeholder="Provide a detailed description of the product..."
                                        required
                                    >{{ old('description', $product->description) }}</textarea>

                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right side --}}
                    <div class="col-lg-4">
                        <div class="card shadow-sm mb-3">
                            <div class="card-header bg-white fw-bold py-3">
                                Pricing & Inventory
                            </div>

                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="price" class="form-label">
                                        Price
                                        <span class="text-danger">*</span>
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text">$</span>

                                        <input
                                            type="number"
                                            id="price"
                                            name="price"
                                            value="{{ old('price', $product->price) }}"
                                            min="0"
                                            step="0.01"
                                            class="form-control @error('price') is-invalid @enderror"
                                            placeholder="0.00"
                                            required
                                        >
                                    </div>

                                    @error('price')
                                        <div class="text-danger small mt-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="stock" class="form-label">
                                        Stock Quantity
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input
                                        type="number"
                                        id="stock"
                                        name="stock"
                                        value="{{ old('stock', $product->stock) }}"
                                        min="0"
                                        class="form-control @error('stock') is-invalid @enderror"
                                        required
                                    >

                                    @error('stock')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="status" class="form-label">
                                        Status
                                        <span class="text-danger">*</span>
                                    </label>

                                    <select
                                        id="status"
                                        name="status"
                                        class="form-select @error('status') is-invalid @enderror"
                                        required
                                    >
                                        <option value="1" @selected(old('status', $product->status) === '1')>
                                            Available
                                        </option>

                                        <option value="2" @selected(old('status', $product->status) === '2')>
                                            Unavailable
                                        </option>
                                    </select>

                                    @error('status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm mb-3">
                            <div class="card-header bg-white fw-bold py-3">
                                Product Image
                            </div>

                            <div class="card-body">
                                <label for="image" class="form-label">
                                    Upload Image
                                    <span class="text-muted">(Optional)</span>
                                </label>

                                <input
                                    type="file"
                                    id="image"
                                    name="image"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    class="form-control @error('image') is-invalid @enderror"
                                >

                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <p class="small text-muted mb-0 mt-2">
                                    Recommended formats: JPG, PNG, WEBP
                                </p>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning w-100 mb-2">
                            <i class="fa-solid fa-floppy-disk me-1"></i>
                            Save Product
                        </button>

                        <a href="{{ route('admin.products.index') }}"
                           class="btn btn-light border w-100">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>
@endsection
