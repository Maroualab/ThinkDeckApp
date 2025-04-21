@extends('layouts.dashboard')

@section('title', "{$page->title} - ThinkDeck")

@section('topnav-title')
<div class="flex items-center">
    <span class="text-2xl mr-3">{{ $page->icon }}</span>
    <h1 class="text-xl font-semibold">{{ $page->title }}</h1>
</div>
@endsection

@section('dashboard-content')
    <div class="space-y-6">
        <!-- Page header section -->
        <div class="flex justify-between items-center">
            <div>
                @include('partials.breadcrumbs', [
                    'resourceType' => 'pages',
                    'current' => $page->title
                ])
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('pages.edit', $page) }}" class="inline-flex items-center px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-md text-sm font-medium transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-10 10a2 2 0 01-1.414.586H4a1 1 0 01-1-1v-1a2 2 0 01.586-1.414l10-10z" />
                    </svg>
                    Edit
                </a>
                
                <form action="{{ route('pages.destroy', $page) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this page? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 rounded-md text-sm font-medium transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <!-- Page content -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
            <div class="p-6">
                <div class="prose max-w-none">
                    {!! $page->parsed_content !!}
                </div>
            </div>
        </div>
        
        <!-- Page metadata -->
        <div class="flex items-center text-sm text-gray-500">
            <span class="mr-4">Created: {{ $page->created_at->format('M d, Y') }}</span>
            @if($page->updated_at->gt($page->created_at))
                <span>Last updated: {{ $page->updated_at->diffForHumans() }}</span>
            @endif
        </div>
    </div>
@endsection