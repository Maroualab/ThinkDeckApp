@extends('layouts.dashboard')

@section('title', $workspace->name . ' - ThinkDeck')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <div class="flex items-center text-sm text-gray-500 mb-6">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition">Dashboard</a>
        <svg class="w-3 h-3 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <a href="{{ route('workspaces.index') }}" class="hover:text-indigo-600 transition">Workspaces</a>
        <svg class="w-3 h-3 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="text-gray-700">{{ $workspace->name }}</span>
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-800 rounded-lg p-4 mb-6 flex items-start">
            <svg class="w-5 h-5 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>{{ session('success') }}</div>
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-50 text-red-800 rounded-lg p-4 mb-6 flex items-start">
            <svg class="w-5 h-5 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <!-- Workspace Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center">
            <div class="flex items-center mb-4 lg:mb-0">
                <span class="text-3xl mr-3">{{ $workspace->icon }}</span>
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">{{ $workspace->name }}</h1>
                    @if($workspace->description)
                        <p class="text-gray-500 mt-1">{{ $workspace->description }}</p>
                    @endif
                    <div class="mt-1 flex items-center text-sm">
                        @if($workspace->is_default)
                            <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-xs rounded-full mr-2">Default Workspace</span>
                        @endif
                        <span class="text-gray-500">Created {{ $workspace->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('workspaces.switch', $workspace) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-all flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                    Switch to Workspace
                </a>
                <a href="{{ route('workspaces.edit', $workspace) }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <form action="{{ route('workspaces.destroy', $workspace) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this workspace?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 border border-red-300 rounded-md text-sm font-medium text-red-700 bg-white hover:bg-red-50 transition-all flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Workspace Content -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pages in this workspace -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-5 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-medium flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Pages
                </h2>
                <a href="{{ route('pages.create', ['workspace_id' => $workspace->id]) }}" class="text-sm text-indigo-600 hover:text-indigo-800 transition flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    New Page
                </a>
            </div>
            
            <div class="divide-y divide-gray-100">
                @forelse($pages as $page)
                    <a href="{{ route('pages.show', $page) }}" class="block p-4 hover:bg-gray-50 transition">
                        <h3 class="text-sm font-medium mb-1 flex items-center">
                            <span class="page-icon mr-2">{{ $page->icon ?? '📄' }}</span>
                            {{ Str::limit($page->title, 40) }}
                        </h3>
                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <span>Updated {{ $page->updated_at->diffForHumans() }}</span>
                        </div>
                    </a>
                @empty
                    <div class="p-4 text-center">
                        <p class="text-gray-500">No pages in this workspace yet</p>
                        <a href="{{ route('pages.create', ['workspace_id' => $workspace->id]) }}" class="mt-2 inline-block text-indigo-600 hover:text-indigo-800 text-sm">Create your first page</a>
                    </div>
                @endforelse
            </div>
            
            @if($pages->hasPages())
                <div class="px-4 py-3 border-t border-gray-200">
                    {{ $pages->links() }}
                </div>
            @endif
        </div>

        <!-- Notes in this workspace -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-5 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-medium flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                    Notes
                </h2>
                <a href="{{ route('notes.create', ['workspace_id' => $workspace->id]) }}" class="text-sm text-indigo-600 hover:text-indigo-800 transition flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    New Note
                </a>
            </div>
            
            <div class="divide-y divide-gray-100">
                @forelse($notes as $note)
                    <a href="{{ route('notes.show', $note) }}" class="block p-4 hover:bg-gray-50 transition">
                        <h3 class="text-sm font-medium mb-1 flex items-center">
                            <span class="page-icon mr-2">{{ $note->icon ?? '📝' }}</span>
                            {{ Str::limit($note->title, 40) }}
                        </h3>
                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <span>Updated {{ $note->updated_at->diffForHumans() }}</span>
                        </div>
                    </a>
                @empty
                    <div class="p-4 text-center">
                        <p class="text-gray-500">No notes in this workspace yet</p>
                        <a href="{{ route('notes.create', ['workspace_id' => $workspace->id]) }}" class="mt-2 inline-block text-indigo-600 hover:text-indigo-800 text-sm">Create your first note</a>
                    </div>
                @endforelse
            </div>
            
            @if($notes->hasPages())
                <div class="px-4 py-3 border-t border-gray-200">
                    {{ $notes->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection