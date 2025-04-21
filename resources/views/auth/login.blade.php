@extends('layouts.auth')

@section('title', 'Login - ThinkDeck')

@section('auth-content')
<h2 class="text-2xl font-bold mb-6 text-center">Log in to ThinkDeck</h2>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
    </div>

    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input id="password" type="password" name="password" required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
    </div>

    <div class="flex items-center mb-4">
        <input type="checkbox" id="remember_me" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
        <label for="remember_me" class="ml-2 block text-sm text-gray-700">Remember me</label>
    </div>

    @if (Route::has('password.request'))
        <div class="text-sm mb-6 text-right">
            <a class="text-indigo-600 hover:text-indigo-500" href="{{ route('password.request') }}">
                Forgot your password?
            </a>
        </div>
    @endif

    <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        Log in
    </button>
</form>
@endsection

@section('footer-text')
Don't have an account? <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-500">Sign up</a>
@endsection