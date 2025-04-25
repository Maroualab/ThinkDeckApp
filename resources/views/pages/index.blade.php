@extends('layouts.dashboard')

@section('title', 'Pages - ThinkDeck')

@section('topnav-title')
    <h1 class="text-lg font-medium">Pages</h1>
@endsection

@section('dashboard-content')
    <div class="flex justify-between items-center mt-8">
        <h1 class="text-2xl font-bold">All Pages</h1>
        <a href="{{ route('pages.create') }}"
           class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium transition-all flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4v16m8-8H4"></path>
            </svg>
            New Page
        </a>
    </div>

    @include('partials.flash-messages')

    @if($favorites->count() > 0)
        <div class="mb-6">
            <h2 class="text-sm font-medium text-gray-500 mb-2">FAVORITES</h2>
            <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                @foreach($favorites as $favorite)
                    <a href="{{ route('pages.show', $favorite) }}"
                       class="flex items-center px-4 py-3 border-b border-gray-100 last:border-b-0 hover:bg-gray-50">
                        <span class="text-xl mr-3">{{ $favorite->icon }}</span>
                        <div>
                            <span class="font-medium text-gray-900">{{ $favorite->title }}</span>
                            <div class="text-xs text-gray-500">Updated {{ $favorite->updated_at->diffForHumans() }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <h2 class="text-sm font-medium text-gray-500 mb-2">ALL PAGES</h2>

    @if($pages->isEmpty())
        <div class="text-center py-8 bg-white shadow-sm rounded-lg border border-gray-200">
            <p class="text-gray-600 mb-4">You don't have any pages yet.</p>
            <a href="{{ route('pages.create') }}"
               class="inline-block px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded text-sm font-medium transition-all">
                Create your first page
            </a>
        </div>
    @else
        <div class="bg-white shadow-sm rounded-lg border border-gray-200">
            @foreach($pages as $page)
                <a href="{{ route('pages.show', $page) }}"
                   class="flex items-center px-4 py-3 border-b border-gray-100 last:border-b-0 hover:bg-gray-50">
                    <span class="text-xl mr-3">{{ $page->icon }}</span>
                    <div>
                        <span class="font-medium text-gray-900">{{ $page->title }}</span>
                        <div class="text-xs text-gray-500">Updated {{ $page->updated_at->diffForHumans() }}</div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
@endsection


