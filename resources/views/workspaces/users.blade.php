@extends('layouts.dashboard')

@section('title', $workspace->name . ' Users - ThinkDeck') {{-- Updated Title --}}

@section('topnav-title')
    {{-- Optionally add a title specific to the top navigation for this page --}}
    <h1 class="text-lg font-medium truncate max-w-sm" title="{{ $workspace->name }} Users">
        {{ $workspace->icon }} {{ $workspace->name }} - Users
    </h1>
@endsection

@section('dashboard-content') {{-- Changed from 'content' to 'dashboard-content' for consistency --}}

    {{-- Breadcrumbs Partial --}}
    @include('partials.breadcrumbs', [
        'breadcrumbs' => [
            ['url' => route('workspaces.index'), 'name' => 'Workspaces'],
            ['url' => route('workspaces.show', $workspace), 'name' => $workspace->name], // Link back to workspace show
            ['name' => 'Users'] // Current page
        ]
    ])

    {{-- Flash Messages Partial --}}
    <!-- @include('partials.flash-messages')  -->
    {{-- Replaces all individual session checks --}}

    <div class="flex justify-between items-center mb-6 mt-9">
        <h1 class="text-2xl font-semibold text-gray-900">{{ $workspace->name }} - Users</h1>
        <a href="{{ route('workspaces.show', $workspace) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-all flex items-center text-sm font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
            </svg>
            Back to Workspace
        </a>
    </div>

    <!-- Invite User Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="p-5 border-b border-gray-200">
            <h2 class="text-lg font-medium flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                Invite New User
            </h2>
        </div>
        <div class="p-5">
            {{-- Adjusted form layout for better responsiveness --}}
            <form action="{{ route('workspaces.users.invite',$workspace) }}" method="POST" class="flex flex-wrap md:flex-nowrap items-end gap-3">
                @csrf
                <div class="flex-grow w-full">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" id="email" placeholder="user@example.com" required
                        value="{{ old('email') }}" {{-- Added old() helper --}}
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm">
                    @error('email') {{-- Added specific error display --}}
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-full md:w-auto flex-shrink-0"> {{-- Added flex-shrink-0 --}}
                    <button type="submit" class="w-full md:w-auto px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-all flex items-center justify-center">
                         <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path> {{-- Changed Icon --}}
                        </svg>
                        Send Invitation
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Users List -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-5 border-b border-gray-200">
            <h2 class="text-lg font-medium flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                Workspace Users ({{ $workspace->users->count() }})
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider ">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Use forelse for better empty state handling --}}
                    @forelse($workspace->users as $user)
                        <tr>
                            {{-- User Info --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        {{-- Consistent avatar style --}}
                                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-medium">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        @if($user->id === $workspace->owner_id)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                Owner
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            {{-- Email --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                            {{-- Status --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{-- Improved status badges --}}
                                @if($user->pivot->is_allowed === 'accepted')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Accepted
                                    </span>
                                @elseif($user->pivot->is_allowed === 'pending')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @elseif($user->pivot->is_allowed === 'rejected')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Rejected
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        {{ ucfirst($user->pivot->is_allowed) }}
                                    </span>
                                @endif
                            </td>
                            {{-- Actions --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center space-x-2">
                                {{-- Refined action button logic --}}
                                {{-- Accept Button (Show if pending or rejected AND current user is owner) --}}
                                @if ($user->pivot->is_allowed !== 'accepted' && $workspace->owner_id === auth()->id())
                                    <form action="{{ route('workspaces.users.accept', [$workspace, $user]) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition-all text-xs" title="Accept User">
                                            Accept
                                        </button>
                                    </form>
                                @endif

                                {{-- Reject Button (Show if pending AND current user is owner) --}}
                                @if ($user->pivot->is_allowed === 'pending' && $workspace->owner_id === auth()->id())
                                    <form action="{{ route('workspaces.users.reject', [$workspace, $user]) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to reject this user?');">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition-all text-xs" title="Reject User">
                                            Reject
                                        </button>
                                    </form>
                                @endif

                                {{-- Remove Button (Show if accepted, not owner, AND current user is owner) --}}
                                @if ($user->pivot->is_allowed === 'accepted' && $user->id !== $workspace->owner_id && $workspace->owner_id === auth()->id())
                                    <form action="{{ route('workspaces.users.remove', [$workspace, $user]) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to remove this user from the workspace?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-gray-100 text-red-600 hover:bg-gray-200 rounded transition-all text-xs" title="Remove User">
                                            Remove
                                        </button>
                                    </form>
                                @endif

                                {{-- Show placeholder if user is owner or no actions available --}}
                                @if ($user->id === $workspace->owner_id || ($workspace->owner_id !== auth()->id() && $user->pivot->is_allowed !== 'pending'))
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        {{-- Empty state row --}}
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                No users have been added to this workspace yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination can be added here if needed --}}
        {{--
        @if($workspace->users()->paginate()->hasPages())
            <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                {{ $workspace->users()->paginate()->links() }}
            </div>
        @endif
        --}}
    </div>

@endsection 