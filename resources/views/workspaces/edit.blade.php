@extends('layouts.dashboard')

@section('title', 'Edit ' . $workspace->name . ' - ThinkDeck')

@section('content')
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
        <a href="{{ route('workspaces.show', $workspace) }}" class="hover:text-indigo-600 transition">{{ $workspace->name }}</a>
        <svg class="w-3 h-3 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="text-gray-700">Edit</span>
    </div>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Edit Workspace</h1>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden max-w-2xl mx-auto">
        <div class="p-5 border-b border-gray-200">
            <h2 class="text-lg font-medium flex items-center">
                <span class="text-xl mr-2">{{ $workspace->icon }}</span>
                {{ $workspace->name }}
            </h2>
        </div>

        <form action="{{ route('workspaces.update', $workspace) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $workspace->name) }}" required
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">Icon</label>
                    <div class="flex flex-col md:flex-row md:space-x-4">
                        <input type="text" name="icon" id="icon" value="{{ old('icon', $workspace->icon) }}" maxlength="5"
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
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description', $workspace->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color (optional)</label>
                    <input type="color" name="color" id="color" value="{{ old('color', $workspace->color ?? '#4f46e5') }}"
                        class="h-10 p-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @error('color')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="is_default" id="is_default" value="1" {{ old('is_default', $workspace->is_default) ? 'checked' : '' }}
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="is_default" class="ml-2 block text-sm text-gray-700">
                        Set as default workspace
                    </label>
                </div>
            </div>
            
            <div class="px-6 py-4 bg-gray-50 text-right space-x-3 border-t border-gray-200">
                <a href="{{ route('workspaces.show', $workspace) }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Workspace
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