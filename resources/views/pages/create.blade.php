@extends('layouts.dashboard') 

@section('title', 'New Page - ThinkDeck')

@section('topnav-title')
    <h1 class="text-lg font-medium">Create New Page</h1>
@endsection

@section('additional-styles')
@parent
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endsection

@section('dashboard-content')
    {{-- Breadcrumbs Partial --}}


    @include('partials.breadcrumbs', [
        'breadcrumbs' => [
            ['url' => route('pages.index'), 'name' => 'Pages'], // Link back to pages index
            ['name' => 'Create'] 
        ]
    ])

    {{-- Page Header --}}


    <div class="flex justify-between items-center mb-6"> {{-- Standard margin --}}


        <h1 class="text-2xl font-semibold text-gray-900">Create New Page</h1> {{-- Consistent styling --}}


        <a href="{{ route('pages.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-all flex items-center text-sm font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
            </svg>
            Back to Pages
        </a>
    </div>

    {{-- Flash Messages Partial --}}


    <!-- @include('partials.flash-messages') -->

    {{-- Form Card --}}


    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden max-w-4xl mx-auto">
        <form action="{{ route('pages.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-6">

                {{-- Icon Picker & Title Row --}}


                <div class="flex items-start space-x-4">
                    {{-- Icon Display/Input --}}


                    <div class="relative group">
                         <label for="icon" class="block text-xs font-medium text-gray-500 mb-1 text-center">Icon</label>
                         <input type="text" name="icon" id="icon" value="{{ old('icon', '📄') }}" maxlength="5" readonly {{-- Make readonly, value set by JS --}}


                               class="w-16 h-16 border border-gray-300 rounded-md shadow-sm text-center text-3xl p-2 cursor-pointer hover:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                         {{-- Simple tooltip --}}


                         <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block px-2 py-1 bg-gray-700 text-white text-xs rounded">Click to change</span>
                         @error('icon')
                            <p class="mt-1 text-xs text-red-600 text-center">{{ $message }}</p>
                         @enderror
                    </div>

                    {{-- Title Input --}}


                    <div class="flex-1">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" id="title" placeholder="Untitled Page"
                               class="w-full border-gray-300 rounded-md shadow-sm text-xl font-semibold focus:ring-indigo-500 focus:border-indigo-500" {{-- Increased font weight --}}


                               value="{{ old('title') }}" required autofocus>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>



                <div id="emoji-picker-panel" class="border border-gray-200 rounded-md p-3 bg-gray-50 hidden">
                     <p class="text-xs text-gray-500 mb-2">Choose an emoji:</p>
                     <div class="grid grid-cols-8 sm:grid-cols-10 md:grid-cols-12 gap-1">
                         @foreach(['📄', '📝', '📅', '📌', '💡', '⭐', '✅', '❌', '❓', '❗', '🔗', '⚙️', '🔒', '🔑', '📁', '📊', '📈', '📉', '🎯', '🚀', '🎉', '🧠', '💬', '🤔'] as $emoji)
                             <button type="button" class="emoji-btn p-1.5 rounded text-xl hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-300" onclick="selectEmoji(this, '{{ $emoji }}')">
                                 {{ $emoji }}
                             </button>
                         @endforeach
                     </div>
                     <button type="button" onclick="toggleEmojiPicker(false)" class="mt-2 text-xs text-indigo-600 hover:underline">Close</button>
                </div>


                {{-- Content --}}


                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1 sr-only">Content</label>
                    <textarea name="content" id="content">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>



                @if(isset($workspaces) && $workspaces->count() > 0)
                    <div>
                        <label for="workspace_id" class="block text-sm font-medium text-gray-700 mb-1">Add to Workspace</label>
                        <select name="workspace_id" id="workspace_id" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">None (Personal Page)</option> {{-- Clearer default option --}}


                            @foreach($workspaces as $ws)
                                <option value="{{ $ws->id }}" {{ old('workspace_id', request('workspace_id')) == $ws->id ? 'selected' : '' }}>
                                    {{ $ws->icon }} {{ $ws->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('workspace_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @else


                    <input type="hidden" name="workspace_id" value="">
                @endif

            </div>

            {{-- Form Actions --}}


            <div class="px-6 py-4 bg-gray-50 text-right space-x-3 border-t border-gray-200"> {{-- Consistent actions footer --}}


                <a href="{{ route('pages.index') }}"

                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </a>
                <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create Page
                </button>
            </div>
        </form>
    </div>

@endsection

{{-- Add Scripts using @section --}}
@section('scripts')
    @parent

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        // Emoji Picker Logic (Keep this)
        const iconInput = document.getElementById('icon');
        const emojiPickerPanel = document.getElementById('emoji-picker-panel');

        function toggleEmojiPicker(show) {
            if (show) {
                emojiPickerPanel.classList.remove('hidden');
            } else {
                emojiPickerPanel.classList.add('hidden');
            }
        }

        iconInput.addEventListener('click', () => {
            toggleEmojiPicker(true);
        });

        function selectEmoji(button, emoji) {
            iconInput.value = emoji;
            toggleEmojiPicker(false);
            document.querySelectorAll('.emoji-btn').forEach(btn => btn.classList.remove('ring-2', 'ring-indigo-500', 'bg-indigo-100'));
            button.classList.add('ring-2', 'ring-indigo-500', 'bg-indigo-100');
        }

        // Summernote Init
        $(document).ready(function() {
            $('#content').summernote({
                placeholder: 'Start writing your thoughts here...',
                tabsize: 2,
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'italic', 'clear']],
                    // ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
            });

            // Emoji Picker DOM Ready Logic (Keep this)
            const initialIcon = iconInput.value;
            const buttons = document.querySelectorAll('.emoji-btn'); // Removed 'parent' before const
            buttons.forEach(btn => {
                if (btn.textContent.trim() === initialIcon) { /* No initial highlight needed */ }
            });
        });
    </script>
@endsection