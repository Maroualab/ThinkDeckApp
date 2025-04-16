<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $note->title }} - ThinkDeck</title>
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
            <h1 class="text-2xl font-bold flex-1">
                <span class="text-2xl mr-2">{{ $note->icon }}</span>
                {{ $note->title }}
            </h1>
            <div class="flex space-x-2">
                <a href="{{ route('notes.edit', $note) }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded text-sm font-medium transition-all">
                    Edit
                </a>
                <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this note?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded text-sm font-medium transition-all">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-6 text-notion-dark">
            {!! nl2br(e($note->content)) ?: '<p class="text-notion">No content</p>' !!}
        </div>

        <div class="mt-10 pt-4 border-t border-gray-200 text-sm text-gray-400">
            <div>Created: {{ $note->created_at->format('F j, Y') }}</div>
            <div>Last updated: {{ $note->updated_at->format('F j, Y g:i A') }}</div>
        </div>
    </div>
</body>
</html>