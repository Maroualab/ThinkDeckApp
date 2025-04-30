@extends('layouts.dashboard')

@section('title', 'Edit ' . $workspace->name . ' - ThinkDeck')

@section('topnav-title')
    {{-- Optionally add a title specific to the top navigation for this page --}}
    <h1 class="text-lg font-medium truncate max-w-sm" title="Edit {{ $workspace->name }}">
        Edit: {{ $workspace->icon }} {{ $workspace->name }}
    </h1>
@endsection

@section('dashboard-content') {{-- Changed from 'content' --}}

    {{-- Breadcrumbs Partial --}}
    @include('partials.breadcrumbs', [
        'breadcrumbs' => [
            ['url' => route('workspaces.index'), 'name' => 'Workspaces'],
            ['url' => route('workspaces.show', $workspace), 'name' => $workspace->name], // Link back to workspace show
            ['name' => 'Edit'] // Current page
        ]
    ])

    {{-- Flash Messages Partial --}}
    <!-- @include('partials.flash-messages') -->

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Edit Workspace</h1>
        {{-- Optional: Add a back button if desired --}}
        <a href="{{ route('workspaces.show', $workspace) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-all flex items-center text-sm font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
            </svg>
            Back to Workspace
        </a>
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
                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $workspace->name) }}" required
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Icon --}}
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">Icon</label>
                    <div class="flex flex-col md:flex-row md:items-start md:space-x-4">
                        <input type="text" name="icon" id="icon" value="{{ old('icon', $workspace->icon) }}" maxlength="5"
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
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description', $workspace->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Color --}}
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color <span class="text-gray-500">(optional)</span></label>
                    <input type="color" name="color" id="color" value="{{ old('color', $workspace->color ?? '#4f46e5') }}"
                        class="h-10 w-16 p-1 border border-gray-300 rounded-md shadow-sm cursor-pointer"> {{-- Added border --}}
                    @error('color')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Is Default --}}
                <div class="flex items-center">
                    <input type="checkbox" name="is_default" id="is_default" value="1" {{ old('is_default', $workspace->is_default) ? 'checked' : '' }}
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="is_default" class="ml-2 block text-sm text-gray-700">
                        Set as default workspace
                    </label>
                </div>
            </div>

            {{-- Form Actions --}}
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