@extends('layouts.dashboard')

@section('title', 'Edit ' . $page->title . ' - ThinkDeck')

@section('topnav-title')
    {{-- Keep this minimal, maybe just the resource type --}}
    <h1 class="text-lg font-medium text-gray-700">Edit Page</h1>
@endsection

{{-- Add Summernote Lite CSS --}}
@section('additional-styles')
    @parent
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    {{-- Add styles for the icon picker popup if not already global --}}
    <style>
        #iconPickerPopup { /* Ensure popup is visible */ }
        #iconPickerPopup .grid { /* Style grid */ }
    </style>
@endsection

@section('dashboard-content')

    {{-- Breadcrumbs & Actions Header --}}
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
        {{-- Breadcrumbs Partial --}}
        @include('partials.breadcrumbs', [
            'breadcrumbs' => [
                ['url' => route('pages.index'), 'name' => 'Pages'], // Link back to pages index
                ['url' => route('pages.show', $page), 'name' => $page->title], // Link to the page being edited
                ['name' => 'Edit'] // Current action
            ]
        ])

        {{-- Link back to View Page --}}
        <a href="{{ route('pages.show', $page) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 rounded-md text-sm font-medium transition-colors duration-150" title="View page">
            <svg class="w-4 h-4 mr-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            View Page
        </a>
    </div>


    {{-- Form Card --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <form action="{{ route('pages.update', $page) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Card Header (Optional - for title consistency) --}}
            <div class="p-5 border-b border-gray-200 bg-gray-50/50">
                <h2 class="text-lg font-medium flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Editing Page
                </h2>
            </div>

            {{-- Form Body --}}
            <div class="p-6 space-y-6">

                {{-- Icon Picker & Title Row --}}
                <div class="flex items-start space-x-4">
                    {{-- Icon Display/Input --}}
                    <div class="relative group">
                         <label class="block text-xs font-medium text-gray-500 mb-1 text-center">Icon</label>
                         {{-- Button triggers the JS popup --}}
                         <button type="button" id="iconSelector"
                               class="w-16 h-16 border border-gray-300 rounded-md shadow-sm text-center text-3xl p-2 cursor-pointer hover:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                               {{ old('icon', $page->icon ?? '📄') }}
                         </button>
                         <input type="hidden" name="icon" id="selectedIcon" value="{{ old('icon', $page->icon ?? '📄') }}">
                         <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block px-2 py-1 bg-gray-700 text-white text-xs rounded">Click to change</span>
                         @error('icon')
                            <p class="mt-1 text-xs text-red-600 text-center">{{ $message }}</p>
                         @enderror
                    </div>

                    {{-- Title Input --}}
                    <div class="flex-1">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" id="title" placeholder="Untitled Page"
                               class="w-full border-gray-300 rounded-md shadow-sm text-xl font-semibold focus:ring-indigo-500 focus:border-indigo-500"
                               value="{{ old('title', $page->title) }}" required autofocus>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Content Editor --}}
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1 sr-only">Content</label>
                    {{-- Textarea for Summernote --}}
                    <textarea name="content" id="content">{{ old('content', $page->content) }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                 {{-- Workspace Selection (Optional - Uncomment if needed) --}}
                {{-- @if(isset($workspaces) && $workspaces->count() > 0)
                    <div>
                        <label for="workspace_id" class="block text-sm font-medium text-gray-700 mb-1">Workspace</label>
                        <select name="workspace_id" id="workspace_id" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">None (Personal Page)</option>
                            @foreach($workspaces as $ws)
                                <option value="{{ $ws->id }}" {{ old('workspace_id', $page->workspace_id) == $ws->id ? 'selected' : '' }}>
                                    {{ $ws->icon }} {{ $ws->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('workspace_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endif --}}

            </div>

            {{-- Form Actions Footer --}}
            <div class="px-6 py-4 bg-gray-50 text-right space-x-3 border-t border-gray-200">
                <a href="{{ route('pages.show', $page) }}"
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </a>
                <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

@endsection

{{-- Add Scripts using @section --}}
@section('scripts')
    @parent {{-- Include parent layout's scripts (like sidebar JS) --}}

    {{-- Load Summernote Lite JS (jQuery should be loaded globally in app.blade.php) --}}
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    {{-- Summernote Initialization Script --}}
    <script>
        $(document).ready(function() {
            if ($('#content').length) {
                $('#content').summernote({
                    placeholder: 'Start writing...',
                    tabsize: 2,
                    height: 350, // Adjusted height
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'italic', 'clear']],
                        // ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ],
                });
            } else {
                console.error("Summernote target element '#content' not found.");
            }
        });
    </script>

    {{-- Icon Picker JavaScript (Keep the existing JS from the previous version) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const iconSelector = document.getElementById('iconSelector'); // The button showing the icon
            const selectedIcon = document.getElementById('selectedIcon'); // The hidden input

            // Common page icons (Keep the extensive list)
            const icons = ['📄', '📝', '📌', /* ... many more icons ... */ '🥄'];

            // Create the icon picker popup (Keep the popup creation logic)
            const popup = document.createElement('div');
            popup.className = 'fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50 hidden p-4'; // Added padding
            popup.id = 'iconPickerPopup';

            const popupContent = document.createElement('div');
            popupContent.className = 'bg-white rounded-lg shadow-xl w-full max-w-md'; // Adjusted max-width

            const popupHeader = document.createElement('div');
            popupHeader.className = 'flex justify-between items-center p-4 border-b border-gray-200'; // Adjusted padding
            popupHeader.innerHTML = `
                <h3 class="text-lg font-medium text-gray-800">Select an Icon</h3>
                <button id="closeIconPicker" type="button" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;

            const searchInput = document.createElement('input');
            searchInput.type = 'text';
            searchInput.placeholder = 'Search icons...';
            searchInput.className = 'w-full px-3 py-2 border-b border-gray-200 focus:outline-none focus:ring-0 focus:border-indigo-500 text-sm'; // Simplified search style

            const iconGrid = document.createElement('div');
            iconGrid.className = 'grid grid-cols-8 gap-1 p-4 overflow-y-auto max-h-60'; // Adjusted padding/gap/height

            icons.forEach(icon => {
                const iconButton = document.createElement('button');
                iconButton.type = 'button';
                iconButton.className = 'text-2xl p-2 hover:bg-indigo-50 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-300 transition-colors'; // Added focus styles
                iconButton.textContent = icon;
                iconButton.addEventListener('click', () => {
                    selectedIcon.value = icon;
                    iconSelector.textContent = icon;
                    popup.classList.add('hidden');
                });
                iconGrid.appendChild(iconButton);
            });

            popupContent.appendChild(popupHeader);
            popupContent.appendChild(searchInput);
            popupContent.appendChild(iconGrid);
            popup.appendChild(popupContent);
            document.body.appendChild(popup);

            // Icon selector click event (Keep)
            iconSelector.addEventListener('click', function() {
                popup.classList.remove('hidden');
                searchInput.focus(); // Focus search on open
            });

            // Close button click event (Keep)
            document.getElementById('closeIconPicker').addEventListener('click', function() {
                popup.classList.add('hidden');
            });

            // Close when clicking outside (Keep)
            popup.addEventListener('click', function(e) {
                if (e.target === popup) {
                    popup.classList.add('hidden');
                }
            });

            // Search functionality (Keep)
            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                const iconButtons = iconGrid.querySelectorAll('button');

                iconButtons.forEach(button => {
                    // Basic search - check if icon contains query
                    if (button.textContent.includes(query)) {
                        button.style.display = '';
                    } else {
                        button.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection