@extends('layouts.dashboard')

@section('title', 'Notes - ThinkDeck')

@section('topnav-title')
<h1 class="text-lg font-medium">Notes</h1>
@endsection

@section('dashboard-content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">All Notes</h1>
        <a href="{{ route('notes.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium transition-all">
            New Note
        </a>
    </div>
    
    @if($notes->isEmpty())
        <div class="text-center py-8">
            <p class="text-notion mb-4">You don't have any notes yet.</p>
            <a href="{{ route('notes.create') }}" class="inline-block px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded text-sm font-medium transition-all">
                Create your first note
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($notes as $note)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm transition-shadow">
                    <div class="flex items-center mb-3">
                        <span class="text-2xl mr-2">{{ $note->icon ?? '📝' }}</span>
                        <h3 class="text-lg font-medium">
                            <a href="{{ route('notes.show', $note) }}" class="hover:text-indigo-600 transition-colors">
                                {{ $note->title }}
                            </a>
                        </h3>
                    </div>
                    <div class="text-sm text-notion mb-4 line-clamp-2">
                        {{ Str::limit(strip_tags($note->content), 120) }}
                    </div>
                    <div class="flex justify-between items-center text-xs text-notion">
                        <span>{{ $note->updated_at->format('M d, Y') }}</span>
                        <div class="flex space-x-2">
                            <a href="{{ route('notes.edit', $note) }}" class="hover:text-gray-900 transition-colors">Edit</a>
                            <a href="{{ route('notes.show', $note) }}" class="hover:text-gray-900 transition-colors">View</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-6">
            {{ $notes->links() }}
        </div>
    @endif
@endsection