@extends('layouts.dashboard')

@section('title', 'Edit Note - ThinkDeck') {{-- Simplified title --}}

@section('topnav-title')
    <h1 class="text-lg font-medium">Edit Note</h1>
@endsection

{{-- No additional styles needed --}}
@section('additional-styles')
    @parent
@endsection

@section('dashboard-content')

    {{-- Breadcrumbs Partial --}}
    @include('partials.breadcrumbs', [
        'breadcrumbs' => [
            ['url' => route('notes.index'), 'name' => 'Notes'], // Link back to notes index
            ['url' => route('notes.show', $note), 'name' => $note->title ?? 'Untitled Note'], // Link back to show view
            ['name' => 'Edit'] // Current action
        ]
    ])

    {{-- Flash Messages Partial - Placed subtly at the top --}}
    <!-- <div class="mb-4">
        @include('partials.flash-messages')
    </div> -->

    {{-- Ultra-Minimalist Form - No Card Wrapper --}}
    <form action="{{ route('notes.update', $note) }}" method="POST" class="space-y-4 max-w-3xl">
        @csrf
        @method('PUT')

        {{-- Hidden Icon Input (Keep existing icon, not editable here) --}}
        <input type="hidden" name="icon" value="{{ $note->icon ?? '📝' }}">

        {{-- Content Textarea - Primary Focus --}}
        <div>
            <label for="content" class="sr-only">Note Content</label>
            <textarea name="content" id="content" rows="15"
                class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-4 text-base placeholder-gray-400"
                placeholder="Start writing your note..." required autofocus>{{ old('content', $note->content) }}</textarea> {{-- Autofocus here --}}
            @error('content')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Title Input - Secondary, smaller --}}
        <div>
            <label for="title" class="sr-only">Title</label>
            <input type="text" name="title" id="title" placeholder="Add a title (optional)..."
                   class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500 py-1.5 px-3"
                   value="{{ old('title', $note->title) }}"> {{-- Pre-fill title --}}
            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

         {{-- Workspace Selection (Optional - Kept commented) --}}
         {{-- @if(isset($workspaces) && $workspaces->count() > 0) ... @endif --}}

        {{-- Form Actions - Simplified --}}
        <div class="pt-2 flex justify-end space-x-3">
            <a href="{{ route('notes.show', $note) }}" {{-- Link back to show view --}}
               class="px-3 py-1.5 border border-gray-300 rounded-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Cancel
            </a>
            <button type="submit"
                    class="px-3 py-1.5 border border-transparent rounded-md shadow-sm text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Save Changes
            </button>
        </div>
    </form>

@endsection

{{-- Remove Icon Picker JS --}}
@section('scripts')
    @parent {{-- Include parent layout's scripts --}}
    {{-- No specific scripts needed for this simple note form --}}
@endsection