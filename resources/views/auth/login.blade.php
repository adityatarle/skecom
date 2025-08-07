@php use Illuminate\Support\Facades\Route; @endphp
@extends('layouts.app')

<style>
    #login-sec{
        background: url('assets/img/slider/slider4.jpg') no-repeat center/cover, linear-gradient(135deg, #f9f5f3 0%, #eee9e5 100%);
    }
    .card {
        background: #eee9e5;
        position: relative;
        overflow: hidden;
    }

    .card::before {
        content: '';
        position: absolute;
        top: -30px;
        left: -30px;
        width: 60px;
        height: 60px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.3), transparent);
        opacity: 0.4;
    }

    .btn-submit {
        background: linear-gradient(90deg, #c19a6b, #a67b5b);
        border: none;
        transition: transform 0.2s ease;
    }

    .btn-submit:hover {
        background: linear-gradient(90deg, #a67b5b, #c19a6b);
        transform: translateY(-2px);
    }

    .form-control {
        background: #b89f7e !important;
        border-color: #b89f7e;
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25) !important;
        background: linear-gradient(135deg, #f8f1e9 0%, #e8e2d9 100%) !important;
    }

    .form-control:focus {
        border-color: #b89f7e;
        box-shadow: 0 0 0 0.25rem rgba(192, 192, 192, 0.25);
    }
</style>

@section('content')
<section class="d-flex align-items-center" id="login-sec">
    <div class="container">
        <div class="row justify-content-center py-5">
            <div class="col-md-8 col-lg-5">
                <div class="card border-0 shadow-lg rounded-3">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <img src="{{ asset('assets/img/logo/logo.jpg') }}" alt="Brand Logo" class="img-fluid mb-3" style="max-width: 100px;">
                            <h2 class="fw-bold mb-2">Welcome Back</h2>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="email" class="form-label fw-medium">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-control rounded-3 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="your@email.com">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-medium">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control rounded-3 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-4 form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-muted" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-submit rounded-3 py-2 fw-medium text-white">
                                    {{ __('Sign In') }}
                                </button>
                            </div>

                            @if (Route::has('password.request'))
                            <div class="text-center">
                                <a href="{{ route('password.request') }}" class="text-decoration-none text-primary small">
                                    {{ __('Forgot Password?') }}
                                </a>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection