@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    @include('partials.flash-messages')
    
    @yield('page-content')
</div>
@endsection