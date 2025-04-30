@extends('layouts.dashboard') {{-- Changed layout --}}

@section('title', 'Your Profile - ThinkDeck') {{-- Added title --}}

@section('topnav-title')
    <h1 class="text-lg font-medium">Your Profile</h1> {{-- Added topnav title --}}
@endsection

@section('dashboard-content') {{-- Changed section name --}}

    {{-- Breadcrumbs Partial --}}
    @include('partials.breadcrumbs', [
        'breadcrumbs' => [
            ['name' => 'Profile'] // Current page
        ]
    ])

    {{-- Flash Messages Partial (Included via layout now) --}}
    {{-- @include('partials.flash-messages') --}}

    {{-- Profile Card --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden max-w-3xl mx-auto"> {{-- Added card styling --}}
        {{-- Card Header (Optional - Can add if desired) --}}
        {{-- <div class="p-5 border-b border-gray-200 bg-gray-50/50">
            <h2 class="text-lg font-medium">Profile Information</h2>
        </div> --}}

        {{-- Card Body --}}
        <div class="p-6">
            <div class="flex items-center mb-6">
                <div
                    class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-xl font-medium text-indigo-600 mr-4">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h2> {{-- Adjusted font weight --}}
                    <p class="text-gray-600">{{ $user->email }}</p>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-4">
                <h3 class="text-lg font-medium text-gray-800 mb-3">Account Details</h3> {{-- Adjusted margin --}}
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4"> {{-- Use definition list for semantics --}}
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->name }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('F d, Y') }}</dd>
                    </div>
                    {{-- Add other details if needed --}}
                </dl>
            </div>
        </div>

        {{-- Card Footer with Actions --}}
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-wrap items-center justify-start gap-3"> {{-- Changed alignment --}}
            <a href="{{ route('profile.edit') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors text-sm font-medium"> {{-- Consistent button style --}}
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
                Edit Profile
            </a>
            <form id="delete-account-form" method="POST" action="{{ route('profile.destroy') }}" class="inline"> {{-- Added inline class --}}
                @csrf
                @method('DELETE')
                <button type="button" id="delete-account-button"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-red-50 hover:border-red-300 hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors text-sm font-medium"> {{-- Consistent button style, added hover effect --}}
                    <svg class="w-4 h-4 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"> {{-- Adjusted icon color --}}
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                    Delete Account
                </button>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    @parent {{-- Include dashboard scripts --}}
    <!-- Include SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Keep SweetAlert logic
        const deleteButton = document.getElementById('delete-account-button');
        if (deleteButton) {
            deleteButton.addEventListener('click', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: "Are you sure?",
                    text: "Deleting your account is permanent and cannot be undone!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#e53e3e", // Red color for confirm
                    cancelButtonColor: "#718096", // Gray color for cancel
                    confirmButtonText: "Yes, delete it!",
                    customClass: { // Optional: Style popup
                        confirmButton: 'px-4 py-2 rounded',
                        cancelButton: 'px-4 py-2 rounded'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const deleteForm = document.getElementById('delete-account-form');
                        if(deleteForm) {
                            deleteForm.submit();
                        }
                    }
                });
            });
        }
    </script>
@endsection