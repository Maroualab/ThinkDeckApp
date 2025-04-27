@extends('layouts.admin')

@section('title', 'Platform Settings - ThinkDeck')

@section('content')
<div class="w-full max-w-7xl mx-auto">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
        <div class="p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-2xl font-bold text-gray-800 mb-1">Platform Settings</h1>
                    <p class="text-gray-600">Configure your ThinkDeck platform settings</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Form -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-5 border-b border-gray-200">
                    <h2 class="text-lg font-medium">Setting Categories</h2>
                </div>
                <div class="divide-y divide-gray-100">
                    <a href="#general" class="p-4 flex items-center hover:bg-gray-50 transition cursor-pointer">
                        <svg class="w-5 h-5 text-indigo-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        General Settings
                    </a>
                    <a href="#branding" class="p-4 flex items-center hover:bg-gray-50 transition cursor-pointer">
                        <svg class="w-5 h-5 text-indigo-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Branding
                    </a>
                    <a href="#email" class="p-4 flex items-center hover:bg-gray-50 transition cursor-pointer">
                        <svg class="w-5 h-5 text-indigo-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Email Configuration
                    </a>
                    <a href="#security" class="p-4 flex items-center hover:bg-gray-50 transition cursor-pointer">
                        <svg class="w-5 h-5 text-indigo-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Security
                    </a>
                    <a href="#api" class="p-4 flex items-center hover:bg-gray-50 transition cursor-pointer">
                        <svg class="w-5 h-5 text-indigo-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                        API Settings
                    </a>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <!-- General Settings -->
            <div id="general" class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
                <div class="p-5 border-b border-gray-200">
                    <h2 class="text-lg font-medium flex items-center">
                        <svg class="w-5 h-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        General Settings
                    </h2>
                </div>
                <div class="p-5">
                    <form method="POST" action="#">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="site_name" class="block text-sm font-medium text-gray-700 mb-1">Site Name</label>
                                <input type="text" name="site_name" id="site_name" value="{{ $settings['site_name'] ?? 'ThinkDeck' }}" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            
                            <div>
                                <label for="site_description" class="block text-sm font-medium text-gray-700 mb-1">Site Description</label>
                                <textarea name="site_description" id="site_description" rows="3" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $settings['site_description'] ?? 'Your platform for creating and sharing flash cards and decks' }}</textarea>
                            </div>
                            
                            <div>
                                <label for="pagination" class="block text-sm font-medium text-gray-700 mb-1">Items Per Page</label>
                                <select name="pagination" id="pagination" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="10" {{ ($settings['pagination'] ?? 10) == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ ($settings['pagination'] ?? 10) == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ ($settings['pagination'] ?? 10) == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ ($settings['pagination'] ?? 10) == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                            
                            <div class="flex items-center">
                                <input type="checkbox" name="enable_registration" id="enable_registration" 
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                    {{ ($settings['enable_registration'] ?? true) ? 'checked' : '' }}>
                                <label for="enable_registration" class="ml-2 block text-sm text-gray-700">
                                    Allow new user registration
                                </label>
                            </div>
                            
                            <div class="pt-4">
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Save General Settings
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Branding Settings -->
            <div id="branding" class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
                <div class="p-5 border-b border-gray-200">
                    <h2 class="text-lg font-medium flex items-center">
                        <svg class="w-5 h-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Branding
                    </h2>
                </div>
                <div class="p-5">
                    <form method="POST" action="#" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12 rounded border border-gray-200 bg-gray-100 flex items-center justify-center">
                                        @if(isset($settings['logo_path']))
                                            <img src="{{ asset($settings['logo_path']) }}" alt="Logo" class="h-10 w-10 object-contain">
                                        @else
                                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="ml-5">
                                        <input type="file" name="logo" id="logo" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Favicon</label>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12 rounded border border-gray-200 bg-gray-100 flex items-center justify-center">
                                        @if(isset($settings['favicon_path']))
                                            <img src="{{ asset($settings['favicon_path']) }}" alt="Favicon" class="h-8 w-8 object-contain">
                                        @else
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="ml-5">
                                        <input type="file" name="favicon" id="favicon" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <label for="primary_color" class="block text-sm font-medium text-gray-700 mb-1">Primary Color</label>
                                <div class="flex items-center">
                                    <input type="color" name="primary_color" id="primary_color" value="{{ $settings['primary_color'] ?? '#4f46e5' }}" 
                                        class="h-8 w-8 rounded-md border-gray-300 shadow-sm">
                                    <input type="text" name="primary_color_text" id="primary_color_text" value="{{ $settings['primary_color'] ?? '#4f46e5' }}" 
                                        class="ml-3 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                            
                            <div>
                                <label for="footer_text" class="block text-sm font-medium text-gray-700 mb-1">Footer Text</label>
                                <input type="text" name="footer_text" id="footer_text" value="{{ $settings['footer_text'] ?? '© ' . date('Y') . ' ThinkDeck. All rights reserved.' }}" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            
                            <div class="pt-4">
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Save Branding Settings
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Email Configuration -->
            <div id="email" class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
                <div class="p-5 border-b border-gray-200">
                    <h2 class="text-lg font-medium flex items-center">
                        <svg class="w-5 h-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Email Configuration
                    </h2>
                </div>
                <div class="p-5">
                    <form method="POST" action="#">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="mail_driver" class="block text-sm font-medium text-gray-700 mb-1">Mail Driver</label>
                                <select name="mail_driver" id="mail_driver" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="smtp" {{ ($settings['mail_driver'] ?? 'smtp') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                                    <option value="sendmail" {{ ($settings['mail_driver'] ?? 'smtp') == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                                    <option value="mailgun" {{ ($settings['mail_driver'] ?? 'smtp') == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="mail_host" class="block text-sm font-medium text-gray-700 mb-1">Mail Host</label>
                                <input type="text" name="mail_host" id="mail_host" value="{{ $settings['mail_host'] ?? 'smtp.mailtrap.io' }}" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            
                            <div>
                                <label for="mail_port" class="block text-sm font-medium text-gray-700 mb-1">Mail Port</label>
                                <input type="text" name="mail_port" id="mail_port" value="{{ $settings['mail_port'] ?? '2525' }}" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            
                            <div>
                                <label for="mail_username" class="block text-sm font-medium text-gray-700 mb-1">Mail Username</label>
                                <input type="text" name="mail_username" id="mail_username" value="{{ $settings['mail_username'] ?? '' }}" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            
                            <div>
                                <label for="mail_password" class="block text-sm font-medium text-gray-700 mb-1">Mail Password</label>
                                <input type="password" name="mail_password" id="mail_password" value="{{ $settings['mail_password'] ?? '' }}" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            
                            <div>
                                <label for="mail_encryption" class="block text-sm font-medium text-gray-700 mb-1">Mail Encryption</label>
                                <select name="mail_encryption" id="mail_encryption" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="tls" {{ ($settings['mail_encryption'] ?? 'tls') == 'tls' ? 'selected' : '' }}>TLS</option>
                                    <option value="ssl" {{ ($settings['mail_encryption'] ?? 'tls') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                    <option value="none" {{ ($settings['mail_encryption'] ?? 'tls') == 'none' ? 'selected' : '' }}>None</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="mail_from_address" class="block text-sm font-medium text-gray-700 mb-1">From Email Address</label>
                                <input type="email" name="mail_from_address" id="mail_from_address" value="{{ $settings['mail_from_address'] ?? 'info@thinkdeck.com' }}" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            
                            <div>
                                <label for="mail_from_name" class="block text-sm font-medium text-gray-700 mb-1">From Name</label>
                                <input type="text" name="mail_from_name" id="mail_from_name" value="{{ $settings['mail_from_name'] ?? 'ThinkDeck' }}" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            
                            <div class="pt-4 flex justify-between">
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Save Email Settings
                                </button>
                                <button type="button" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    Test Email Configuration
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Handle color picker synchronization
    document.addEventListener('DOMContentLoaded', function() {
        const colorPicker = document.getElementById('primary_color');
        const colorText = document.getElementById('primary_color_text');
        
        colorPicker.addEventListener('input', function() {
            colorText.value = this.value;
        });
        
        colorText.addEventListener('input', function() {
            colorPicker.value = this.value;
        });
    });
</script>
@endpush