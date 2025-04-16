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
    </style>
</head>
<body class="bg-white text-gray-900 min-h-screen flex overflow-hidden">
    <!-- Sidebar -->
    <aside class="notion-sidebar bg-[#fbfbfa] border-r border-gray-200 min-h-screen flex flex-col transition-all duration-300 fixed h-full z-20" id="sidebar">
        <div class="p-4 flex items-center justify-between border-b border-gray-200">
            <span class="text-base font-medium text-notion-dark">ThinkDeck</span>
            <button class="text-gray-500 hover:text-gray-700 focus:outline-none" id="toggleSidebar">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
        </div>
        
        <div class="overflow-y-auto flex-1">
            <div class="py-2 px-2">
                <!-- Search -->
                <div class="px-2 mb-2">
                    <div class="bg-gray-100 rounded flex items-center px-3 py-1.5 text-notion">
                        <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span class="text-sm">Search</span>
                    </div>
                </div>
                
                <!-- Quick links - Updated with routes -->
                <div class="space-y-1 px-1.5 py-2">
                    <a href="{{ route('notes.index') }}" class="flex items-center px-2 py-1 text-sm text-notion rounded-md group notion-hover transition-all">
                        <span class="page-icon mr-2">📝</span>
                        Notes
                    </a>
                    <a href="{{ route('dashboard') }}" class="flex items-center px-2 py-1 text-sm text-notion rounded-md group notion-hover transition-all">
                        <span class="page-icon mr-2">🏠</span>
                        Home
                    </a>
                    <a href="#" class="flex items-center px-2 py-1 text-sm text-notion rounded-md group notion-hover transition-all">
                        <span class="page-icon mr-2">✅</span>
                        Tasks
                    </a>
                </div>
                
                <div class="mt-4 px-3">
                    <div class="flex items-center text-xs text-notion mb-2">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                        WORKSPACES
                    </div>
                    <div class="space-y-1">
                        <a href="#" class="flex items-center px-2 py-1 text-sm text-notion rounded-md notion-hover transition-all">
                            <span class="page-icon mr-2">👤</span>
                            Personal
                        </a>
                        <a href="{{ route('notes.index') }}" class="flex items-center px-2 py-1 text-sm text-notion rounded-md notion-hover transition-all ml-4">
                            <span class="page-icon mr-2">📄</span>
                            Notes
                        </a>
                        <a href="#" class="flex items-center px-2 py-1 text-sm text-notion rounded-md notion-hover transition-all ml-4">
                            <span class="page-icon mr-2">💡</span>
                            Ideas
                        </a>
                    </div>
                </div>
                
                <div class="mt-4 px-1.5">
                    <a href="{{ route('notes.create') }}" class="w-full flex items-center px-2 py-1 text-sm text-notion hover:bg-gray-100 rounded-md transition-all">
                        <span class="page-icon mr-2">➕</span>
                        Add a page
                    </a>
                </div>
            </div>
        </div>
        
        <div class="p-3 border-t border-gray-200">
            <div class="flex items-center space-x-2">
                <div class="h-6 w-6 rounded-full bg-gray-200 flex items-center justify-center text-xs text-gray-600">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <span class="text-sm text-notion-dark">{{ Auth::user()->name }}</span>
            </div>
        </div>
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
                    <div class="h-6 w-6 rounded-full bg-gray-200 flex items-center justify-center text-xs text-gray-600">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </button>
                
                <div id="profileMenu" class="absolute right-0 top-full mt-1 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden border border-gray-200">
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
            <div class="w-full max-w-4xl mx-auto">
                <h1 class="text-3xl font-bold mb-6 text-center">Welcome to ThinkDeck</h1>
            
                <div class="mb-10 text-center">
                    <p class="text-notion mb-2">Your workspace for ideas and productivity</p>
                    <div class="flex space-x-2 justify-center">
                        <a href="{{ route('notes.create') }}" class="px-4 py-1.5 bg-gray-100 hover:bg-gray-200 rounded text-sm font-medium transition-all">New Page</a>
                        <button class="px-4 py-1.5 bg-gray-100 hover:bg-gray-200 rounded text-sm font-medium transition-all">Import</button>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('notes.index') }}" class="block border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-all cursor-pointer">
                        <div class="flex items-center mb-3">
                            <span class="text-2xl mr-2">📝</span>
                            <h3 class="text-base font-medium">Notes</h3>
                        </div>
                        <p class="text-notion text-sm">Capture your ideas quickly without distractions</p>
                    </a>
                    
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-all cursor-pointer">
                        <div class="flex items-center mb-3">
                            <span class="text-2xl mr-2">📚</span>
                            <h3 class="text-base font-medium">Library</h3>
                        </div>
                        <p class="text-notion text-sm">Access your documents and resources</p>
                    </div>
                    
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-all cursor-pointer">
                        <div class="flex items-center mb-3">
                            <span class="text-2xl mr-2">✅</span>
                            <h3 class="text-base font-medium">Tasks</h3>
                        </div>
                        <p class="text-notion text-sm">Manage your todos and track progress</p>
                    </div>
                    
                    <a href="{{ route('notes.create') }}" class="block border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-all cursor-pointer">
                        <div class="flex items-center mb-3">
                            <span class="text-2xl mr-2">➕</span>
                            <h3 class="text-base font-medium">New Note</h3>
                        </div>
                        <p class="text-notion text-sm">Create a new blank note</p>
                    </a>
                </div>
            </div>
        </main>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
        });
    </script>
</body>
</html>