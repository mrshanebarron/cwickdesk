<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tickets - IT Help Desk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white border-b border-slate-200">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">IT Help Desk</h1>
                        <p class="text-xs text-slate-600">Support Portal</p>
                    </div>
                </a>
                <div class="flex items-center space-x-4">
                    @if(Auth::user()->hasAnyRole(['admin', 'agent', 'super_admin']))
                        <a href="/admin" class="flex items-center space-x-2 px-3 py-2 bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold rounded-lg transition-colors shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Admin Panel</span>
                        </a>
                    @endif
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-amber-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span class="text-sm text-slate-700">{{ Auth::user()->name }}</span>
                    </div>
                    <form action="{{ route('portal.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-slate-600 hover:text-amber-600 transition-colors">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-12">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-2">My Tickets</h2>
                    <p class="text-slate-600">View and track all your support requests</p>
                </div>
                <a href="{{ route('portal.submit') }}" class="px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    New Ticket
                </a>
            </div>
        </div>

        <!-- Tickets List -->
        <div class="space-y-4">
            @forelse($tickets as $ticket)
                <a href="{{ route('portal.ticket.lookup', ['ticket_number' => $ticket->ticket_number]) }}" class="block bg-white rounded-xl shadow hover:shadow-lg transition-shadow p-6">
                    <div class="flex items-start justify-between">
                        <!-- Ticket Info -->
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <span class="text-sm font-semibold text-slate-600 mr-3">{{ $ticket->ticket_number }}</span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                    @if($ticket->status->is_resolved) bg-green-100 text-green-800
                                    @elseif($ticket->status->is_closed) bg-slate-100 text-slate-800
                                    @else bg-blue-100 text-blue-800
                                    @endif">
                                    {{ $ticket->status->name }}
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium ml-2
                                    @if($ticket->priority->name === 'Critical') bg-red-100 text-red-800
                                    @elseif($ticket->priority->name === 'High') bg-orange-100 text-orange-800
                                    @elseif($ticket->priority->name === 'Medium') bg-yellow-100 text-yellow-800
                                    @else bg-blue-100 text-blue-800
                                    @endif">
                                    {{ $ticket->priority->name }}
                                </span>
                            </div>

                            <h3 class="text-lg font-semibold text-slate-900 mb-2">{{ $ticket->subject }}</h3>

                            <p class="text-slate-600 mb-3 line-clamp-2">{{ Str::limit($ticket->description, 200) }}</p>

                            <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Created {{ $ticket->created_at->diffForHumans() }}
                                </span>

                                @if($ticket->assignedTo)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Assigned to {{ $ticket->assignedTo->name }}
                                    </span>
                                @else
                                    <span class="flex items-center text-slate-400">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Not yet assigned
                                    </span>
                                @endif

                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Updated {{ $ticket->updated_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>

                        <!-- Arrow Icon -->
                        <div class="ml-4 flex-shrink-0">
                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            @empty
                <!-- No Tickets -->
                <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">No Tickets Yet</h3>
                    <p class="text-slate-600 mb-6">You haven't submitted any support tickets. When you need help, create a ticket and track it here.</p>
                    <a href="{{ route('portal.submit') }}" class="inline-flex items-center px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Submit Your First Ticket
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($tickets->hasPages())
            <div class="mt-8">
                {{ $tickets->links() }}
            </div>
        @endif

        <!-- Back to Portal -->
        <div class="mt-12 text-center">
            <a href="/" class="inline-flex items-center text-slate-600 hover:text-amber-600 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Portal Home
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-16 py-6 border-t border-slate-200">
        <div class="container mx-auto px-4 text-center text-sm text-slate-600">
            <p>IT Help Desk Portal &copy; 2025 &bull; Available 24/7</p>
        </div>
    </footer>
</body>
</html>
