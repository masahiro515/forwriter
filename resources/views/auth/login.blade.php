@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center pt-5">
    <div class="card shadow-sm p-4" style="border-radius: 15px; width: 100%; max-width: 400px;">
        <h3 class="text-center mb-4">{{ __('Login') }}</h3>

        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                        placeholder="Enter your email">

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password"
                        placeholder="********">

                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Remember me & Forgot password --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="small" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>

                {{-- Login button --}}
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Sign in') }}
                    </button>
                </div>

                {{-- Google Login button --}}
                <div class="d-grid mb-3">
                    <a href="{{ route('login.google') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google" style="height:20px; margin-right:8px;">
                        <span>Sign in with Google</span>
                    </a>
                </div>

                {{-- Register link --}}
                <div class="text-center mt-2">
                    <small>
                        アカウントをお持ちでないですか？
                        <a href="{{ route('register') }}" class="text-danger">無料で登録</a>
                    </small>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

