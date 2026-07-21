@extends('layouts.app')

@section('title', 'Create Account')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5 col-xl-4">

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">

                    {{-- Icon --}}
                    <div class="text-center mb-3">
                        <div class="d-inline-flex justify-content-center align-items-center rounded-circle bg-warning-subtle"
                            style="width: 60px; height: 60px;">

                            <i class="fa-solid fa-user-plus text-warning fs-3"></i>
                        </div>
                    </div>

                    {{-- Title --}}
                    <div class="text-center mb-4">
                        <h1 class="h3 fw-bold mb-1">
                            Create Account
                        </h1>

                        <p class="text-muted small mb-0">
                            Join us and start shopping today
                        </p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Full Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">
                                Full Name
                            </label>

                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control py-2 @error('name') is-invalid @enderror"
                                placeholder="Enter your full name"
                                autocomplete="name"
                                autofocus
                                required
                            >

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">
                                Email Address
                            </label>

                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control py-2 @error('email') is-invalid @enderror"
                                placeholder="Enter your email"
                                autocomplete="email"
                                required
                            >

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">
                                Password
                            </label>

                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="form-control py-2 @error('password') is-invalid @enderror"
                                placeholder="Create a password"
                                autocomplete="new-password"
                                required
                            >

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-4">
                            <label for="password-confirm" class="form-label fw-semibold">
                                Confirm Password
                            </label>

                            <input
                                id="password-confirm"
                                type="password"
                                name="password_confirmation"
                                class="form-control py-2"
                                placeholder="Confirm your password"
                                autocomplete="new-password"
                                required
                            >
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn btn-dark w-100 py-2 fw-semibold">
                            Create Account
                        </button>
                    </form>

                    {{-- Login link --}}
                    <p class="text-center text-muted small mt-3 mb-0">
                        Already have an account?

                        <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-semibold">
                            Sign In
                        </a>
                    </p>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
