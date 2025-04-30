@extends('layouts.dashboard') {{-- Changed layout --}}

@section('title', 'Edit Profile - ThinkDeck') {{-- Added title --}}

@section('topnav-title')
    <h1 class="text-lg font-medium">Edit Profile</h1> {{-- Added topnav title --}}
@endsection

@section('dashboard-content') {{-- Changed section name --}}

    {{-- Breadcrumbs Partial --}}
    @include('partials.breadcrumbs', [
        'breadcrumbs' => [
            ['url' => route('profile.show'), 'name' => 'Profile'], // Link back to profile show
            ['name' => 'Edit'] // Current action
        ]
    ])

    {{-- Flash Messages Partial (Included via layout now) --}}
    {{-- @include('partials.flash-messages') --}}

    {{-- Edit Profile Card --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden max-w-3xl mx-auto"> {{-- Added card styling --}}
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            {{-- Card Body --}}
            <div class="p-6 space-y-6"> {{-- Added padding and spacing --}}

                {{-- Name Input --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"> {{-- Added shadow-sm --}}
                    @error('name')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p> {{-- Adjusted color --}}
                    @enderror
                </div>

                {{-- Email Input --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror"> {{-- Added shadow-sm --}}
                    @error('email')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p> {{-- Adjusted color --}}
                    @enderror
                </div>

                {{-- Change Password Section --}}
                <div class="border-t border-gray-200 pt-6 space-y-4"> {{-- Added spacing --}}
                    <h3 class="text-lg font-medium text-gray-800">Change Password</h3>
                    <p class="text-sm text-gray-500">Leave these fields empty if you don't want to change your password.</p>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                        <input id="password" type="password" name="password"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror"> {{-- Added shadow-sm --}}
                        @error('password')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p> {{-- Adjusted color --}}
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"> {{-- Added shadow-sm --}}
                    </div>
                </div>
            </div>

            {{-- Card Footer with Actions --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 text-right space-x-3"> {{-- Added footer styling --}}
                <a href="{{ route('profile.show') }}"
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"> {{-- Consistent button style --}}
                    Cancel
                </a>
                <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"> {{-- Consistent button style --}}
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

{{-- No specific scripts needed --}}
@section('scripts')
    @parent
@endsection