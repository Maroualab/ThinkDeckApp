<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FFFDE7] min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-sm border border-[#f5f5c633] p-8">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-medium text-gray-800">Create your account</h1>
                <p class="text-gray-500 mt-1">Join ThinkDeck today</p>
            </div>
            
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf
                
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-1 focus:ring-[#FFEB3B] focus:border-[#FFEB3B] transition"
                        required 
                        autofocus 
                        autocomplete="name"
                        value="{{ old('name') }}"
                    >
                    @error('name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-1 focus:ring-[#FFEB3B] focus:border-[#FFEB3B] transition"
                        required 
                        autocomplete="email"
                        value="{{ old('email') }}"
                    >
                    @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-1 focus:ring-[#FFEB3B] focus:border-[#FFEB3B] transition"
                        required 
                        autocomplete="new-password"
                    >
                    @error('password')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm password</label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        id="password_confirmation" 
                        class="w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-1 focus:ring-[#FFEB3B] focus:border-[#FFEB3B] transition"
                        required 
                        autocomplete="new-password"
                    >
                </div>
                
                <div>
                    <button 
                        type="submit" 
                        class="w-full bg-[#FFEB3B] hover:bg-[#FFF176] text-gray-800 font-medium py-2 px-4 rounded-md transition duration-200"
                    >
                        Register
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center text-sm text-gray-500">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-[#FBC02D] hover:underline">Log in</a>
            </div>
        </div>
        
        <div class="mt-6 text-center text-xs text-gray-500">
            By registering, you agree to our Terms of Service and Privacy Policy.
        </div>
    </div>
</body>
</html>