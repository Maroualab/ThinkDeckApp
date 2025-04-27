@extends('layouts.dashboard')

@section('title', 'New Workspace - ThinkDeck')

@section('content')
<div class="container mx-auto px-4 py-4 mb-6">
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-5 shadow-sm">
        <div class="flex items-center mb-3">
            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            <h2 class="text-lg font-semibold text-gray-800">Join an existing workspace</h2>
        </div>
        
        <form action="{{ route('workspaces.join') }}" method="POST" class="flex flex-wrap md:flex-nowrap items-end gap-3">
            @csrf
            <div class="flex-grow w-full">
                <label for="ref_code" class="block text-sm font-medium text-gray-700 mb-1">Reference Code</label>
                <div class="relative">
                    <input type="text" name="workspace_ref" id="ref_code" placeholder="Enter code exemple(#WS-344De...)" 
                        class="block w-full pl-12 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        title="Only alphanumeric characters allowed"
                        value="#WS-">
                </div>
                @if(session('workspaceError'))
                    <p class="mt-1 text-sm text-red-600">{{ session('workspaceError') }}</p>
                @endif
                @error('workspace_ref')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-full md:w-auto">
                <button type="submit" class="w-full md:w-auto px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center justify-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Join Workspace
                </button>
            </div>
        </form>
    </div>
</div>
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <div class="flex items-center text-sm text-gray-500 mb-6">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition">Dashboard</a>
        <svg class="w-3 h-3 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <a href="{{ route('workspaces.index') }}" class="hover:text-indigo-600 transition">Workspaces</a>
        <svg class="w-3 h-3 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="text-gray-700">Create Workspace</span>
    </div>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Create Workspace</h1>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden max-w-2xl mx-auto">
        <div class="p-5 border-b border-gray-200">
            <h2 class="text-lg font-medium flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Workspace Details
            </h2>
        </div>

        <form action="{{ route('workspaces.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="My Workspace">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">Icon</label>
                    <div class="flex flex-col md:flex-row md:space-x-4">
                        <input type="text" name="icon" id="icon" value="{{ old('icon', '👤') }}" maxlength="5"
                            class="w-24 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-center text-2xl">
                        <div class="mt-2 md:mt-0">
                            <div class="grid grid-cols-8 gap-2">
                                @foreach(['👤', '🏠', '💼', '📚', '🔬', '🎓', '🎨', '💻', '📊', '🔧', '🏆', '🌎', '🚀', '💡', '📝', '⭐'] as $emoji)
                                    <button type="button" class="emoji-btn p-2 rounded hover:bg-gray-100" onclick="document.getElementById('icon').value = '{{ $emoji }}'">
                                        {{ $emoji }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @error('icon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description (optional)</label>
                    <textarea name="description" id="description" rows="3"
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="A brief description of this workspace">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color (optional)</label>
                    <input type="color" name="color" id="color" value="{{ old('color', '#4f46e5') }}"
                        class="h-10 p-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('color')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="is_default" id="is_default" value="1" {{ old('is_default') ? 'checked' : '' }}
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="is_default" class="ml-2 block text-sm text-gray-700">
                        Set as default workspace
                    </label>
                </div>
            </div>
            
            <div class="px-6 py-4 bg-gray-50 text-right space-x-3 border-t border-gray-200">
                <a href="{{ route('workspaces.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create Workspace
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Emoji button highlight
    document.querySelectorAll('.emoji-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.emoji-btn').forEach(b => b.classList.remove('ring-2', 'ring-indigo-500'));
            this.classList.add('ring-2', 'ring-indigo-500');
        });
    });
</script>
@endsection