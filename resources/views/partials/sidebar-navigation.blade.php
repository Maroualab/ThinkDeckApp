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
                All Pages
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
                All Notes
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
    
    <!-- Future feature: Tasks -->
    <a href="#" class="flex items-center px-2 py-1 text-sm text-notion rounded-md group notion-hover transition-all">
        <span class="page-icon mr-2">✅</span>
        Tasks
    </a>
</div>

<!-- Workspaces Section -->
<div class="mt-6 px-1.5">
    <div class="flex items-center text-xs text-notion mb-2 px-2">
        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
        WORKSPACES
    </div>
    <div class="space-y-1">
        <a href="#" class="flex items-center px-2 py-1 text-sm text-notion rounded-md notion-hover transition-all">
            <span class="page-icon mr-2">👤</span>
            Personal
        </a>
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