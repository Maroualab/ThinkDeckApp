@extends('layouts.dashboard')

@section('title', 'Notes - ThinkDeck')

@section('topnav-title')
    <h1 class="text-lg font-medium">Notes</h1>
@endsection

@section('dashboard-content')

    {{-- Breadcrumbs Partial --}}
    @include('partials.breadcrumbs', [
        'breadcrumbs' => [
            ['name' => 'Notes'] // Current page
        ]
    ])

    {{-- Page Header --}}
    <div class="flex justify-between items-center mb-6"> {{-- Standard margin --}}
        <h1 class="text-2xl font-semibold text-gray-900">All Notes</h1> {{-- Consistent styling --}}
        <a href="{{ route('notes.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium transition-all flex items-center">
             <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
             </svg>
            New Note
        </a>
    </div>

    {{-- Flash Messages Partial --}}
    <!-- @include('partials.flash-messages') -->

    {{-- Notes Content Card --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        @if($notes->isEmpty())
            {{-- Empty State --}}
            <div class="p-8 text-center">
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {{-- Using a generic document icon --}}
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-500 mb-4">You don't have any notes yet.</p>
                <a href="{{ route('notes.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-all text-sm font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create your first note
                </a>
            </div>
        @else
            {{-- Notes Grid --}}
            {{-- Removed outer grid div, applying directly if needed or using list view --}}
            <div class="divide-y divide-gray-100"> {{-- List view similar to pages --}}
                @foreach($notes as $note)
                    <a href="{{ route('notes.show', $note) }}"
                       class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors group"> {{-- Consistent item styling --}}
                        <span class="text-xl mr-3">{{ $note->icon ?? '📝' }}</span> {{-- Consistent icon size/margin --}}
                        <div class="flex-1">
                            <span class="font-medium text-gray-800 group-hover:text-indigo-600 transition-colors truncate"> {{-- Consistent text/hover --}}
                                {{ $note->title }}
                            </span>
                            {{-- Optional: Preview - Keep it subtle --}}
                            <p class="text-sm text-gray-500 line-clamp-1">{{ Str::limit(strip_tags($note->content), 100) }}</p>
                        </div>
                        <div class="text-xs text-gray-500 ml-4 flex-shrink-0"> {{-- Updated time --}}
                            Updated {{ $note->updated_at->diffForHumans() }}
                        </div>
                        {{-- Removed edit button for cleaner index --}}
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if ($notes->hasPages())
                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200"> {{-- Consistent pagination background/border --}}
                    {{ $notes->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection