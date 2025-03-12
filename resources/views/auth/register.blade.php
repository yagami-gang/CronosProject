@extends('site.layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-lg rounded-lg px-8 py-10 transform transition duration-500 hover:scale-105">
            <h2 class="text-3xl font-extrabold text-center text-gray-900 mb-8">{{ __('Register') }}</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-6 relative">
                    <label for="name" class="block text-sm font-semibold text-gray-700">{{ __('Name') }}</label>
                    <input id="name" type="text" placeholder="Enter your name" class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('name') border-red-500 @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                        <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-6 relative">
                    <label for="email" class="block text-sm font-semibold text-gray-700">{{ __('Email Address') }}</label>
                    <input id="email" type="email" placeholder="Enter your email" class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-6 relative">
                    <label for="password" class="block text-sm font-semibold text-gray-700">{{ __('Password') }}</label>
                    <input id="password" type="password" placeholder="Enter your password" class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('password') border-red-500 @enderror" name="password" required autocomplete="new-password">
                    @error('password')
                        <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-6 relative">
                    <label for="password-confirm" class="block text-sm font-semibold text-gray-700">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" placeholder="Confirm your password" class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" name="password_confirmation" required autocomplete="new-password">
                </div>
                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-transform transform hover:scale-105">
                        {{ __('Register') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
