@extends('portal.layouts.app')

@section('title', 'IT Help Desk Portal')

@section('content')
<div class="container mx-auto px-4 py-12">
    {{-- Welcome Message --}}
    <div class="text-center mb-12 animate-on-scroll">
        <h2 class="font-display text-4xl sm:text-5xl font-bold mb-4">
            How can we <span class="text-gradient">help</span> you today?
        </h2>
        <p class="text-xl text-slate-600 dark:text-slate-400">Submit a support request or browse our knowledge base</p>
    </div>

    {{-- Quick Actions Grid --}}
    <div class="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto mb-12">
        {{-- Submit Ticket --}}
        <a href="{{ route('portal.submit') }}" class="glass-card rounded-2xl p-8 card-hover group animate-on-scroll">
            <div class="w-16 h-16 bg-blue-500/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <h3 class="font-display text-2xl font-bold mb-2">Submit a Ticket</h3>
            <p class="text-slate-600 dark:text-slate-400 mb-4">
                Report a problem or request IT assistance
            </p>
            <div class="text-blue-400 font-semibold flex items-center">
                Create Request
                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>

        {{-- Browse Knowledge Base --}}
        <a href="{{ route('portal.kb') }}" class="glass-card rounded-2xl p-8 card-hover group animate-on-scroll">
            <div class="w-16 h-16 bg-green-500/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <h3 class="font-display text-2xl font-bold mb-2">Knowledge Base</h3>
            <p class="text-slate-600 dark:text-slate-400 mb-4">
                Search for solutions and how-to guides
            </p>
            <div class="text-green-400 font-semibold flex items-center">
                Browse Articles
                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>

        {{-- My Tickets (Only for authenticated users) --}}
        @auth
            <a href="{{ route('portal.my-tickets') }}" class="glass-card rounded-2xl p-8 card-hover group animate-on-scroll">
                <div class="w-16 h-16 bg-purple-500/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-10 h-10 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="font-display text-2xl font-bold mb-2">My Tickets</h3>
                <p class="text-slate-600 dark:text-slate-400 mb-4">
                    View and track your support requests
                </p>
                <div class="text-purple-400 font-semibold flex items-center">
                    View Tickets
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>
        @endauth
    </div>

    {{-- Ticket Lookup --}}
    <div class="max-w-2xl mx-auto mb-12">
        <div class="glass-card rounded-2xl p-8 animate-on-scroll">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-cyan-500/20 rounded-xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-display text-xl font-bold">Check Ticket Status</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Track your support request</p>
                </div>
            </div>
            <form action="{{ route('portal.ticket.lookup') }}" method="GET" class="flex gap-3">
                <input type="text" name="ticket_number" placeholder="Enter ticket number (e.g., IT-2025-001)"
                       class="flex-1 px-4 py-3 bg-slate-100 dark:bg-slate-900/50 border border-slate-300 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white placeholder-slate-500 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 transition-all">
                <button type="submit" class="btn-primary">
                    Search
                </button>
            </form>
        </div>
    </div>

    {{-- Common Solutions --}}
    <div class="max-w-4xl mx-auto">
        <h3 class="font-display text-3xl font-bold mb-6 text-center">Common Solutions</h3>
        <div class="grid md:grid-cols-2 gap-4">
            @foreach([
                ['Password Reset Instructions', 'How to reset your account password'],
                ['Network Connectivity Issues', 'Troubleshoot WiFi and network problems'],
                ['Software Installation Requests', 'How to request new software'],
                ['Printer Setup & Troubleshooting', 'Connect to network printers']
            ] as $article)
                <a href="{{ route('portal.kb') }}" class="glass-card rounded-xl p-4 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-all group">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-cyan-400 mr-3 mt-0.5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold group-hover:text-cyan-400 transition-colors">{{ $article[0] }}</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">{{ $article[1] }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
