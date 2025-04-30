@extends('layouts.dashboard')

@section('title', 'New Workspace - ThinkDeck')

@section('topnav-title')
    {{-- Optionally add a title specific to the top navigation for this page --}}
    <h1 class="text-lg font-medium">Create or Join Workspace</h1>
@endsection

@section('dashboard-content')

    {{-- Breadcrumbs Partial --}}
    @include('partials.breadcrumbs', [
        'breadcrumbs' => [
            // Pass the full URL directly if it's known
            ['url' => route('workspaces.index'), 'name' => 'Workspaces'],
            // For the current page, omit the 'url' key
            ['name' => 'Create or Join']
        ]
    ])

    {{-- Flash Messages Partial --}}
    <!-- @include('partials.flash-messages') -->

    {{-- Join Workspace Section --}}
    <div class="mb-8"> {{-- Added margin-bottom --}}
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
                        {{-- Consider adding an icon inside the input if desired --}}
                        <input type="text" name="workspace_ref" id="ref_code" placeholder="Enter code e.g., #WS-..."
                            class="block w-full pl-3 pr-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" {{-- Adjusted padding --}}
                            title="Enter the workspace reference code"
                            value="{{ old('workspace_ref', '#WS-') }}"> {{-- Use old input --}}
                    </div>
                    {{-- Display session errors specifically for this form if needed, or rely on general flash messages --}}
                    @if(session('workspaceError'))
                        <p class="mt-1 text-sm text-red-600">{{ session('workspaceError') }}</p>
                    @endif
                    @error('workspace_ref')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-full md:w-auto flex-shrink-0"> {{-- Added flex-shrink-0 --}}
                    <button type="submit" class="w-full md:w-auto px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m-1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path> {{-- Changed Icon --}}
                        </svg>
                        Join Workspace
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Create Workspace Section --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Create New Workspace</h1>
        {{-- Removed the header button as it's redundant with the form below --}}
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
                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="My Awesome Project">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Icon --}}
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">Icon</label>
                    <div class="flex flex-col md:flex-row md:items-start md:space-x-4">
                        <input type="text" name="icon" id="icon" value="{{ old('icon', '🏢') }}" maxlength="5" {{-- Default Icon --}}
                            class="w-20 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-center text-2xl p-1"> {{-- Adjusted size/padding --}}
                        <div class="mt-2 md:mt-0 flex-1">
                            <p class="text-xs text-gray-500 mb-2">Choose an emoji:</p>
                            <div class="grid grid-cols-8 gap-1"> {{-- Reduced gap --}}
                                @foreach(['🏢', '🏠', '💼', '📚', '🔬', '🎓', '🎨', '💻', '📊', '🔧', '🏆', '🌎', '🚀', '💡', '📝', '⭐', '💡', '🎯', '🎉', '💡', '🤝', '💬', '🧪', '🌱'] as $emoji)
                                    <button type="button" class="emoji-btn p-1.5 rounded text-xl hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-300" onclick="selectEmoji(this, '{{ $emoji }}')">
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

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-gray-500">(optional)</span></label>
                    <textarea name="description" id="description" rows="3"
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="A brief description of this workspace's purpose">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Color --}}
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color <span class="text-gray-500">(optional)</span></label>
                    <input type="color" name="color" id="color" value="{{ old('color', '#4f46e5') }}"
                        class="h-10 w-16 p-1 border border-gray-300 rounded-md shadow-sm cursor-pointer"> {{-- Added border --}}
                    @error('color')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Is Default --}}
                <div class="flex items-center">
                    <input type="checkbox" name="is_default" id="is_default" value="1" {{ old('is_default') ? 'checked' : '' }}
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="is_default" class="ml-2 block text-sm text-gray-700">
                        Set as default workspace after creation
                    </label>
                </div>
            </div>

            {{-- Form Actions --}}
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

<script>
    function selectEmoji(button, emoji) {
        document.getElementById('icon').value = emoji;
        // Remove highlight from all buttons
        document.querySelectorAll('.emoji-btn').forEach(btn => btn.classList.remove('ring-2', 'ring-indigo-500', 'bg-indigo-100'));
        // Add highlight to the clicked button
        button.classList.add('ring-2', 'ring-indigo-500', 'bg-indigo-100');
    }

    // Optional: Highlight the initially selected emoji on page load
    document.addEventListener('DOMContentLoaded', function() {
        const initialIcon = document.getElementById('icon').value;
        const buttons = document.querySelectorAll('.emoji-btn');
        buttons.forEach(btn => {
            if (btn.textContent.trim() === initialIcon) {
                btn.classList.add('ring-2', 'ring-indigo-500', 'bg-indigo-100');
            }
        });
    });
</script>
@endsection