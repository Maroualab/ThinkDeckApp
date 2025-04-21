<div class="flex items-center text-sm text-gray-500 mb-4 overflow-x-auto">
    <a href="{{ route('dashboard') }}" class="hover:text-gray-700">Dashboard</a>
    
    @if(isset($resourceType))
        <span class="mx-2">/</span>
        <a href="{{ route($resourceType . '.index') }}" class="hover:text-gray-700">{{ ucfirst($resourceType) }}</a>
    @endif
    
    @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
        @foreach($breadcrumbs as $crumb)
            <span class="mx-2">/</span>
            <a href="{{ route($resourceType . '.show', $crumb) }}" class="hover:text-gray-700 truncate max-w-xs">
                {{ $crumb->title }}
            </a>
        @endforeach
    @endif
    
    @if(isset($current))
        <span class="mx-2">/</span>
        <span class="text-gray-700 truncate max-w-xs">{{ $current }}</span>
    @endif
</div>