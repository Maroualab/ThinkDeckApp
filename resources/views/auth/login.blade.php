<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FFFDE7] min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-sm border border-[#f5f5c633] p-8">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-medium text-gray-800">Welcome back</h1>
                <p class="text-gray-500 mt-1">Log in to continue to ThinkDeck</p>
            </div>
            
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-1 focus:ring-[#FFEB3B] focus:border-[#FFEB3B] transition" 
                        required 
                        autofocus 
                        autocomplete="email"
                        value="{{ old('email') }}"
                    >
                    @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs text-[#FBC02D] hover:underline">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-1 focus:ring-[#FFEB3B] focus:border-[#FFEB3B] transition" 
                        required 
                        autocomplete="current-password"
                    >
                    @error('password')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        name="remember" 
                        id="remember" 
                        class="h-4 w-4 text-[#FFEB3B] focus:ring-[#FFEB3B] border-gray-300 rounded"
                        {{ old('remember') ? 'checked' : '' }}
                    >
                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                        Remember me
                    </label>
                </div>
                
                <div>
                    <button 
                        type="submit" 
                        class="w-full bg-[#FFEB3B] hover:bg-[#FFF176] text-gray-800 font-medium py-2 px-4 rounded-md transition duration-200"
                    >
                        Log in
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center text-sm text-gray-500">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-[#FBC02D] hover:underline">Register</a>
            </div>
        </div>
    </div>
</body>
</html>