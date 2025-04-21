@extends('layouts.dashboard')

@section('title', 'New Page - ThinkDeck')

@section('topnav-title')
<h1 class="text-lg font-medium">Create New Page</h1>
@endsection

@section('dashboard-content')
    @include('partials.breadcrumbs', [
        'resourceType' => 'pages',
        'current' => 'New Page'
    ])
    
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <form action="{{ route('pages.store') }}" method="POST">
            @csrf

            <!-- Parent Page Selector -->
            <div class="mb-6">
                <div class="flex items-center">
                    <div class="relative inline-block">
                        <button type="button" id="parentPageButton" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 text-sm font-medium">
                            @if(isset($parent))
                                <span class="page-icon">{{ $parent->icon ?? '📄' }}</span>
                                <span>{{ $parent->title }}</span>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <span>Add to page</span>
                            @endif
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <input type="hidden" name="parent_id" id="parentPageId" value="{{ $parent->id ?? '' }}">
                        
                        <!-- Dropdown content -->
                        <div id="parentPageDropdown" class="hidden absolute z-10 mt-2 w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div class="p-2">
                                <div class="mb-2">
                                    <input type="text" id="searchPages" placeholder="Search pages..." 
                                        class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2 text-sm">
                                </div>
                                <div class="max-h-60 overflow-y-auto py-1" id="pagesDropdownContent">
                                    <!-- No parent option -->
                                    <div class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer" data-id="" data-icon="" data-title="No parent (top-level page)">
                                        No parent (top-level page)
                                    </div>
                                    
                                    <!-- Available pages -->
                                    @foreach(Auth::user()->pages()->active()->orderBy('title')->get() as $availablePage)
                                        <div class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer flex items-center space-x-2" 
                                             data-id="{{ $availablePage->id }}" 
                                             data-icon="{{ $availablePage->icon }}" 
                                             data-title="{{ $availablePage->title }}">
                                            <span>{{ $availablePage->icon }}</span>
                                            <span>{{ $availablePage->title }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <div class="flex items-center">
                    <div class="mr-2">
                        <button type="button" id="iconSelector" class="text-2xl border border-gray-200 rounded p-1 hover:bg-gray-50">
                            📄
                        </button>
                        <input type="hidden" name="icon" id="selectedIcon" value="📄">
                    </div>
                    <div class="flex-1">
                        <input type="text" name="title" id="title" placeholder="Page title" 
                               class="w-full border-0 border-b border-transparent text-2xl font-bold focus:ring-0 focus:border-gray-300" 
                               value="{{ old('title') }}" required autofocus>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1 sr-only">Content</label>
                <textarea name="content" id="content" rows="12" 
                    class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-4"
                    placeholder="Start writing...">{{ old('content') }}</textarea>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('pages.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded text-sm font-medium transition-all">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded text-sm font-medium transition-all">
                    Create Page
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Icon selector script (existing)
        const iconSelector = document.getElementById('iconSelector');
        const selectedIcon = document.getElementById('selectedIcon');
        
        // Common page icons
        const icons = ['📄', '📝', '📌', '📎', '📊', '📈', '📉', '📑', '📋', '📃', '📜', '📚', '📔', '📕', '📖', '📗', '📘', '📙', '🗒️', '🗓️', '📆', '📅', '🗃️', '🗄️', '🗂️', '📁', '📂', '🗞️', '📰', '🏷️', '📮', '📭', '✅', '☑️', '✔️', '⚠️', '💡', '❓', '❗', '📣', '🔈', '📢', '🔔', '🔖', '💯', '💰', '💴', '💵', '💶', '💷', '📧', '✉️', '📨', '📩', '📤', '📥', '📦', '📪', '📫', '📬', '🏠', '🏡', '🏢', '🏣', '🏤', '🏥', '🏦', '🏨', '🏩', '🏪', '🏫', '🏬', '🏭', '🏯', '🏰', '💻', '🖥️', '🖨️', '⌨️', '🖱️', '🔋', '🔌', '💾', '💿', '📀', '🎮', '📱', '☎️', '📞', '📟', '📠', '🏁', '🚩', '🎯', '🎪', '🎭', '🎨', '🎬', '🎤', '🎧', '🎼', '🎹', '🥁', '🎷', '🎺', '🎸', '🎻', '🎲', '🎯', '🎳', '🎮', '🎰', '🛒', '🎁', '🎈', '🎉', '🎊', '🎂', '🎀', '🎏', '🎇', '🌈', '❤️', '💜', '💙', '💚', '💛', '🧡', '❣️', '💕', '💞', '💓', '💗', '💖', '💘', '💝', '🔥', '⭐', '🌟', '✨', '⚡', '🌍', '🌎', '🌏', '🌑', '🌒', '🌗', '🌖', '🌕', '🌝', '🌛', '🌜', '🌞', '⛅', '⚡', '🌈', '🌂', '☔', '⛄', '❄️', '🔥', '💧', '🌊'];
        
        // Create the icon picker popup
        iconSelector.addEventListener('click', function() {
            // Show popup with icons, omitted for brevity
        });

        // Parent page dropdown functionality
        const parentPageButton = document.getElementById('parentPageButton');
        const parentPageDropdown = document.getElementById('parentPageDropdown');
        const parentPageId = document.getElementById('parentPageId');
        const searchPages = document.getElementById('searchPages');
        const pageOptions = document.querySelectorAll('#pagesDropdownContent div');

        // Toggle dropdown visibility
        parentPageButton.addEventListener('click', function() {
            parentPageDropdown.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!parentPageButton.contains(event.target) && !parentPageDropdown.contains(event.target)) {
                parentPageDropdown.classList.add('hidden');
            }
        });

        // Search functionality
        searchPages.addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            
            pageOptions.forEach(option => {
                const title = option.getAttribute('data-title').toLowerCase();
                if (title.includes(searchValue)) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            });
        });

        // Select parent page
        pageOptions.forEach(option => {
            option.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const icon = this.getAttribute('data-icon');
                const title = this.getAttribute('data-title');
                
                parentPageId.value = id;
                
                // Update button text
                if (id) {
                    parentPageButton.innerHTML = `
                        <span>${icon}</span>
                        <span>${title}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    `;
                } else {
                    parentPageButton.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>Add to page</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    `;
                }
                
                // Hide dropdown
                parentPageDropdown.classList.add('hidden');
            });
        });
    });
</script>
@endpush