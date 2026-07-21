@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5 col-xl-4">

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">

                    {{-- Login icon --}}
                    <div class="text-center mb-3">
                        <div class="d-inline-flex justify-content-center align-items-center rounded-circle bg-warning-subtle"
                            style="width: 60px; height: 60px;">

                            <i class="fa-solid fa-right-to-bracket text-warning fs-3"></i>
                        </div>
                    </div>

                    {{-- Title --}}
                    <div class="text-center mb-4">
                        <h1 class="h3 fw-bold mb-1">
                            Welcome Back
                        </h1>

                        <p class="text-muted small mb-0">
                            Sign in to your account to continue
                        </p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

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
                                class="form-control py-2 rounded-3 @error('email') is-invalid @enderror"
                                placeholder="Enter your email"
                                autocomplete="email"
                                autofocus
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
                                class="form-control py-2 rounded-3 @error('password') is-invalid @enderror"
                                placeholder="Enter your password"
                                autocomplete="current-password"
                                required
                            >

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Remember / Forgot password --}}
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="remember"
                                    id="remember"
                                    {{ old('remember') ? 'checked' : '' }}
                                >

                                <label class="form-check-label small" for="remember">
                                    Remember Me
                                </label>
                            </div>

                            @if (Route::has('password.request'))
                                <a
                                    href="{{ route('password.request') }}"
                                    class="small text-primary text-decoration-none"
                                >
                                    Forgot Password?
                                </a>
                            @endif
                        </div>

                        {{-- Login button --}}
                        <button
                            type="submit"
                            class="btn btn-dark w-100 py-2 fw-semibold rounded-3"
                        >
                            Login
                        </button>
                    </form>

                    {{-- Register link --}}
                    <p class="text-center text-muted small mt-3 mb-0">
                        Don’t have an account?

                        <a
                            href="{{ route('register') }}"
                            class="text-primary text-decoration-none fw-semibold"
                        >
                            Create one
                        </a>
                    </p>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
