@extends('layouts.dashboard')

@section('title', 'New Note - ThinkDeck')

@section('topnav-title')
    {{-- Minimal topnav title --}}
    <h1 class="text-lg font-medium">New Note</h1>
@endsection

{{-- No additional styles needed --}}
@section('additional-styles')
    @parent
@endsection

@section('dashboard-content')

    {{-- Removed Breadcrumbs --}}
    {{-- Removed Page Header --}}

    {{-- Flash Messages Partial - Placed subtly at the top --}}
    

    {{-- Ultra-Minimalist Form --}}
    <form action="{{ route('notes.store') }}" method="POST" class="space-y-4 max-w-3xl"> {{-- Reduced vertical spacing --}}
        @csrf
        {{-- Hidden Icon Input (Defaulting to Note Emoji) --}}
        <input type="hidden" name="icon" value="📝">

        {{-- Content Textarea - Primary Focus --}}
        <div>
            <label for="content" class="sr-only">Note Content</label>
            <textarea name="content" id="content" rows="15" {{-- Generous rows --}}
                class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-4 text-base placeholder-gray-400" {{-- Slightly lighter placeholder --}}
                placeholder="Start writing your note..." required autofocus>{{ old('content') }}</textarea> {{-- Autofocus here --}}
            @error('content')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Title Input - Secondary, smaller --}}
        <div>
            <label for="title" class="sr-only">Title</label>
            <input type="text" name="title" id="title" placeholder="Add a title (optional)..."
                   class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500 py-1.5 px-3" {{-- Smaller text/padding --}}
                   value="{{ old('title') }}">
            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

         {{-- Workspace Selection (Optional - Kept commented) --}}
         {{-- @if(isset($workspaces) && $workspaces->count() > 0) ... @endif --}}

        {{-- Form Actions - Simplified --}}
        <div class="pt-2 flex justify-end space-x-3"> {{-- Reduced top padding --}}
            <a href="{{ route('notes.index') }}"
               class="px-3 py-1.5 border border-gray-300 rounded-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"> {{-- Smaller button --}}
                Cancel
            </a>
            <button type="submit"
                    class="px-3 py-1.5 border border-transparent rounded-md shadow-sm text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"> {{-- Smaller button --}}
                Save Note
            </button>
        </div>
    </form>

@endsection

{{-- No specific scripts needed --}}
@section('scripts')
    @parent
@endsection