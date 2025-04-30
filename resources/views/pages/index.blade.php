@extends('layouts.dashboard')

@section('title', 'Pages - ThinkDeck')

@section('topnav-title')
    <h1 class="text-lg font-medium">Pages</h1>
@endsection

@section('dashboard-content')

    {{-- Breadcrumbs Partial --}}
    @include('partials.breadcrumbs', [
        'breadcrumbs' => [
            ['name' => 'Pages'] // Current page
        ]
    ])

    {{-- Page Header --}}
    <div class="flex justify-between items-center mb-6"> {{-- Removed mt-8, mb-6 is standard --}}
        <h1 class="text-2xl font-semibold text-gray-900">All Pages</h1> {{-- Changed font-bold to font-semibold --}}
        <a href="{{ route('pages.create') }}"
           class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium transition-all flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4v16m8-8H4"></path>
            </svg>
            New Page
        </a>
    </div>

   

    {{-- Favorites Section --}}
    @if($favorites->count() > 0)
        <div class="mb-6">
            <h2 class="text-sm font-medium text-gray-500 mb-2 uppercase tracking-wider">Favorites</h2> {{-- Added uppercase/tracking --}}
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden"> {{-- Added overflow-hidden --}}
                <div class="divide-y divide-gray-100"> {{-- Added wrapper div for divide --}}
                    @foreach($favorites as $favorite)
                        <a href="{{ route('pages.show', $favorite) }}"
                           class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors"> {{-- Added transition --}}
                            <span class="text-xl mr-3">{{ $favorite->icon ?? '📄' }}</span> {{-- Added default icon --}}
                            <div>
                                <span class="font-medium text-gray-800 hover:text-indigo-600 transition-colors">{{ $favorite->title }}</span> {{-- Adjusted text color/hover --}}
                                <div class="text-xs text-gray-500">Updated {{ $favorite->updated_at->diffForHumans() }}</div>
                            </div>
                            {{-- Optional: Add actions like unfavorite here --}}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- All Pages Section --}}
    <h2 class="text-sm font-medium text-gray-500 mb-2 uppercase tracking-wider">All Pages</h2> {{-- Added uppercase/tracking --}}

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden"> {{-- Consistent card structure --}}
        @if($pages->isEmpty() && $favorites->isEmpty()) {{-- Check both lists for true empty state --}}
            {{-- Empty State --}}
            <div class="p-8 text-center">
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-500 mb-4">You don't have any pages yet.</p>
                <a href="{{ route('pages.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-all text-sm font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create your first page
                </a>
            </div>
        @else
            {{-- Pages List --}}
            <div class="divide-y divide-gray-100">
                @forelse($pages as $page) {{-- Use forelse for consistency --}}
                    <a href="{{ route('pages.show', $page) }}"
                       class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors"> {{-- Added transition --}}
                        <span class="text-xl mr-3">{{ $page->icon ?? '📄' }}</span> {{-- Added default icon --}}
                        <div>
                            <span class="font-medium text-gray-800 hover:text-indigo-600 transition-colors">{{ $page->title }}</span> {{-- Adjusted text color/hover --}}
                            <div class="text-xs text-gray-500">Updated {{ $page->updated_at->diffForHumans() }}</div>
                        </div>
                        {{-- Optional: Add actions like favorite/delete here --}}
                    </a>
                @empty
                    {{-- Only show this if favorites exist but regular pages don't --}}
                    @if($favorites->count() > 0)
                        <div class="p-6 text-center text-gray-500">
                            No other pages found.
                        </div>
                    @endif
                @endforelse
            </div>
        @endif

        {{-- Pagination --}}
        @if ($pages->hasPages())
            <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                {{ $pages->links() }}
            </div>
        @endif
    </div>
@endsection


