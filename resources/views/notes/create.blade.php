@extends('layouts.dashboard')

@section('title', 'New Note - ThinkDeck')

@section('topnav-title')
<h1 class="text-lg font-medium">Create New Note</h1>
@endsection

@section('dashboard-content')
    @include('partials.breadcrumbs', [
        'resourceType' => 'notes',
        'current' => 'New Note'
    ])
    
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <form action="{{ route('notes.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <div class="flex items-center">
                    <div class="mr-2">
                        <button type="button" id="iconSelector" class="text-2xl border border-gray-200 rounded p-1 hover:bg-gray-50">
                            📝
                        </button>
                        <input type="hidden" name="icon" id="selectedIcon" value="📝">
                    </div>
                    <div class="flex-1">
                        <input type="text" name="title" id="title" placeholder="Note title" 
                               class="w-full border-0 border-b border-transparent text-2xl font-bold focus:ring-0 focus:border-gray-300" 
                               value="{{ old('title') }}" required autofocus>
                    </div>
                </div>
            </div>

            <!-- <div class="mb-4">
                <label for="workspace_id" class="block text-sm font-medium text-gray-700 mb-1">Workspace</label>
                <select name="workspace_id" id="workspace_id" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @foreach(Auth::user()->workspaces as $workspace)
                        <option value="{{ $workspace->id }}" {{ (session('active_workspace_id') == $workspace->id) ? 'selected' : '' }}>
                            {{ $workspace->icon }} {{ $workspace->name }}
                        </option>
                    @endforeach
                </select>
            </div> -->

            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1 sr-only">Content</label>
                <textarea name="content" id="content" rows="12" 
                    class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-4"
                    placeholder="Start writing...">{{ old('content') }}</textarea>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('notes.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded text-sm font-medium transition-all">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded text-sm font-medium transition-all">
                    Create Note
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const iconSelector = document.getElementById('iconSelector');
        const selectedIcon = document.getElementById('selectedIcon');
        
        // Common note icons
        const icons = ['📝', '📓', '📔', '📕', '📖', '📗', '📘', '📙', '📚', '📒', '🗒️', '🔖', '📑', '🗞️', '📰', '🏷️', '✏️', '✒️', '🖋️', '📌', '📍', '📎', '🖇️', '📐', '📏', '✂️', '💼', '💡', '🔍', '🔎', '🔦', '🧮', '🧾', '📬', '📭', '📮', '🗿', '🔔', '🔕', '📢', '📣', '🔊', '🔉', '🔇', '🔈', '📯', '🔄', '♻️', '🔃', '🕓', '⏱️', '⏲️', '⏰', '🕰️', '🗓️', '📅', '📆', '⌚', '📱', '💻', '⌨️', '💾', '📧', '📧', '📨', '📩', '📤', '📥', '📦', '🤔', '🧐', '🤦', '🤷', '🙋', '💭', '💬', '🗯️', '❓', '❔', '❗', '❕', '❣️', '💯', '💢', '🔥', '⭐', '🌟', '✨', '💫', '🚩', '🎯', '💘', '💝', '💖', '💗', '💓', '💞', '💕', '❤️', '🧡', '💛', '💚', '💙', '💜', '🤎', '🖤', '🤍'];
        
        // Create the icon picker popup
        const popup = document.createElement('div');
        popup.className = 'fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50 hidden';
        popup.id = 'iconPickerPopup';
        
        const popupContent = document.createElement('div');
        popupContent.className = 'bg-white rounded-lg shadow-lg w-full max-w-lg p-6';
        
        const popupHeader = document.createElement('div');
        popupHeader.className = 'flex justify-between items-center mb-4';
        popupHeader.innerHTML = `
            <h3 class="text-lg font-medium">Select an Icon</h3>
            <button id="closeIconPicker" class="text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;
        
        const searchInput = document.createElement('input');
        searchInput.type = 'text';
        searchInput.placeholder = 'Search icons...';
        searchInput.className = 'w-full px-3 py-2 border border-gray-300 rounded-md mb-4 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500';
        
        const iconGrid = document.createElement('div');
        iconGrid.className = 'grid grid-cols-8 gap-2 overflow-y-auto max-h-64';
        
        icons.forEach(icon => {
            const iconButton = document.createElement('button');
            iconButton.type = 'button';
            iconButton.className = 'text-2xl p-2 hover:bg-gray-100 rounded';
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
        
        // Icon selector click event
        iconSelector.addEventListener('click', function() {
            popup.classList.remove('hidden');
        });
        
        // Close button click event
        document.getElementById('closeIconPicker').addEventListener('click', function() {
            popup.classList.add('hidden');
        });
        
        // Close when clicking outside
        popup.addEventListener('click', function(e) {
            if (e.target === popup) {
                popup.classList.add('hidden');
            }
        });
        
        // Search functionality
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const iconButtons = iconGrid.querySelectorAll('button');
            
            iconButtons.forEach(button => {
                if (button.textContent.includes(query)) {
                    button.style.display = '';
                } else {
                    button.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush