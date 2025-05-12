@extends('layouts.admin')

@section('title', 'Manage Users - ThinkDeck')

@section('content')
<div class="w-full max-w-7xl mx-auto">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
        <div class="p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-2xl font-bold text-gray-800 mb-1">Users Management</h1>
                    <p class="text-gray-600">Manage all users on the ThinkDeck platform</p>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
        <div class="p-5">
            <form action="" method="GET" class="space-y-4">
                <div class="flex flex-col md:flex-row md:space-x-4">
                    <div class="w-full md:w-1/3 mb-4 md:mb-0">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search by name or email" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div class="w-full md:w-1/3 mb-4 md:mb-0">
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select name="role" id="role" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">All Roles</option>
                            <option value="1" {{ request('role') == '1' ? 'selected' : '' }}>Admin</option>
                            <option value="0" {{ request('role') == '0' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
                    <div class="w-full md:w-1/3">
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                        <select name="sort" id="sort" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="created_at_desc" {{ request('sort') == 'created_at_desc' ? 'selected' : '' }}>Newest First</option>
                            <option value="created_at_asc" {{ request('sort') == 'created_at_asc' ? 'selected' : '' }}>Oldest First</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition-all text-sm">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            User
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Joined
                        </th>
                       
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users ?? [] as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                        @if($user->profile_photo_path)
                                            <img class="h-10 w-10 rounded-full" src="{{ Storage::url($user->profile_photo_path) }}" alt="{{ $user->name }}">
                                        @else
                                            <span class="text-gray-500 font-medium">{{ substr($user->name, 0, 1) }}</span>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $user->name }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->is_admin ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $user->is_admin ? 'Admin' : 'User' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <!-- Switch Role Button -->
                                    <button type="button"
                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to change this user\'s role to \'{{ $user->is_admin ? 'User' : 'Admin' }}\'?')) { document.getElementById('toggle-role-form-{{ $user->id }}').submit(); }"
                                        class="{{ $user->is_admin ? 'text-yellow-600 hover:text-yellow-900' : 'text-blue-600 hover:text-blue-900' }}">
                                        {{ $user->is_admin ? 'Make User' : 'Make Admin' }}
                                    </button>
                                    <form id="toggle-role-form-{{ $user->id }}" action="{{ route('admin.updateRole',[$user]) }}"  method="POST" class="hidden">
                                        @csrf
                                        @method('PATCH')
                                    </form>

                                    <!-- Delete Button -->
                                    <button type="button"
                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this user?')) { document.getElementById('delete-form-{{ $user->id }}').submit(); }"
                                        class="text-red-600 hover:text-red-900">
                                        Delete
                                    </button>
                                    <form id="delete-form-{{ $user->id }}" action="#" {{-- Replace # with your actual route for deleting user --}} method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                <p>No users found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if(isset($users) && $users->hasPages())
    <div class="bg-white px-4 py-3 border border-gray-200 rounded-lg shadow-sm">
        {{ $users->withQueryString()->links() }}
    </div>
    @endif

    <!-- User Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
        <div class="stat-card">
            <h3 class="text-sm text-gray-500 mb-1">Total Users</h3>
            <div class="flex items-center">
                <p class="text-2xl font-semibold">{{ $userCount ?? 0 }}</p>
                <svg class="w-4 h-4 text-indigo-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
        </div>
        
        <div class="stat-card">
            <h3 class="text-sm text-gray-500 mb-1">Admin Users</h3>
            <div class="flex items-center">
                <p class="text-2xl font-semibold">{{ $adminUsers ?? 0 }}</p>
                <svg class="w-4 h-4 text-purple-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
        </div>
        
        <div class="stat-card">
            <h3 class="text-sm text-gray-500 mb-1">New Users (30 days)</h3>
            <div class="flex items-center">
                <p class="text-2xl font-semibold">{{ $newUsers ?? 0 }}</p>
                <svg class="w-4 h-4 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </div>
        </div>
    </div>
</div>
@endsection