@extends('layouts.dashboard')

@section('title', 'Workspaces - ThinkDeck')



@section('dashboard-content')


    {{-- Page Header --}}
    <div class="flex justify-between items-center mb-6 mt-7">
        <h1 class="text-2xl font-semibold text-gray-900">Workspaces</h1>
        <a href="{{ route('workspaces.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-all flex items-center text-sm font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New Workspace
        </a>
    </div>

    {{-- Flash Messages Partial --}}
    <!-- @include('partials.flash-messages') -->

    {{-- Workspaces List Card --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-5 border-b border-gray-200">
            <h2 class="text-lg font-medium flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                Your workspaces
            </h2>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($workspaces as $workspace)
                <div class="p-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                    {{-- Workspace Info --}}
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">{{ $workspace->icon ?? '🏢' }}</span>
                        <div>
                           <a href="{{ route('workspaces.show', $workspace) }}" class="block">
                               <h3 class="font-medium text-gray-800 hover:text-indigo-600 transition-colors">{{ $workspace->name }}</h3>
                           </a>
                            <p class="text-sm text-gray-500">
                                {{ $workspace->pages?->count() ?? 0 }} pages
                                @if($workspace->is_default)
                                    <span class="ml-2 px-1.5 py-0.5 bg-gray-100 text-gray-700 text-xs rounded font-medium">Default</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- Workspace Actions --}}
                    <div class="flex space-x-2">
                        {{-- Switch Workspace --}}
                        @if(session('active_workspace_id') != $workspace->id)
                            <a href="{{ route('workspaces.switch', $workspace) }}" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 rounded text-sm transition-all flex items-center text-gray-700" title="Switch to this workspace">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l"></path>
                                </svg>
                                Switch
                            </a>
                        @else
                            <span class="px-3 py-1.5 bg-indigo-100 text-indigo-700 rounded text-sm flex items-center font-medium" title="Current active workspace">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Active
                            </span>
                        @endif

                        {{-- Owner Actions --}}
                        @if ($workspace->owner_id == auth()->user()->id)
                            <a href="{{ route('workspaces.users', $workspace) }}" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 rounded text-sm transition-all flex items-center text-gray-700" title="Manage users">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Users
                            </a>
                            <a href="{{ route('workspaces.edit', $workspace) }}" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 rounded text-sm transition-all text-gray-700" title="Edit workspace">Edit</a>
                            <form action="{{ route('workspaces.destroy', $workspace) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this workspace? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded text-sm transition-all" title="Delete workspace">Delete</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                {{-- Empty State --}}
                <div class="p-8 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <p class="text-gray-500 mb-4">You don't have any workspaces yet.</p>
                    <a href="{{ route('workspaces.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-all text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create your first workspace
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection
