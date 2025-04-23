@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Your Profile</h1>
                <a href="{{ route('dashboard') }}" class="flex items-center text-indigo-600 hover:text-indigo-800">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Dashboard
                </a>
            </div>

            <!-- Profile Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div
                            class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-xl font-medium text-indigo-600 mr-4">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
                            <p class="text-gray-600">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <h3 class="text-lg font-medium text-gray-800 mb-2">Account Details</h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Name</p>
                                <p class="font-medium">{{ $user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-medium">{{ $user->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Member Since</p>
                                <p class="font-medium">{{ $user->created_at->format('F d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex flex-wrap gap-3">
                    <a href="{{ route('profile.edit') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        Edit Profile
                    </a>
                    <form id="delete-account-form" method="POST" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" id="delete-account-button"
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            Delete Account
                        </button>
                    </form>
             
                </div>
            </div>

            @include('partials.flash-messages')
        </div>
    </div>

    <!-- Include SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('delete-account-button').addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
            }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-account-form').submit();
            }
            });
        });
    </script>
@endsection