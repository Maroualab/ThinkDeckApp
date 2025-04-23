<aside
    class="notion-sidebar bg-[#fbfbfa] border-r border-gray-200 min-h-screen flex flex-col transition-all duration-300 fixed h-full z-20"
    id="sidebar">
    <div class="p-4 flex items-center justify-between border-b border-gray-200">
        <a href="{{ route('welcome') }}"
            class="text-base font-medium text-notion-dark flex items-center hover:text-gray-900">
            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400 mr-1.5" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
            ThinkDeck
        </a>
        <button class="text-gray-500 hover:text-gray-700 focus:outline-none" id="toggleSidebar">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
    </div>

    <div class="overflow-y-auto flex-1">
        <div class="py-2 px-2">
            <!-- Search -->
            <div class="px-2 mb-4">
                <div class="bg-gray-100 rounded flex items-center px-3 py-1.5 text-notion">
                    <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span class="text-sm">Search</span>
                </div>
            </div>

            <!-- Main Navigation -->
            @include('partials.sidebar-navigation')
        </div>
    </div>

    <!-- User Profile -->
    <div class="p-3 border-t border-gray-200 bg-gray-50">
        <div class="relative flex flex-col items-end">
            <!-- Profile Button -->
            <button id="profileMenuBtn" class="flex items-center space-x-2 w-full focus:outline-none">
                <div
                    class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center text-sm font-medium text-gray-700">
                    {{ Auth::check() ? substr(Auth::user()->name, 0, 1) : '?' }}
                </div>
                <span class="text-sm font-medium text-notion-dark flex-1 text-left">
                    {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                </span>
                <span id="profileMenuArrow" class="flex items-center cursor-pointer">
                    <svg class="w-4 h-4 text-gray-500 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </span>
            </button>

            <!-- Profile Dropdown -->
            <div id="profileMenuDropdown"
                style="top: -70px;" class="hidden absolute right-0 top-[-70px] w-48 bg-white border border-gray-200 rounded shadow-lg z-20 transition-all duration-200 ease-out">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Profile
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="border-t border-gray-200">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Logout
                    </button>
                </form>
            </div>

        </div>
    </div>
</aside>
<script>
    // Dropdown toggles
    const pagesDropdownBtn = document.getElementById('pagesDropdownBtn');
    const pagesDropdownContent = document.getElementById('pagesDropdownContent');
    const pagesDropdownIcon = document.getElementById('pagesDropdownIcon');

    const notesDropdownBtn = document.getElementById('notesDropdownBtn');
    const notesDropdownContent = document.getElementById('notesDropdownContent');
    const notesDropdownIcon = document.getElementById('notesDropdownIcon');

    pagesDropdownBtn?.addEventListener('click', function () {
        pagesDropdownContent.classList.toggle('hidden');
        pagesDropdownIcon.classList.toggle('rotate-180');
    });

    notesDropdownBtn?.addEventListener('click', function () {
        notesDropdownContent.classList.toggle('hidden');
        notesDropdownIcon.classList.toggle('rotate-180');
    });

    document.addEventListener('DOMContentLoaded', function () {
        const arrow = document.getElementById('profileMenuArrow');
        const dropdown = document.getElementById('profileMenuDropdown');
        const profileMenuBtn = document.getElementById('profileMenuBtn');

        // Toggle dropdown when the arrow is clicked
        profileMenuBtn?.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
            arrow.querySelector('svg').classList.toggle('rotate-180');
        });

        // Prevent dropdown from closing when clicked inside
        dropdown?.addEventListener('click', function (e) {
            e.stopPropagation();
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function () {
            dropdown.classList.add('hidden');
            arrow.querySelector('svg').classList.remove('rotate-180');
        });
    });
</script>