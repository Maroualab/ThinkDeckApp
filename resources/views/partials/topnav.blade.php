<header class="h-12 border-b border-gray-200 flex items-center px-4 bg-white fixed w-full z-10">
    <button id="sidebarToggle" class="mr-3 text-gray-500 hover:text-gray-700 focus:outline-none">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>
    
    <div class="flex-1">
        @yield('topnav-title')
    </div>
    
    <div class="flex items-center space-x-4">
        <button id="importButton" class="text-gray-500 hover:text-gray-700 focus:outline-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
            </svg>
        </button>
        
        <div class="relative">
            <button id="profileButton" class="flex items-center space-x-2 rounded p-1 hover:bg-gray-100 focus:outline-none transition-all">
                <div class="h-6 w-6 rounded-full bg-gray-200 flex items-center justify-center text-xs text-gray-600">
                    {{ Auth::check() ? substr(Auth::user()->name, 0, 1) : '?' }}
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
    </div>
    
    <!-- Import Form Modal -->
    <div id="importModal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium">Import Document</h3>
                <button id="closeImportModal" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="importForm" action="{{ route('documents.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="fileImport" class="block text-sm font-medium text-gray-700 mb-2">Select Document</label>
                    <input type="file" id="fileImport" name="document" accept=".doc,.docx,.pdf,.txt,.md" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <p class="text-sm text-gray-500 mt-1">Supported formats: .doc, .docx, .pdf, .txt, .md</p>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</header>

