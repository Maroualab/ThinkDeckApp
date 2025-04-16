<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Note - ThinkDeck</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }
        .text-notion {
            color: rgba(55, 53, 47, 0.65);
        }
        .text-notion-dark {
            color: rgba(55, 53, 47, 0.9);
        }
    </style>
</head>
<body class="bg-white text-gray-900 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 py-8">
        <div class="flex items-center mb-6">
            <a href="{{ route('notes.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold">Create New Note</h1>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('notes.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <div class="flex items-center mb-2">
                    <label for="icon" class="text-lg mr-2">Icon:</label>
                    <input type="text" name="icon" id="icon" class="w-12 px-2 py-1 border border-gray-300 rounded" value="📝">
                </div>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    class="w-full px-3 py-2 text-xl font-bold border-0 border-b border-gray-200 focus:outline-none focus:border-gray-300" 
                    placeholder="Untitled" 
                    required
                    value="{{ old('title') }}"
                >
            </div>
            <div class="mb-6">
                <textarea 
                    name="content" 
                    id="content" 
                    rows="15" 
                    class="w-full px-3 py-2 border-0 focus:outline-none" 
                    placeholder="Start writing..."
                >{{ old('content') }}</textarea>
            </div>
            <div class="flex justify-end">
                <a href="{{ route('notes.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded text-sm font-medium transition-all mr-2">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded text-sm font-medium transition-all">
                    Create Note
                </button>
            </div>
        </form>
    </div>
</body>
</html>