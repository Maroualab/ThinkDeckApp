@extends('layouts.app')

@section('content')
<div class="bg-[#FFFDE7] min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-sm border border-[#f5f5c633] p-8">
            <div class="mb-6 text-center">
                <a href="{{ route('welcome') }}" class="inline-flex items-center justify-center">
                    <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="ml-2 text-xl font-bold">ThinkDeck</span>
                </a>
            </div>
            
            @yield('auth-content')
        </div>
        
        @hasSection('footer-text')
            <div class="mt-6 text-center text-xs text-gray-500">
                @yield('footer-text')
            </div>
        @endif
    </div>
</div>
@endsection