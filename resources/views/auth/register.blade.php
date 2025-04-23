@extends('layouts.auth')

@section('title', 'Register - ThinkDeck')

@section('auth-content')
<h2 class="text-2xl font-bold mb-6 text-center">Create your account</h2>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            @error('name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        </div>

    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input id="password" type="password" name="password" required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror">
        @if ($errors->has('password'))
            <p class="text-red-500 text-xs mt-1">
                {{ $errors->first('password') }}
            </p>
        @endif
    </div>

    <div class="mb-6">
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
    </div>

    <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        Register
    </button>
</form>
@endsection

@section('footer-text')
Already have an account? <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500">Log in</a>
@endsection