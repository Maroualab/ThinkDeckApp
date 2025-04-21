@extends('layouts.app')

@section('title', 'ThinkDeck - Home')

@section('additional-styles')
.hero-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.feature-card {
    transition: all 0.3s ease;
}
.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}
@endsection

@section('content')
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <svg class="w-8 h-8 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="ml-2 text-xl font-semibold text-notion-dark">ThinkDeck</span>
                </div>
              
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-indigo-100 text-indigo-700 rounded-md hover:bg-indigo-200 transition-all">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-notion-dark hover:text-indigo-700">Log in</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-all">Sign up</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero section -->
        <section class="hero-gradient text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-10 md:mb-0">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">Your second brain for notes and ideas</h1>
                <p class="text-xl mb-8 opacity-90">ThinkDeck helps you organize your thoughts, notes, and documents in one place, making knowledge management effortless.</p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('register') }}" class="px-6 py-3 bg-white text-indigo-700 rounded-md font-medium hover:bg-indigo-50 transition-all text-center">Get Started for Free</a>
                    <a href="#features" class="px-6 py-3 bg-indigo-700 text-white border border-indigo-300 rounded-md font-medium hover:bg-indigo-800 transition-all text-center">Learn More</a>
                </div>
                </div>
                <div class="md:w-1/2 md:pl-10 h-64 md:h-96">
                <iframe style="width:100%; height:100%; border:none;" src="https://lottie.host/embed/c4359d0d-d584-48ba-9ff2-bb9380f4a43f/OLOBrcJa0l.lottie"></iframe>
                </div>
            </div>
            </div>
        </section>

        <!-- Features section -->
        <section id="features" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-notion-dark">Everything you need in one place</h2>
                    <p class="mt-4 text-xl text-notion max-w-2xl mx-auto">ThinkDeck combines the best features from note-taking, document editors, and knowledge bases.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 feature-card">
                        <div class="text-3xl mb-4">📝</div>
                        <h3 class="text-xl font-semibold mb-3 text-notion-dark">Smart Notes</h3>
                        <p class="text-notion">Take rich notes with our powerful editor that supports markdown, code blocks, and media embeds.</p>
                    </div>

                    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 feature-card">
                        <div class="text-3xl mb-4">📚</div>
                        <h3 class="text-xl font-semibold mb-3 text-notion-dark">Organized Pages</h3>
                        <p class="text-notion">Create nested pages to organize your work, projects, and knowledge bases with ease.</p>
                    </div>

                    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 feature-card">
                        <div class="text-3xl mb-4">🔄</div>
                        <h3 class="text-xl font-semibold mb-3 text-notion-dark">Seamless Sync</h3>
                        <p class="text-notion">All your notes and documents are automatically synchronized across all your devices.</p>
                    </div>

                    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 feature-card">
                        <div class="text-3xl mb-4">🔍</div>
                        <h3 class="text-xl font-semibold mb-3 text-notion-dark">Powerful Search</h3>
                        <p class="text-notion">Find anything instantly with our lightning-fast search that indexes all your content.</p>
                    </div>

                    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 feature-card">
                        <div class="text-3xl mb-4">👥</div>
                        <h3 class="text-xl font-semibold mb-3 text-notion-dark">Collaboration</h3>
                        <p class="text-notion">Share and collaborate on your documents with teammates in real-time.</p>
                    </div>

                    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 feature-card">
                        <div class="text-3xl mb-4">🔒</div>
                        <h3 class="text-xl font-semibold mb-3 text-notion-dark">Secure Storage</h3>
                        <p class="text-notion">Your data is encrypted and securely stored. You're always in control of your information.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- How it works section -->
        <section id="how-it-works" class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-notion-dark">How ThinkDeck works</h2>
                    <p class="mt-4 text-xl text-notion max-w-2xl mx-auto">Start organizing your thoughts in minutes with our intuitive platform.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <div class="flex flex-col items-center text-center">
                        <div class="bg-indigo-100 text-indigo-700 w-16 h-16 rounded-full flex items-center justify-center text-xl font-bold mb-6">1</div>
                        <h3 class="text-xl font-semibold mb-3 text-notion-dark">Sign up for free</h3>
                        <p class="text-notion">Create your account in seconds and get immediate access to all features.</p>
                    </div>

                    <div class="flex flex-col items-center text-center">
                        <div class="bg-indigo-100 text-indigo-700 w-16 h-16 rounded-full flex items-center justify-center text-xl font-bold mb-6">2</div>
                        <h3 class="text-xl font-semibold mb-3 text-notion-dark">Create your first note</h3>
                        <p class="text-notion">Use our intuitive editor to capture your ideas, tasks, or knowledge.</p>
                    </div>

                    <div class="flex flex-col items-center text-center">
                        <div class="bg-indigo-100 text-indigo-700 w-16 h-16 rounded-full flex items-center justify-center text-xl font-bold mb-6">3</div>
                        <h3 class="text-xl font-semibold mb-3 text-notion-dark">Organize and expand</h3>
                        <p class="text-notion">Build your personal knowledge base by creating pages and connecting your ideas.</p>
                    </div>
                </div>
            </div>
        </section>

       
        <!-- CTA section -->
        <section class="py-20">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl shadow-lg text-white p-12">
            <div class="text-center">
                <h2 class="text-3xl font-bold mb-6">Ready to organize your thoughts?</h2>
                <p class="text-xl mb-8 opacity-90 max-w-2xl mx-auto">Join thousands of users who are already using ThinkDeck to boost their productivity and organize their knowledge.</p>
                
                @auth
                <div class="flex justify-center">
                    <a href="{{ route('dashboard') }}" class="px-8 py-3 bg-white text-indigo-700 rounded-md font-medium hover:bg-indigo-50 transition-all">Go to Dashboard</a>
                </div>
                @else
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 justify-center">
                    <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-indigo-700 rounded-md font-medium hover:bg-indigo-50 transition-all">Get Started for Free</a>
                    <a href="#" class="px-8 py-3 bg-indigo-700 text-white border border-indigo-300 rounded-md font-medium hover:bg-indigo-800 transition-all">Schedule a Demo</a>
                </div>
                @endauth
            </div>
            </div>
        </section>
    </main>
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Top section with logo and newsletter -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 pb-12 border-b border-gray-700">
                <div>
                    <div class="flex items-center mb-6">
                        <svg class="w-8 h-8 text-indigo-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="ml-2 text-xl font-bold">ThinkDeck</span>
                    </div>
                    <p class="text-gray-400 mb-6 max-w-md">Organize your thoughts, notes, and documents in one place, making knowledge management effortless.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <span class="sr-only">GitHub</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <span class="sr-only">LinkedIn</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Stay up to date</h3>
                    <p class="text-gray-400 mb-4">Subscribe to our newsletter for the latest updates and features.</p>
                    <form class="flex flex-col sm:flex-row gap-2"></form>
                        <input type="email" placeholder="Enter your email" class="px-4 py-2 bg-gray-800 text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 flex-grow">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors whitespace-nowrap">Subscribe</button>
                    </form>
                </div>
            </div>

            <!-- Middle section with links -->
            <div class="py-12">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-sm font-semibold text-indigo-400 uppercase tracking-wider mb-4">Product</h3>
                        <ul class="space-y-3">
                            <li><a href="#features" class="text-gray-400 hover:text-white transition-colors">Features</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Templates</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Security</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Pricing</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-indigo-400 uppercase tracking-wider mb-4">Company</h3>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">About</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Blog</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Careers</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-indigo-400 uppercase tracking-wider mb-4">Resources</h3>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Documentation</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">API</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Community</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Guides</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-indigo-400 uppercase tracking-wider mb-4">Legal</h3>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Terms</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Cookie Policy</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">GDPR</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Bottom section with copyright and app store links -->
            <div class="pt-8 border-t border-gray-700 flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-400">&copy; {{ date('Y') }} ThinkDeck. All rights reserved.</div>
                <div class="flex flex-col sm:flex-row items-center gap-4 mt-6 md:mt-0">
                    <div class="text-sm text-gray-400">Available on:</div>
                    <div class="flex space-x-4">
                        <a href="#" class="flex items-center bg-gray-800 hover:bg-gray-700 transition-colors px-3 py-2 rounded-md">
                            <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M17.164 5.442c-1.842-2.008-4.542-1.983-5.164-1.983-2.193 0-4.265 1.309-4.84 1.309-.6 0-2.44-1.268-4.018-1.268-3.206 0-6.337 2.642-6.337 6.911 0 2.286.736 4.706 2.047 6.708 1.464 2.215 2.976 3.724 4.746 3.724 1.77 0 2.799-1.154 4.482-1.154 1.77 0 2.8 1.153 4.661 1.153 1.862 0 3.187-1.6 4.742-3.94 1.555-2.34 1.555-2.616 1.555-2.708-.092-.092-4.111-1.693-4.111-6.03 0-3.262 2.983-4.857 3.237-4.722z"/></svg>
                            App Store
                        </a>
                        <a href="#" class="flex items-center bg-gray-800 hover:bg-gray-700 transition-colors px-3 py-2 rounded-md">
                            <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M3 20.907v-17.867c0-1.758 1.44-2.731 2.87-2.04l.016.007 16.039 9.042c1.327.651 1.327 2.532 0 3.183l-16.039 9.042c-1.43.744-2.886-.282-2.886-2.04v-.327z"/></svg>
                            Google Play
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer></a>
@endsection