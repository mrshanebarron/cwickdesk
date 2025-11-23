<!DOCTYPE html>
<html lang="en" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'IT Help Desk Portal') - CwickDesk</title>

    {{-- Theme initialization script - MUST run before any styles --}}
    <script>
        // Initialize theme immediately - before any rendering
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'light') {
            document.documentElement.classList.remove('dark');
            document.documentElement.classList.add('light');
        } else {
            // Default to dark, ensure dark class is present
            document.documentElement.classList.add('dark');
            if (!savedTheme) {
                localStorage.setItem('theme', 'dark');
            }
        }
    </script>

    @vite(['resources/css/public.css'])

    @stack('styles')
</head>
<body class="antialiased transition-colors duration-200 bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-white">
    {{-- Header with Theme Toggle --}}
    <header class="border-b border-slate-200 dark:border-white/10 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                {{-- Logo --}}
                <a href="/" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-display text-xl text-slate-900 dark:text-white">IT Help Desk</div>
                        <div class="text-xs text-slate-600 dark:text-slate-400">Support Portal</div>
                    </div>
                </a>

                {{-- Navigation --}}
                <div class="flex items-center space-x-4">
                    {{-- Theme Toggle --}}
                    <button
                        id="theme-toggle"
                        class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors"
                        aria-label="Toggle theme"
                    >
                        <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    {{-- User Menu --}}
                    @auth
                        <div class="flex items-center space-x-4">
                            @if(Auth::user()->hasAnyRole(['admin', 'agent', 'super_admin']))
                                <a href="/admin" class="flex items-center space-x-2 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span>Admin Panel</span>
                                </a>
                            @endif
                            <span class="text-sm text-slate-700 dark:text-slate-300">{{ Auth::user()->name }}</span>
                            <form action="{{ route('portal.logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-sm text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('portal.login') }}" class="text-sm text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                                Login
                            </a>
                            <a href="{{ route('portal.register') }}" class="btn-primary text-sm">
                                Sign Up
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="mt-16 py-6 border-t border-slate-200 dark:border-white/10">
        <div class="container mx-auto px-4 text-center text-sm text-slate-600 dark:text-slate-400">
            <p>IT Help Desk Portal &copy; 2025 &bull; Available 24/7</p>
        </div>
    </footer>

    {{-- Theme Toggle Script --}}
    <script>
        // Theme toggle functionality
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        // Get current theme from localStorage or default to dark
        let currentTheme = localStorage.getItem('theme') || 'dark';

        // Update icon visibility based on current theme
        function updateThemeIcon() {
            if (currentTheme === 'dark') {
                themeToggleLightIcon.classList.remove('hidden');
                themeToggleDarkIcon.classList.add('hidden');
            } else {
                themeToggleDarkIcon.classList.remove('hidden');
                themeToggleLightIcon.classList.add('hidden');
            }
        }

        // Initialize icon on page load
        updateThemeIcon();

        // Toggle theme on button click
        themeToggleBtn.addEventListener('click', function() {
            if (currentTheme === 'dark') {
                currentTheme = 'light';
                document.documentElement.classList.remove('dark');
                document.documentElement.classList.add('light');
            } else {
                currentTheme = 'dark';
                document.documentElement.classList.remove('light');
                document.documentElement.classList.add('dark');
            }

            localStorage.setItem('theme', currentTheme);
            updateThemeIcon();
        });
    </script>

    {{-- Scroll Animation Script --}}
    <script>
        // Intersection Observer for scroll animations
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            const animatedElements = document.querySelectorAll('.animate-on-scroll');
            animatedElements.forEach(el => observer.observe(el));
        });
    </script>

    @stack('scripts')
</body>
</html>
