@extends('layouts.dashboard')

@section('title', "{$page->title} - ThinkDeck")

@section('topnav-title')
    {{-- Keep this minimal, maybe just the resource type --}}
    <h1 class="text-lg font-medium text-gray-700">Page View</h1>
@endsection

@section('dashboard-content')

    {{-- Breadcrumbs & Actions Header --}}
    <div class="pt-4 mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">

        {{-- Breadcrumbs Partial --}}
        @include('partials.breadcrumbs', [
            'breadcrumbs' => [
                ['url' => route('pages.index'), 'name' => 'Pages'], // Link back to pages index
                ['name' => $page->title] // Current page (not linked)
            ]
        ])

        {{-- Action Buttons --}}
        <div class="flex items-center space-x-2 flex-shrink-0">
            <a href="{{ route('pages.edit', $page) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 rounded-md text-sm font-medium transition-colors duration-150" title="Edit page">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-10 10a2 2 0 01-1.414.586H4a1 1 0 01-1-1v-1a2 2 0 01.586-1.414l10-10z" />
                </svg>
                Edit
            </a>
            <form action="{{ route('pages.destroy', $page) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this page? This action cannot be undone.');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent bg-red-50 hover:bg-red-100 text-red-700 rounded-md text-sm font-medium transition-colors duration-150" title="Delete page">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    Delete
                </button>
            </form>
        </div>
    </div>


    {{-- Page Content Card --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">

        {{-- Card Header with Icon and Title --}}
        <div class="p-5 sm:p-6 border-b border-gray-200 bg-gray-50/50"> {{-- Subtle header background --}}
            <div class="flex items-center space-x-3">
                <span class="text-3xl flex-shrink-0">{{ $page->icon ?? '📄' }}</span>
                <h1 class="text-2xl font-semibold text-gray-800 leading-tight truncate">
                    {{ $page->title }}
                </h1>
            </div>
        </div>

        {{-- Content Area --}}
        <div class="p-6 sm:p-8">
            {{-- Apply prose styles for nice HTML rendering from Summernote --}}
            {{-- Ensure content is sanitized server-side before storing/displaying --}}
            <article class="prose prose-indigo lg:prose-lg max-w-none">
                {!! $page->content !!} {{-- Use {!! !!} to render HTML --}}
            </article>
        </div>

        {{-- Card Footer with Metadata --}}
        <div class="px-6 py-3 bg-gray-50/50 border-t border-gray-200 text-xs text-gray-500 flex items-center justify-end space-x-4">
             {{-- Optional: Add Workspace info if applicable --}}
            {{-- @if($page->workspace)
            <span class="flex items-center" title="Workspace">
                <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                {{ $page->workspace->name }}
            </span>
            @endif --}}
            <span class="flex items-center" title="Created Date">
                 <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                {{ $page->created_at->format('M d, Y') }}
            </span>
            @if($page->updated_at->gt($page->created_at->addSeconds(60))) {{-- Increased buffer --}}
                <span class="flex items-center" title="Last Updated">
                    <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m-15.357-2a8.001 8.001 0 0015.357 2m0 0H15"></path></svg>
                    {{ $page->updated_at->diffForHumans() }}
                </span>
            @endif
        </div>
    </div>

@endsection

{{-- Add specific styles if needed --}}
@section('additional-styles')
    @parent
    {{-- Add any styles specific to the show page if necessary --}}
@endsection

{{-- Add specific scripts if needed --}}
@section('scripts')
    @parent
    {{-- Add any scripts specific to the show page if necessary --}}
@endsection