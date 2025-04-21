@extends('layouts.dashboard')

@section('title', 'Pages - ThinkDeck')

@section('topnav-title')
<h1 class="text-lg font-medium">Pages</h1>
@endsection

@section('dashboard-content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">All Pages</h1>
        <a href="{{ route('pages.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium transition-all">
            New Page
        </a>
    </div>
    
    @if($favorites->count() > 0)
        <div class="mb-6">
            <h2 class="text-sm font-medium text-gray-500 mb-2">FAVORITES</h2>
            <div class="space-y-1">
                @foreach($favorites as $favorite)
                    <a href="{{ route('pages.show', $favorite) }}" class="flex items-center px-2 py-1.5 page-tree-item">
                        <span class="text-xl mr-2">{{ $favorite->icon }}</span>
                        <span class="text-notion-dark">{{ $favorite->title }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <h2 class="text-sm font-medium text-gray-500 mb-2">ALL PAGES</h2>
    
    @if($rootPages->isEmpty())
        <div class="text-center py-8">
            <p class="text-notion mb-4">You don't have any pages yet.</p>
            <a href="{{ route('pages.create') }}" class="inline-block px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded text-sm font-medium transition-all">
                Create your first page
            </a>
        </div>
    @else
        <div class="space-y-1">
            @foreach($rootPages as $page)
                <div>
                    <a href="{{ route('pages.show', $page) }}" class="flex items-center px-2 py-1.5 page-tree-item">
                        <span class="text-xl mr-2">{{ $page->icon }}</span>
                        <span class="text-notion-dark">{{ $page->title }}</span>
                        
                        @if($page->children->count() > 0)
                            <span class="ml-2 text-xs text-gray-400">({{ $page->children->count() }})</span>
                        @endif
                    </a>
                    
                    @if($page->children->count() > 0)
                        <div class="child-pages">
                            @foreach($page->children as $child)
                                <a href="{{ route('pages.show', $child) }}" class="flex items-center px-2 py-1.5 page-tree-item">
                                    <span class="text-xl mr-2">{{ $child->icon }}</span>
                                    <span class="text-notion-dark">{{ $child->title }}</span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
@endsection