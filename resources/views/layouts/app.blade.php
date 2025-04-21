<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ThinkDeck')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }
        .text-notion {
            color: rgba(55, 53, 47, 0.65);
        }
        .text-notion-dark {
            color: rgba(55, 53, 47, 0.9);
        }
        .page-tree-item {
            transition: all 0.2s;
            border-radius: 3px;
        }
        .page-tree-item:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .child-pages {
            margin-left: 24px;
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 180px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
            z-index: 1;
            border-radius: 4px;
            border: 1px solid #eaeaea;
        }
        .dropdown-content a, .dropdown-content button {
            display: flex;
            align-items: center;
            padding: 10px 12px;
            text-decoration: none;
            color: #37352f;
            transition: background-color 0.2s;
            font-size: 0.875rem;
        }
        .dropdown-content a:hover, .dropdown-content button:hover {
            background-color: #f5f5f5;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        @yield('additional-styles')
    </style>
</head>
<body class="bg-white text-gray-900 min-h-screen">
    @yield('content')
    
    @stack('scripts')
</body>
</html>