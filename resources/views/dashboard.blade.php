<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ThinkDeck</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }
        .notion-sidebar {
            width: 260px;
            transition: all 0.2s;
        }
        .notion-hover:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .ml-sidebar {
            margin-left: 260px;
        }
        .text-notion {
            color: rgba(55, 53, 47, 0.65);
        }
        .text-notion-dark {
            color: rgba(55, 53, 47, 0.9);
        }
        .page-icon {
            opacity: 0.8;
            font-size: 1.1rem;
        }
        .card-hover {
            transition: all 0.2s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen flex overflow-hidden">
    <!-- Sidebar -->
    <aside class="notion-sidebar bg-white border-r border-gray-200 min-h-screen flex flex-col transition-all duration-300 fixed h-full z-20" id="sidebar">
        <!-- Sidebar content remains the same -->
        <div class="p-4 flex items-center justify-between border-b border-gray-200">
            <a href="{{ route('welcome') }}" class="text-base font-medium text-notion-dark flex items-center hover:text-gray-900">
                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400 mr-1.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                ThinkDeck
            </a>
            <button class="text-gray-500 hover:text-gray-700 focus:outline-none" id="toggleSidebar">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
        </div>
        
        <!-- Rest of sidebar content remains the same -->
        <!-- ... -->
    </aside>

    <div class="flex-1 transition-all duration-300 flex flex-col" id="main-content">
        <!-- Top navigation -->
        <header class="h-12 border-b border-gray-200 flex items-center px-4 bg-white fixed w-full z-10">
            <button id="sidebarToggle" class="mr-3 text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            
            <div class="flex-1"></div>
            
            <div class="flex items-center relative">
                <button id="profileButton" class="flex items-center space-x-2 rounded p-1 hover:bg-gray-100 focus:outline-none transition-all">
                    <div class="h-6 w-6 rounded-full bg-indigo-600 flex items-center justify-center text-xs text-white">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </button>
                
                <div id="profileMenu" class="absolute right-0 top-full mt-1 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden border border-gray-200">
                    <a href="{{ route('welcome') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">Homepage</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">Profile Settings</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>
        
        <!-- Main content -->
        <main class="pt-16 pb-6 px-4 sm:px-6 md:px-8 lg:px-10 overflow-y-auto h-screen">
            <div class="w-full max-w-5xl mx-auto">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl shadow-md text-white p-8 mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}</h1>
                            <p class="text-indigo-100 mb-4">Your workspace for ideas and productivity</p>
                            <div class="flex space-x-3">
                                <a href="{{ route('notes.create') }}" class="px-4 py-2 bg-white text-indigo-700 rounded-md font-medium hover:bg-indigo-50 transition-all flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    New Note
                                </a>
                                <a href="{{ route('pages.create') }}" class="px-4 py-2 bg-indigo-700 text-white border border-indigo-300 rounded-md font-medium hover:bg-indigo-800 transition-all flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    New Page
                                </a>
                            </div>
                        </div>
                        <div class="hidden md:block">
                            <svg class="w-32 h-32 text-indigo-300 opacity-80" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 card-hover">
                        <h3 class="text-sm text-gray-500 mb-1">Total Notes</h3>
                        <p class="text-2xl font-semibold">{{ rand(5, 20) }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 card-hover">
                        <h3 class="text-sm text-gray-500 mb-1">Total Pages</h3>
                        <p class="text-2xl font-semibold">{{ rand(3, 15) }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 card-hover">
                        <h3 class="text-sm text-gray-500 mb-1">Tasks Completed</h3>
                        <p class="text-2xl font-semibold">{{ rand(0, 10) }}/{{ rand(10, 20) }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 card-hover">
                        <h3 class="text-sm text-gray-500 mb-1">Workspaces</h3>
                        <p class="text-2xl font-semibold">2</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left column -->
                    <div class="space-y-6">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-5 border-b border-gray-200 flex justify-between items-center">
                                <h2 class="text-lg font-medium flex items-center">
                                    <span class="text-xl mr-2">📝</span>
                                    Recent Notes
                                </h2>
                                <a href="{{ route('notes.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">View all</a>
                            </div>
                            <div class="divide-y divide-gray-100">
                                @for ($i = 0; $i < 3; $i++)
                                <a href="#" class="block p-4 hover:bg-gray-50 transition">
                                    <h3 class="text-sm font-medium mb-1">Example Note Title {{ $i + 1 }}</h3>
                                    <div class="flex justify-between items-center text-xs text-gray-500">
                                        <span>Updated {{ rand(1, 7) }} days ago</span>
                                        <span class="px-2 py-1 bg-gray-100 rounded">Notes</span>
                                    </div>
                                </a>
                                @endfor
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
                            <h2 class="text-lg font-medium flex items-center mb-4">
                                <span class="text-xl mr-2">📥</span>
                                Import Content
                            </h2>
                            <p class="text-sm text-gray-600 mb-3">Import your documents from various formats</p>
                            <form id="importForm" action="{{ route('documents.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="flex">
                                    <label for="fileImport" class="flex-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-md text-sm font-medium transition-all text-center cursor-pointer border border-gray-200">
                                        Choose File
                                    </label>
                                    <input type="file" id="fileImport" name="document" accept=".doc,.docx,.pdf,.txt,.md" class="hidden" onchange="submitImport()">
                                </div>
                                <div class="mt-3 text-xs text-gray-500">
                                    Supported formats: Word, PDF, TXT, Markdown
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Right column -->
                    <div class="space-y-6">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-5 border-b border-gray-200 flex justify-between items-center">
                                <h2 class="text-lg font-medium flex items-center">
                                    <span class="text-xl mr-2">📚</span>
                                    Recent Pages
                                </h2>
                                <a href="{{ route('pages.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">View all</a>
                            </div>
                            <div class="divide-y divide-gray-100">
                                @for ($i = 0; $i < 3; $i++)
                                <a href="#" class="block p-4 hover:bg-gray-50 transition">
                                    <h3 class="text-sm font-medium mb-1">Project Documentation {{ $i + 1 }}</h3>
                                    <div class="flex justify-between items-center text-xs text-gray-500">
                                        <span>Updated {{ rand(1, 7) }} days ago</span>
                                        <span class="px-2 py-1 bg-gray-100 rounded">Pages</span>
                                    </div>
                                </a>
                                @endfor
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-5 border-b border-gray-200">
                                <h2 class="text-lg font-medium flex items-center">
                                    <span class="text-xl mr-2">✅</span>
                                    Tasks
                                </h2>
                            </div>
                            <div class="p-4">
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <span class="ml-2 text-sm">Update project documentation</span>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <span class="ml-2 text-sm">Write weekly report</span>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <span class="ml-2 text-sm">Prepare meeting agenda</span>
                                    </div>
                                </div>
                                <a href="#" class="block mt-4 text-center text-sm text-indigo-600 hover:text-indigo-800 py-2 border-t border-gray-100">
                                    View all tasks
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Same JavaScript as before
            const profileButton = document.getElementById('profileButton');
            const profileMenu = document.getElementById('profileMenu');
            const toggleSidebar = document.getElementById('toggleSidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');

            // Profile menu toggle
            profileButton.addEventListener('click', function () {
                profileMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', function (event) {
                if (!profileButton.contains(event.target) && !profileMenu.contains(event.target)) {
                    profileMenu.classList.add('hidden');
                }
            });
            
            // Sidebar toggle functionality
            function toggleSidebarVisibility() {
                sidebar.classList.toggle('translate-x-[-260px]');
                updateMainContentMargin();
            }

            function updateMainContentMargin() {
                if (!sidebar.classList.contains('translate-x-[-260px]')) {
                    mainContent.classList.add('ml-sidebar');
                } else {
                    mainContent.classList.remove('ml-sidebar');
                }
            }

            toggleSidebar.addEventListener('click', toggleSidebarVisibility);
            sidebarToggle.addEventListener('click', toggleSidebarVisibility);

            // Responsive behavior
            function checkScreenSize() {
                if (window.innerWidth < 768) {
                    sidebar.classList.add('translate-x-[-260px]');
                } else {
                    sidebar.classList.remove('translate-x-[-260px]');
                }
                updateMainContentMargin();
            }
            
            window.addEventListener('resize', checkScreenSize);
            checkScreenSize();

            // Dropdown toggles
            const pagesDropdownBtn = document.getElementById('pagesDropdownBtn');
            const pagesDropdownContent = document.getElementById('pagesDropdownContent');
            const pagesDropdownIcon = document.getElementById('pagesDropdownIcon');
            
            const notesDropdownBtn = document.getElementById('notesDropdownBtn');
            const notesDropdownContent = document.getElementById('notesDropdownContent');
            const notesDropdownIcon = document.getElementById('notesDropdownIcon');

            if (pagesDropdownBtn) {
                pagesDropdownBtn.addEventListener('click', function() {
                    pagesDropdownContent.classList.toggle('hidden');
                    pagesDropdownIcon.classList.toggle('rotate-180');
                });
            }

            if (notesDropdownBtn) {
                notesDropdownBtn.addEventListener('click', function() {
                    notesDropdownContent.classList.toggle('hidden');
                    notesDropdownIcon.classList.toggle('rotate-180');
                });
            }
        });

        function submitImport() {
            const fileInput = document.getElementById('fileImport');
            const fileName = fileInput.files[0]?.name;
            
            if (fileName) {
                document.getElementById('importForm').submit();
            }
        }
    </script>
</body>
</html>
