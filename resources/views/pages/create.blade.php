@extends('layouts.dashboard')

@section('title', 'New Page - ThinkDeck')

@section('topnav-title')
    <h1 class="text-lg font-medium">Create New Page</h1>
@endsection

@section('dashboard-content')
    <div class="flex items-center justify-between mt-8">
        <h1 class="text-2xl font-bold">Create New Page</h1>
        <a href="{{ route('pages.index') }}"
           class="flex items-center text-indigo-600 hover:text-indigo-800">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Pages
        </a>
    </div>

    @include('partials.flash-messages')

    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <form action="{{ route('pages.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <div class="flex items-center">
                    <div class="mr-2">
                        <button type="button" id="iconSelector"
                                class="text-2xl border border-gray-200 rounded p-1 hover:bg-gray-50">
                            📄
                        </button>
                        <input type="hidden" name="icon" id="selectedIcon" value="📄">
                    </div>
                    <div class="flex-1">
                        <input type="text" name="title" id="title" placeholder="Page title"
                               class="w-full border-0 border-b border-transparent text-2xl font-bold focus:ring-0 focus:border-gray-300"
                               value="{{ old('title') }}" required autofocus>
                        @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1 sr-only">Content</label>
                <textarea name="content" id="content" rows="12"
                          class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-4"
                          placeholder="Start writing...">{{ old('content') }}</textarea>
                @error('content')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('pages.index') }}"
                   class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded text-sm font-medium transition-all">
                    Cancel
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded text-sm font-medium transition-all">
                    Create Page
                </button>
            </div>
        </form>
    </div>
@endsection

