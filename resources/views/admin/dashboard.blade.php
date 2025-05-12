@extends('layouts.admin')

@section('title', 'Admin Dashboard - ThinkDeck')

@section('content')
<div class="w-full max-w-7xl mx-auto">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl shadow-md text-white p-8 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Admin Dashboard</h1>
                <p class="text-indigo-100 mb-4">Manage your ThinkDeck platform</p>
                <div class="flex flex-col sm:flex-row sm:space-x-3 space-y-2 sm:space-y-0">
                    <a href="{{ route('admin.users.index') }}"
                        class="px-4 py-2 bg-white text-indigo-700 rounded-md font-medium hover:bg-indigo-50 transition-all flex items-center justify-center sm:justify-start">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Manage Users
                    </a>
                    <a href="{{ route('dashboard') }}" 
                        class="px-4 py-2 bg-white text-indigo-700 rounded-md font-medium hover:bg-indigo-50 transition-all flex items-center justify-center sm:justify-start">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        View App Dashboard
                    </a>
                    
                </div>
            </div>
            <div class="hidden md:block">
                <svg class="w-32 h-32 text-indigo-300 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4 mb-8">
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
            <h3 class="text-sm text-gray-500 mb-1">Total Pages</h3>
            <div class="flex items-center">
                <p class="text-2xl font-semibold">{{ $pageCount ?? 0 }}</p>
                <svg class="w-4 h-4 text-indigo-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
            </div>
        </div>
       
    </div>

    <!-- Quick Access -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 mb-8">
        <h2 class="text-lg font-medium flex items-center mb-4">
            <span class="text-xl mr-2">🔍</span>
            Quick Access
        </h2>
        <div class="w-full">
            <a href="{{ route('admin.users.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white p-4 rounded-lg transition flex items-center justify-between">
                <div>
                    <h3 class="font-medium">Users</h3>
                    <p class="text-xs text-indigo-200">Manage all users</p>
                </div>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
            
        </div>
    </div>

    <div class="w-full">
        <!-- Recent Users -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden ">
            <div class="p-5 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-medium flex items-center">
                    <span class="text-xl mr-2">👥</span>
                    Recent Users
                </h2>
                <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800 transition">View all</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($recentUsers ?? [] as $user)
                    <div class="p-4 hover:bg-gray-50 transition flex justify-between items-center">
                        <div>
                            <h3 class="text-sm font-medium mb-1">{{ $user->name }}</h3>
                            <div class="flex items-center text-xs text-gray-500">
                                <span>{{ $user->email }}</span>
                                <span class="mx-2">•</span>
                                <span>Joined {{ $user->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                        <a href="#" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">View</a>
                    </div>
                @empty
                    <div class="p-4 text-center text-gray-500">
                        <p>No users found</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    
</div>
@endsection
