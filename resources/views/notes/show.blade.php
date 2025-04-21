@extends('layouts.dashboard')

@section('title', $note->title . ' - ThinkDeck')

@section('topnav-title')
<div class="flex items-center">
    <span class="text-xl mr-2">{{ $note->icon ?? '📝' }}</span>
    <h1 class="text-lg font-medium">{{ $note->title }}</h1>
</div>
@endsection

@section('dashboard-content')
    @include('partials.breadcrumbs', [
        'resourceType' => 'notes',
        'current' => $note->title
    ])
    
    <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
        <div class="prose max-w-none">
            {{ $note->content }}
        </div>
    </div>
    
    <div class="mt-8 flex space-x-4">
        <a href="{{ route('notes.edit', $note) }}" class="px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded text-sm font-medium transition-all border border-gray-200">
            Edit Note
        </a>
        
        <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this note?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-white hover:bg-red-50 text-red-600 rounded text-sm font-medium transition-all border border-red-200">
                Delete Note
            </button>
        </form>
    </div>
    
    <div class="mt-6 text-xs text-gray-500 flex items-center">
        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        Last updated {{ $note->updated_at->diffForHumans() }}
    </div>
@endsection