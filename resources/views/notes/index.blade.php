<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Notes - ThinkDeck</title>
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
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">My Notes</h1>
            <a href="{{ route('notes.create') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded text-sm font-medium transition-all">
                New Note
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if($notes->isEmpty())
            <div class="text-center py-12">
                <p class="text-notion mb-4">You don't have any notes yet.</p>
                <a href="{{ route('notes.create') }}" class="inline-block px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded text-sm font-medium transition-all">
                    Create your first note
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($notes as $note)
                    <a href="{{ route('notes.show', $note) }}" class="block border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-all">
                        <div class="flex items-center mb-3">
                            <span class="text-2xl mr-2">{{ $note->icon }}</span>
                            <h3 class="text-base font-medium">{{ $note->title }}</h3>
                        </div>
                        <p class="text-notion text-sm">
                            {{ Str::limit(strip_tags($note->content), 100) ?: 'No content' }}
                        </p>
                        <div class="mt-3 text-xs text-gray-400">
                            {{ $note->updated_at->diffForHumans() }}
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>