<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - ThinkDeck')</title>
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
        .stat-card {
            @apply bg-white p-5 rounded-lg shadow-sm border border-gray-200 transition-all;
        }
        .stat-card:hover {
            @apply shadow-md border-gray-300 transform -translate-y-0.5;
        }
        .task-item {
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen flex overflow-hidden">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <div class="flex-1 transition-all duration-300 flex flex-col" id="main-content">
        <!-- Top navigation -->
        @include('partials.topnav')
        
        <!-- Main content -->
        <main class="pt-16 pb-6 px-4 sm:px-6 md:px-8 lg:px-10 overflow-y-auto h-screen">
            <div class="w-full max-w-5xl mx-auto">
                <!-- Welcome Banner -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl shadow-md text-white p-8 mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}</h1>
                            <p class="text-indigo-100 mb-4">Your workspace for ideas and productivity</p>
                            <div class="flex flex-col sm:flex-row sm:space-x-3 space-y-2 sm:space-y-0">
                                <a href="{{ route('notes.create') }}" class="px-4 py-2 bg-white text-indigo-700 rounded-md font-medium hover:bg-indigo-50 transition-all flex items-center justify-center sm:justify-start">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    New Note
                                </a>
                                <a href="{{ route('pages.create') }}" class="px-4 py-2 bg-indigo-700 text-white border border-indigo-300 rounded-md font-medium hover:bg-indigo-800 transition-all flex items-center justify-center sm:justify-start">
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
                
                <!-- Alerts -->
                <div id="alert-container">
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
                </div>
                
                <!-- Quick Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <div class="stat-card">
                        <h3 class="text-sm text-gray-500 mb-1">Total Notes</h3>
                        <div class="flex items-center">
                            <p class="text-2xl font-semibold">{{ Auth::user()->notes()->count() }}</p>
                            <svg class="w-4 h-4 text-indigo-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-card">
                        <h3 class="text-sm text-gray-500 mb-1">Total Pages</h3>
                        <div class="flex items-center">
                            <p class="text-2xl font-semibold">{{ Auth::user()->pages()->count() }}</p>
                            <svg class="w-4 h-4 text-indigo-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-card">
                        <h3 class="text-sm text-gray-500 mb-1">Tasks</h3>
                        <div class="flex items-center">
                            <p class="text-2xl font-semibold">
                                <span class="text-green-600" id="completed-tasks-count">{{ Auth::user()->tasks()->where('completed', true)->count() }}</span>
                                <span class="text-gray-400">/</span>
                                <span id="total-tasks-count">{{ Auth::user()->tasks()->count() }}</span>
                            </p>
                            <svg class="w-4 h-4 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                    <div class="stat-card">
                        <h3 class="text-sm text-gray-500 mb-1">Workspaces</h3>
                        <div class="flex items-center">
                            <p class="text-2xl font-semibold">{{ Auth::user()->workspaces()->count() }}</p>
                            <svg class="w-4 h-4 text-indigo-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left column -->
                    <div class="space-y-6">
                        <!-- Recent Notes -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-5 border-b border-gray-200 flex justify-between items-center">
                                <h2 class="text-lg font-medium flex items-center">
                                    <span class="text-xl mr-2">📝</span>
                                    Recent Notes
                                </h2>
                                <a href="{{ route('notes.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 transition">View all</a>
                            </div>
                            <div class="divide-y divide-gray-100">
                                @forelse(Auth::user()->notes()->latest()->take(3)->get() as $note)
                                    <a href="{{ route('notes.show', $note) }}" class="block p-4 hover:bg-gray-50 transition">
                                        <h3 class="text-sm font-medium mb-1 flex items-center">
                                            <span class="page-icon mr-2">{{ $note->icon ?? '📝' }}</span>
                                            {{ Str::limit($note->title, 40) }}
                                        </h3>
                                        <div class="flex justify-between items-center text-xs text-gray-500">
                                            <span>Updated {{ $note->updated_at->diffForHumans() }}</span>
                                            <span class="px-2 py-1 bg-gray-100 rounded">Note</span>
                                        </div>
                                    </a>
                                @empty
                                    <div class="p-4 text-center text-gray-500">
                                        <p>No notes yet</p>
                                        <a href="{{ route('notes.create') }}" class="mt-2 inline-block text-indigo-600 hover:text-indigo-800 text-sm">Create your first note</a>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Import Content -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
                            <h2 class="text-lg font-medium flex items-center mb-4">
                                <span class="text-xl mr-2">📥</span>
                                Import Content
                            </h2>
                            <p class="text-sm text-gray-600 mb-3">Import your documents from various formats</p>
                            <button id="showImportModal" class="w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-md text-sm font-medium transition-all text-center cursor-pointer border border-gray-200 flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                </svg>
                                Choose File
                            </button>
                            <div class="mt-3 text-xs text-gray-500">
                                Supported formats: Word, PDF, TXT, Markdown
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right column -->
                    <div class="space-y-6">
                        <!-- Recent Pages -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-5 border-b border-gray-200 flex justify-between items-center">
                                <h2 class="text-lg font-medium flex items-center">
                                    <span class="text-xl mr-2">📚</span>
                                    Recent Pages
                                </h2>
                                <a href="{{ route('pages.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 transition">View all</a>
                            </div>
                            <div class="divide-y divide-gray-100">
                                @forelse(Auth::user()->pages()->latest()->take(3)->get() as $page)
                                    <a href="{{ route('pages.show', $page) }}" class="block p-4 hover:bg-gray-50 transition">
                                        <h3 class="text-sm font-medium mb-1 flex items-center">
                                            <span class="page-icon mr-2">{{ $page->icon ?? '📄' }}</span>
                                            {{ Str::limit($page->title, 40) }}
                                        </h3>
                                        <div class="flex justify-between items-center text-xs text-gray-500">
                                            <span>Updated {{ $page->updated_at->diffForHumans() }}</span>
                                            <span class="px-2 py-1 bg-gray-100 rounded">Page</span>
                                        </div>
                                    </a>
                                @empty
                                    <div class="p-4 text-center text-gray-500">
                                        <p>No pages yet</p>
                                        <a href="{{ route('pages.create') }}" class="mt-2 inline-block text-indigo-600 hover:text-indigo-800 text-sm">Create your first page</a>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        
                        <!-- Tasks -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-5 border-b border-gray-200 flex justify-between items-center">
                                <h2 class="text-lg font-medium flex items-center">
                                    <span class="text-xl mr-2">✅</span>
                                    Tasks
                                </h2>
                                <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800 transition">View all</a>
                            </div>
                            <div class="p-4">
                                <div class="space-y-3" id="tasks-container">
                                    @forelse(Auth::user()->tasks()->latest()->take(5)->get() as $task)
                                        <div class="flex items-center task-item">
                                            <input type="checkbox" id="task-{{ $task->id }}" 
                                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded task-checkbox"
                                                data-task-id="{{ $task->id }}"
                                                {{ $task->completed ? 'checked' : '' }}>
                                            <label for="task-{{ $task->id }}" class="ml-2 text-sm {{$task->completed ? 'line-through text-gray-500' : ''}}">
                                                {{ $task->title }}
                                            </label>
                                            @if($task->due_date)
                                                <span class="ml-2 text-xs {{ $task->due_date < now() ? 'text-red-500' : 'text-gray-500' }}">
                                                    {{ $task->due_date->format('M d') }}
                                                </span>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="text-center text-gray-500" id="no-tasks-message">
                                            <p>No tasks yet</p>
                                            <a href="#" class="mt-2 inline-block text-indigo-600 hover:text-indigo-800 text-sm">Create your first task</a>
                                        </div>
                                    @endforelse
                                </div>
                                
                                <form id="newTaskForm" class="mt-4 flex items-center">
                                    <input type="text" id="newTask" placeholder="Add a new task..." 
                                        class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm p-2">
                                    <button type="submit" class="ml-2 p-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
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
            const showImportModal = document.getElementById('showImportModal');
            const importModal = document.getElementById('importModal');
            const alertContainer = document.getElementById('alert-container');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Profile menu toggle
            if (profileButton && profileMenu) {
                profileButton.addEventListener('click', function () {
                    profileMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', function (event) {
                    if (!profileButton.contains(event.target) && !profileMenu.contains(event.target)) {
                        profileMenu.classList.add('hidden');
                    }
                });
            }
            
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

            if (toggleSidebar && sidebarToggle) {
                toggleSidebar.addEventListener('click', toggleSidebarVisibility);
                sidebarToggle.addEventListener('click', toggleSidebarVisibility);
            }

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

            // Show import modal
            if (showImportModal && importModal) {
                showImportModal.addEventListener('click', function() {
                    importModal.classList.remove('hidden');
                });
            }
            
            // Helper function to show alerts
            function showAlert(message, type = 'success') {
                const alertDiv = document.createElement('div');
                alertDiv.className = type === 'success' 
                    ? 'bg-green-50 text-green-800 rounded-lg p-4 mb-6 flex items-start' 
                    : 'bg-red-50 text-red-800 rounded-lg p-4 mb-6 flex items-start';
                
                const iconPath = type === 'success'
                    ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                    : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
                
                alertDiv.innerHTML = `
                    <svg class="w-5 h-5 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        ${iconPath}
                    </svg>
                    <div>${message}</div>
                `;
                
                alertContainer.appendChild(alertDiv);
                
                // Remove the alert after 5 seconds
                setTimeout(() => {
                    alertDiv.style.opacity = '0';
                    alertDiv.style.transition = 'opacity 0.5s';
                    setTimeout(() => alertContainer.removeChild(alertDiv), 500);
                }, 5000);
            }

            // Task checkboxes
            document.querySelectorAll('.task-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const taskId = this.dataset.taskId;
                    const completed = this.checked;
                    
                    // Update label styling
                    const label = this.nextElementSibling;
                    if (completed) {
                        label.classList.add('line-through', 'text-gray-500');
                    } else {
                        label.classList.remove('line-through', 'text-gray-500');
                    }
                    
                    // Send AJAX request to update task status
                    fetch(`/tasks/${taskId}/toggle`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ completed })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to update task status');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Update completed tasks count
                        document.getElementById('completed-tasks-count').textContent = 
                            completed ? 
                                parseInt(document.getElementById('completed-tasks-count').textContent) + 1 : 
                                parseInt(document.getElementById('completed-tasks-count').textContent) - 1;
                    })
                    .catch(error => {
                        showAlert(error.message, 'error');
                        // Revert checkbox state on error
                        this.checked = !completed;
                        if (!completed) {
                            label.classList.add('line-through', 'text-gray-500');
                        } else {
                            label.classList.remove('line-through', 'text-gray-500');
                        }
                    });
                });
            });

            // New task form
            const newTaskForm = document.getElementById('newTaskForm');
            const tasksContainer = document.getElementById('tasks-container');
            const noTasksMessage = document.getElementById('no-tasks-message');
            
            if (newTaskForm) {
                newTaskForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const taskInput = document.getElementById('newTask');
                    const taskTitle = taskInput.value.trim();
                    
                    if (taskTitle) {
                        // Show loading state
                        const submitButton = this.querySelector('button[type="submit"]');
                        submitButton.disabled = true;
                        submitButton.innerHTML = `<svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>`;
                        
                        // Send AJAX request to create new task
                        fetch('/tasks', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({ title: taskTitle })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Failed to create task');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Hide "no tasks" message if it exists
                                if (noTasksMessage) {
                                    noTasksMessage.style.display = 'none';
                                }
                                
                                // Create new task element
                                const task = data.task;
                                const taskElement = document.createElement('div');
                                taskElement.className = 'flex items-center task-item';
                                taskElement.innerHTML = `
                                    <input type="checkbox" id="task-${task.id}" 
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded task-checkbox"
                                        data-task-id="${task.id}">
                                    <label for="task-${task.id}" class="ml-2 text-sm">
                                        ${task.title}
                                    </label>
                                `;
                                
                                // Add the task to the container
                                tasksContainer.prepend(taskElement);
                                
                                // Update task counts
                                document.getElementById('total-tasks-count').textContent = 
                                    parseInt(document.getElementById('total-tasks-count').textContent) + 1;
                                
                                // Add event listener to the new checkbox
                                const newCheckbox = taskElement.querySelector('.task-checkbox');
                                newCheckbox.addEventListener('change', function() {
                                    const completed = this.checked;
                                    const label = this.nextElementSibling;
                                    
                                    if (completed) {
                                        label.classList.add('line-through', 'text-gray-500');
                                    } else {
                                        label.classList.remove('line-through', 'text-gray-500');
                                    }
                                    
                                    fetch(`/tasks/${task.id}/toggle`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': csrfToken
                                        },
                                        body: JSON.stringify({ completed })
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        document.getElementById('completed-tasks-count').textContent = 
                                            completed ? 
                                                parseInt(document.getElementById('completed-tasks-count').textContent) + 1 : 
                                                parseInt(document.getElementById('completed-tasks-count').textContent) - 1;
                                    });
                                });
                                
                                showAlert('Task created successfully', 'success');
                            }
                        })
                        .catch(error => {
                            showAlert(error.message, 'error');
                        })
                        .finally(() => {
                            // Reset form
                            taskInput.value = '';
                            
                            // Reset button
                            submitButton.disabled = false;
                            submitButton.innerHTML = `
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            `;
                            
                            // Focus back on input
                            taskInput.focus();
                        });
                    }
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>