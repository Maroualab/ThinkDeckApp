@extends('layouts.dashboard')

@section('title', 'Workspaces - ThinkDeck')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <div class="flex items-center text-sm text-gray-500 mb-6">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition">Dashboard</a>
        <svg class="w-3 h-3 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="text-gray-700">Workspaces</span>
    </div>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Workspaces</h1>
        <a href="{{ route('workspaces.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-all flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New Workspace
        </a>
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
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">{{ $workspace->icon }}</span>
                        <div>
                           <a href="{{ route('workspaces.show',$workspace) }}"> <h3 class="font-medium">{{ $workspace->name }}</h3></a>
                            <p class="text-sm text-gray-500">
                                {{ $workspace->pages?->count() }} pages
                                @if($workspace->is_default) 
                                    <span class="ml-2 px-1.5 py-0.5 bg-gray-100 text-gray-700 text-xs rounded">Default</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('workspaces.switch', $workspace) }}" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 rounded text-sm transition-all flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l"></path>
                            </svg>
                            Switch
                        </a>
                        @if ($workspace->owner_id==auth()->user()->id)
                        <a href="{{ route('workspaces.users', $workspace) }}" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 rounded text-sm transition-all flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            Users
                        </a>
                      <a href="{{ route('workspaces.edit', $workspace) }}" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded text-sm transition-all">Edit</a>
                        <form action="{{ route('workspaces.destroy', $workspace) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this workspace?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-50 hover:bg-red-100 text-red-600 rounded text-sm transition-all">Delete</button>
                        </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <p class="text-gray-500 mb-4">You don't have any workspaces yet.</p>
                    <a href="{{ route('workspaces.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-all">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create your first workspace
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection