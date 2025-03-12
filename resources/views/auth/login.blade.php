@extends('site.layouts.app')

@section('content')
<head>
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<div class="flex items-center justify-center min-h-screen bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-lg rounded-lg px-8 py-10 transform transition duration-500 hover:scale-105">
            <h2 class="text-3xl font-extrabold text-center text-gray-900 mb-8">{{ __('Login') }}</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-6 relative">
                    <label for="email" class="block text-sm font-semibold text-gray-700">{{ __('Email Address') }}</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </span>
                        <input id="email" type="email" placeholder="Enter your email" class="mt-2 block w-full pl-10 px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>
                    @error('email')
                        <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-6 relative">
                    <label for="password" class="block text-sm font-semibold text-gray-700">{{ __('Password') }}</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                            <i class="fas fa-lock text-gray-400"></i>
                        </span>
                        <input id="password" type="password" placeholder="Enter your password" class="mt-2 block w-full pl-10 px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('password') border-red-500 @enderror" name="password" required autocomplete="current-password">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" onclick="togglePasswordVisibility()" class="text-gray-400 focus:outline-none focus:text-gray-500">
                                <i id="eye-icon" class="fas fa-eye"></i>
                            </button>
                        </span>
                    </div>
                    @error('password')
                        <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" class="ml-2 block text-sm text-gray-900">{{ __('Remember Me') }}</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="text-sm font-semibold text-indigo-600 hover:text-indigo-500" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                    @endif
                </div>
                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-transform transform hover:scale-105">
                        {{ __('Login') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
function togglePasswordVisibility() {
    const passwordField = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}
</script>
@endsection
