<div class="space-y-1 px-1.5 py-2">
    <a href="{{ route('dashboard') }}" class="flex items-center px-2 py-1 text-sm text-notion rounded-md group notion-hover transition-all {{ request()->routeIs('dashboard') ? 'bg-gray-100' : '' }}">
        <span class="page-icon mr-2">🏡</span>
        Dashboard
    </a>
    
    <!-- Pages Dropdown -->
    <div class="page-dropdown">
        <button id="pagesDropdownBtn" class="flex items-center justify-between w-full px-2 py-1 text-sm text-notion rounded-md group notion-hover transition-all">
            <span class="flex items-center">
                <span class="page-icon mr-2">📚</span>
                Pages
            </span>
            <svg id="pagesDropdownIcon" class="w-3.5 h-3.5 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div id="pagesDropdownContent" class="ml-6 mt-1 space-y-1 hidden">
            <a href="{{ route('pages.index') }}" class="flex items-center px-2 py-1 text-sm text-notion rounded-md group notion-hover transition-all {{ request()->routeIs('pages.index') ? 'bg-gray-100' : '' }}">
                <span class="page-icon mr-2">📋</span>
                All 
            </a>
            @if(isset($recentPages) && count($recentPages) > 0)
                @foreach($recentPages as $recentPage)
                    <a href="{{ route('pages.show', $recentPage) }}" class="flex items-center px-2 py-1 text-sm text-notion rounded-md group notion-hover transition-all truncate">
                        <span class="page-icon mr-2">{{ $recentPage->icon ?? '📄' }}</span>
                        {{ Str::limit($recentPage->title, 25) }}
                    </a>
                @endforeach
            @endif
        </div>
    </div>
    
    <!-- Notes Dropdown -->
    <div class="page-dropdown">
        <button id="notesDropdownBtn" class="flex items-center justify-between w-full px-2 py-1 text-sm text-notion rounded-md group notion-hover transition-all">
            <span class="flex items-center">
                <span class="page-icon mr-2">📝</span>
                Notes
            </span>
            <svg id="notesDropdownIcon" class="w-3.5 h-3.5 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div id="notesDropdownContent" class="ml-6 mt-1 space-y-1 hidden">
            <a href="{{ route('notes.index') }}" class="flex items-center px-2 py-1 text-sm text-notion rounded-md group notion-hover transition-all {{ request()->routeIs('notes.index') ? 'bg-gray-100' : '' }}">
                <span class="page-icon mr-2">📋</span>
                All 
            </a>
            @if(isset($recentNotes) && count($recentNotes) > 0)
                @foreach($recentNotes as $recentNote)
                    <a href="{{ route('notes.show', $recentNote) }}" class="flex items-center px-2 py-1 text-sm text-notion rounded-md group notion-hover transition-all truncate">
                        <span class="page-icon mr-2">{{ $recentNote->icon ?? '📝' }}</span>
                        {{ Str::limit($recentNote->title, 25) }}
                    </a>
                @endforeach
            @endif
        </div>
    </div>
    
</div>

<!-- Workspaces Section -->
<div class="mt-6 px-1.5">
    <div class="flex items-center justify-between text-xs text-notion mb-2 px-2">
        <div class="flex items-center">
            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            WORKSPACES
        </div>
        <a href="{{ route('workspaces.create') }}" class="text-notion hover:text-gray-800 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
        </a>
    </div>
    <a href="{{ route('workspaces.index') }}" class="flex items-center px-2 py-1 text-sm text-notion rounded-md group notion-hover transition-all {{ request()->routeIs('notes.index') ? 'bg-gray-100' : '' }}">
                <span class="page-icon mr-2">📋</span>
                All 
            </a>
    <div class="space-y-1">
        @forelse($workspaces ?? [] as $workspace)
            <a href="{{ route('workspaces.switch', $workspace) }}" 
               class="flex items-center px-2 py-1 text-sm text-notion rounded-md notion-hover transition-all {{ isset($activeWorkspace) && $activeWorkspace->id === $workspace->id ? 'bg-gray-100' : '' }}">
                <span class="page-icon mr-2">{{ $workspace->icon ?? '👤' }}</span>
                {{ $workspace->name }}
                @if($workspace->is_default)
                    <span class="ml-1 text-xs text-gray-400">(default)</span>
                @endif
            </a>
        @empty
            <a href="{{ route('workspaces.create') }}" class="flex items-center px-2 py-1 text-sm text-notion rounded-md notion-hover transition-all">
                <span class="page-icon mr-2">➕</span>
                Create workspace
            </a>
        @endforelse
    </div>
</div>

<!-- Quick Create -->
<div class="mt-6 px-1.5">
    <div class="flex items-center text-xs text-notion mb-2 px-2">
        CREATE NEW
    </div>
    <div class="flex space-x-1">
        <a href="{{ route('notes.create') }}" class="flex-1 flex items-center justify-center px-2 py-1.5 text-sm text-notion bg-gray-100 hover:bg-gray-200 rounded-md transition-all">
            <span class="page-icon mr-1">📝</span>
            Note
        </a>
        <a href="{{ route('pages.create') }}" class="flex-1 flex items-center justify-center px-2 py-1.5 text-sm text-notion bg-gray-100 hover:bg-gray-200 rounded-md transition-all">
            <span class="page-icon mr-1">📄</span>
            Page
        </a>
    </div>
</div>