@extends('layouts.dashboard')

@section('title', $workspace->name . ' - ThinkDeck')

@section('topnav-title')
    {{-- Optionally add a title specific to the top navigation for this page --}}
    <h1 class="text-lg font-medium truncate max-w-sm" title="{{ $workspace->name }}">
        {{ $workspace->icon }} {{ $workspace->name }}
    </h1>
@endsection

@section('dashboard-content')

    {{-- Breadcrumbs Partial --}}
    @include('partials.breadcrumbs', [
        'breadcrumbs' => [
            ['url' => route('workspaces.index'), 'name' => 'Workspaces'],
            ['name' => $workspace->name] 
        ]
    ])

    {{-- Flash Messages Partial --}}
    <!-- @include('partials.flash-messages') -->

    <!-- Workspace Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start"> {{-- Changed items-center to items-start --}}
            {{-- Left Side: Info --}}
            <div class="flex items-center mb-4 lg:mb-0">
                <span class="text-3xl mr-3">{{ $workspace->icon ?? '🏢' }}</span>
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">{{ $workspace->name }}</h1>
                    @if($workspace->description)
                        <p class="text-gray-500 mt-1">{{ $workspace->description }}</p>
                    @endif
                    <div class="mt-1 flex items-center text-sm">
                        @if($workspace->is_default)
                            <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-xs rounded-full mr-2 font-medium">Default Workspace</span>
                        @endif
                        <span class="text-gray-500">Created {{ $workspace->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
            {{-- Right Side: Actions --}}
            <div class="flex flex-wrap gap-2 justify-start lg:justify-end"> {{-- Added justify-start/end --}}
                {{-- Switch Button --}}
               
                {{-- Owner Actions --}}
                @if ($workspace->owner_id == auth()->user()->id)
                    <a href="{{ route('workspaces.users', $workspace) }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all flex items-center" title="Manage users">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Users
                    </a>
                    <a href="{{ route('workspaces.edit', $workspace) }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all flex items-center" title="Edit workspace">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('workspaces.destroy', $workspace) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this workspace? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 border border-red-300 rounded-md text-sm font-medium text-red-700 bg-white hover:bg-red-50 transition-all flex items-center" title="Delete workspace">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete
                        </button>
                    </form>
                @endif
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
                <a href="{{ route('pages.create', ['workspace_id' => $workspace->id]) }}" class="text-sm text-indigo-600 hover:text-indigo-800 transition flex items-center font-medium"> {{-- Added font-medium --}}
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    New Page
                </a>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse($pages as $page)
                    <a href="{{ route('pages.show', $page) }}" class="block p-4 hover:bg-gray-50 transition">
                        <h3 class="text-sm font-medium mb-1 flex items-center text-gray-800"> {{-- Added text-gray-800 --}}
                            <span class="page-icon mr-2">{{ $page->icon ?? '📄' }}</span>
                            {{ Str::limit($page->title, 40) }}
                        </h3>
                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <span>Updated {{ $page->updated_at->diffForHumans() }}</span>
                            {{-- Add other info like author if needed --}}
                        </div>
                    </a>
                @empty
                    <div class="p-6 text-center"> {{-- Increased padding --}}
                        <svg class="w-10 h-10 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-gray-500 mb-3">No pages in this workspace yet.</p>
                        <a href="{{ route('pages.create', ['workspace_id' => $workspace->id]) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                             <svg class="w-4 h-4 mr-1 -ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Create your first page
                        </a>
                    </div>
                @endforelse
            </div>

            @if($pages->hasPages())
                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200"> {{-- Added bg-gray-50 --}}
                    {{ $pages->links() }}
                </div>
            @endif
        </div>

        {{-- Add other content sections like Notes, Users, Settings etc. here --}}
        {{-- Example: Notes Section (similar structure to Pages) --}}
        {{--
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
             <div class="p-5 border-b border-gray-200 flex justify-between items-center">
                 <h2 class="text-lg font-medium flex items-center">
                     <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                     </svg>
                     Notes
                 </h2>
                 <a href="{{ route('notes.create', ['workspace_id' => $workspace->id]) }}" class="text-sm text-yellow-600 hover:text-yellow-800 transition flex items-center font-medium">
                     <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                     </svg>
                     New Note
                 </a>
             </div>
             <div class="divide-y divide-gray-100">
                 {{-- @forelse($notes as $note) ... @empty ... @endforelse --}}
             </div>
             {{-- @if($notes->hasPages()) ... @endif --}}
        </div>
        --}}

    </div> {{-- End Grid --}}
@endsection