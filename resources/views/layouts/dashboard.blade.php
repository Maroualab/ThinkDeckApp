@extends('layouts.app')

@section('additional-styles')
.notion-sidebar {
    width: 260px;
    transition: all 0.2s;
}
.notion-hover:hover {
    background-color: rgba(0, 0, 0, 0.05);
}
.ml-sidebar {
    margin-left: 260px;
}
.page-icon {
    opacity: 0.8;
    font-size: 1.1rem;
}
@endsection

@section('content')
<div class="flex overflow-hidden">
    @include('partials.sidebar')

    <div class="flex-1 transition-all duration-300 flex flex-col" id="main-content">
        <!-- Top navigation -->
        @include('partials.topnav')
        
        <!-- Main content -->
        <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-900 p-4 sm:p-6 lg:p-8">
            <!-- Include flash messages once, here -->
            @include('partials.flash-messages')
            
            <!-- Then yield content -->
            @yield('dashboard-content')
        </main>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const profileButton = document.getElementById('profileButton');
        const profileMenu = document.getElementById('profileMenu');
        const toggleSidebar = document.getElementById('toggleSidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');

        // Profile menu toggle
        profileButton?.addEventListener('click', function () {
            profileMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', function (event) {
            if (profileButton && !profileButton.contains(event.target) && 
                profileMenu && !profileMenu.contains(event.target)) {
                profileMenu.classList.add('hidden');
            }
        });
        
        // Sidebar toggle functionality
        function toggleSidebarVisibility() {
            sidebar.classList.toggle('translate-x-[-260px]');
            updateMainContentMargin();
        }

        function updateMainContentMargin() {
            if (!sidebar.classList.contains('translate-x-[-260px]')) {
                mainContent.classList.add('ml-sidebar');
            } else {
                mainContent.classList.remove('ml-sidebar');
            }
        }

        toggleSidebar?.addEventListener('click', toggleSidebarVisibility);
        sidebarToggle?.addEventListener('click', toggleSidebarVisibility);

        // Responsive behavior
        function checkScreenSize() {
            if (window.innerWidth < 768) {
                sidebar.classList.add('translate-x-[-260px]');
            } else {
                sidebar.classList.remove('translate-x-[-260px]');
            }
            updateMainContentMargin();
        }
        
        window.addEventListener('resize', checkScreenSize);
        checkScreenSize();

        // Dropdown toggles
        const pagesDropdownBtn = document.getElementById('pagesDropdownBtn');
        const pagesDropdownContent = document.getElementById('pagesDropdownContent');
        const pagesDropdownIcon = document.getElementById('pagesDropdownIcon');
        
        const notesDropdownBtn = document.getElementById('notesDropdownBtn');
        const notesDropdownContent = document.getElementById('notesDropdownContent');
        const notesDropdownIcon = document.getElementById('notesDropdownIcon');

        pagesDropdownBtn?.addEventListener('click', function() {
            pagesDropdownContent.classList.toggle('hidden');
            pagesDropdownIcon.classList.toggle('rotate-180');
        });

        notesDropdownBtn?.addEventListener('click', function() {
            notesDropdownContent.classList.toggle('hidden');
            notesDropdownIcon.classList.toggle('rotate-180');
        });
    });
</script>
@endpush
@endsection