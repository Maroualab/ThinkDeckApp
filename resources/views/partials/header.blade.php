<div class="flex items-center mb-6">
    <a href="{{ $backUrl ?? route('dashboard') }}" class="text-gray-500 hover:text-gray-700 mr-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
    </a>
    <h1 class="text-2xl font-bold flex-1">{{ $title }}</h1>
    
    <div class="flex space-x-2">
        @isset($actions)
            {!! $actions !!}
        @endisset
    </div>
</div>