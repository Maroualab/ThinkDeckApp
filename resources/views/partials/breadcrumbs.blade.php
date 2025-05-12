<div class="flex items-center text-sm text-gray-500 mb-4 overflow-x-auto pt-[30px] pt-6">
    <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>

    {{-- This part can stay if needed for index pages --}}
    @if(isset($resourceType))
        <span class="mx-2">/</span>
        <a href="{{ route($resourceType . '.index') }}" class="hover:text-gray-700">{{ ucfirst($resourceType) }}</a>
    @endif

    {{-- Modified breadcrumbs loop --}}
    @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
        @foreach($breadcrumbs as $crumb)
            <span class="mx-2">/</span>
            {{-- Check if a URL is provided for this crumb --}}
            @if(isset($crumb['url']))
                <a href="{{ $crumb['url'] }}" class="hover:text-gray-700 truncate max-w-xs">
                    {{ $crumb['name'] }}
                </a>
            @else
                {{-- If no URL, just display the name as text --}}
                <span class="text-gray-700 truncate max-w-xs">{{ $crumb['name'] }}</span>
            @endif
        @endforeach
    @endif

    {{-- This part can stay if needed for a final current item --}}
    @if(isset($current))
        <span class="mx-2">/</span>
        <span class="text-gray-700 truncate max-w-xs">{{ $current }}</span>
    @endif
</div>