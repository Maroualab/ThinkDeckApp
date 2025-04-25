@extends('layouts.app')

@section('additional-styles')
    <style>
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
    </style>
@endsection

@section('content')
    <div class="flex overflow-hidden">
        @include('partials.sidebar')

        <div class="flex-1 transition-all duration-300 flex flex-col" id="main-content">
            <!-- Top navigation -->
            @include('partials.topnav')

            <!-- Main content -->
            <main class="flex-1 overflow-y-auto bg-gray-50  p-4 sm:p-6 lg:p-8">
                <!-- Include flash messages once, here -->
                @include('partials.flash-messages')

                <!-- Then yield content -->
                @yield('dashboard-content')
            </main>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const profileButton = document.getElementById('profileButton');
            const profileMenu = document.getElementById('profileMenu');
            const toggleSidebar = document.getElementById('toggleSidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');

            // Profile menu toggle
            if (profileButton && profileMenu) {
                profileButton.addEventListener('click', function () {
                    profileMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', function (event) {
                    if (!profileButton.contains(event.target) && !profileMenu.contains(event.target)) {
                        profileMenu.classList.add('hidden');
                    }
                });
            }

            // Sidebar toggle functionality
            function toggleSidebarVisibility() {
                if (sidebar) {
                    sidebar.classList.toggle('translate-x-[-260px]');
                    updateMainContentMargin();
                }
            }

            function updateMainContentMargin() {
                if (sidebar && mainContent) {
                    if (!sidebar.classList.contains('translate-x-[-260px]')) {
                        mainContent.classList.add('ml-sidebar');
                    } else {
                        mainContent.classList.remove('ml-sidebar');
                    }
                }
            }

            if (toggleSidebar) toggleSidebar.addEventListener('click', toggleSidebarVisibility);
            if (sidebarToggle) sidebarToggle.addEventListener('click', toggleSidebarVisibility);

            // Responsive behavior
            function checkScreenSize() {
                if (sidebar && mainContent) {
                    if (window.innerWidth < 768) {
                        sidebar.classList.add('translate-x-[-260px]');
                    } else {
                        sidebar.classList.remove('translate-x-[-260px]');
                    }
                    updateMainContentMargin();
                }
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

            if (pagesDropdownBtn && pagesDropdownContent && pagesDropdownIcon) {
                pagesDropdownBtn.addEventListener('click', function () {
                    pagesDropdownContent.classList.toggle('hidden');
                    pagesDropdownIcon.classList.toggle('rotate-180');
                });
            }

            if (notesDropdownBtn && notesDropdownContent && notesDropdownIcon) {
                notesDropdownBtn.addEventListener('click', function () {
                    notesDropdownContent.classList.toggle('hidden');
                    notesDropdownIcon.classList.toggle('rotate-180');
                });
            }

            // Icon selector functionality
            const iconSelector = document.getElementById('iconSelector');
            const selectedIcon = document.getElementById('selectedIcon');

            if (iconSelector && selectedIcon) {
                // List of icons
                const icons = ['📄', '📝', '📌', '📎', '📊', '📈', '📉', '📑', '📋', '📃', '📜', '📚', '📔', '📕', '📖', '📗', '📘', '📙', '🗒️', '🗓️', '📆'];

                // Function to create the popup
                function createIconPickerPopup() {
                    // Create the popup overlay
                    const popup = document.createElement('div');
                    popup.className = 'fixed top-0 left-0 w-full h-full bg-black bg-opacity-30 flex justify-center items-center z-50';

                    // Create the content container
                    const container = document.createElement('div');
                    container.className = 'bg-white rounded-lg shadow-xl p-4 max-w-md w-full max-h-[80vh] overflow-y-auto';

                    // Add header
                    const header = document.createElement('div');
                    header.className = 'flex justify-between items-center mb-4';
                    header.innerHTML = `
                        <h3 class="text-lg font-medium">Select an icon</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-500 close-popup">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    `;

                    // Add grid of icons
                    const iconGrid = document.createElement('div');
                    iconGrid.className = 'grid grid-cols-8 gap-2';

                    icons.forEach(icon => {
                        const iconButton = document.createElement('button');
                        iconButton.type = 'button';
                        iconButton.className = 'w-8 h-8 flex items-center justify-center text-lg hover:bg-gray-100 rounded';
                        iconButton.textContent = icon;

                        // Handle icon selection
                        iconButton.addEventListener('click', () => {
                            selectedIcon.value = icon;
                            iconSelector.textContent = icon;
                            closePopup(popup);
                        });

                        iconGrid.appendChild(iconButton);
                    });

                    // Assemble the popup
                    container.appendChild(header);
                    container.appendChild(iconGrid);
                    popup.appendChild(container);

                    // Close popup when clicking outside or on the close button
                    popup.addEventListener('click', (e) => {
                        if (e.target === popup || e.target.closest('.close-popup')) {
                            closePopup(popup);
                        }
                    });

                    return popup;
                }

                // Function to close the popup
                function closePopup(popup) {
                    if (popup && popup.parentNode) {
                        popup.parentNode.removeChild(popup);
                    }
                }

                // Show the popup when the iconSelector is clicked
                iconSelector.addEventListener('click', function () {
                    const popup = createIconPickerPopup();
                    document.body.appendChild(popup);
                });
            }
            
            // Profile menu arrow functionality
            const arrow = document.getElementById('profileMenuArrow');
            const dropdown = document.getElementById('profileMenuDropdown');
            const profileMenuBtn = document.getElementById('profileMenuBtn');

            if (arrow && dropdown && profileMenuBtn) {
                // Toggle dropdown when the arrow is clicked
                profileMenuBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('hidden');
                    arrow.querySelector('svg')?.classList.toggle('rotate-180');
                });

                // Prevent dropdown from closing when clicked inside
                dropdown.addEventListener('click', function (e) {
                    e.stopPropagation();
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function () {
                    dropdown.classList.add('hidden');
                    arrow.querySelector('svg')?.classList.remove('rotate-180');
                });
            }

            // Import modal functionality
            const importButton = document.getElementById('importButton');
            const importModal = document.getElementById('importModal');
            const closeImportModal = document.getElementById('closeImportModal');
            
            if (importButton && importModal && closeImportModal) {
                importButton.addEventListener('click', function() {
                    importModal.classList.remove('hidden');
                });
                
                closeImportModal.addEventListener('click', function() {
                    importModal.classList.add('hidden');
                });
                
                // Close modal when clicking outside
                importModal.addEventListener('click', function(e) {
                    if (e.target === importModal) {
                        importModal.classList.add('hidden');
                    }
                });
            }
        });
    </script>

@endsection