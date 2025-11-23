<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Status - {{ $ticket->ticket_number }}</title>
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
                <a href="/" class="text-sm text-slate-600 hover:text-amber-600 transition-colors">
                    ← Back to Portal
                </a>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-12">
        <div class="max-w-4xl mx-auto">
            <!-- Page Header -->
            <div class="mb-6">
                <h2 class="text-3xl font-bold text-slate-900 mb-2">Ticket Details</h2>
                <p class="text-slate-600">Track the status and progress of your support request</p>
            </div>

            <!-- Ticket Number Badge -->
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-sm text-slate-600 mb-1">Ticket Number</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $ticket->ticket_number }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-slate-600 mb-1">Current Status</p>
                        <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold
                            @if($ticket->status->is_resolved) bg-green-100 text-green-800
                            @elseif($ticket->status->is_closed) bg-slate-100 text-slate-800
                            @else bg-blue-100 text-blue-800
                            @endif">
                            {{ $ticket->status->name }}
                        </span>
                    </div>
                </div>

                <!-- Status Progress Bar -->
                <div class="mb-6">
                    <div class="relative">
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded-full bg-slate-200">
                            <div
                                class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center
                                @if($ticket->status->is_resolved) bg-green-500
                                @elseif($ticket->status->is_closed) bg-slate-500
                                @else bg-blue-500
                                @endif transition-all duration-500"
                                style="width: {{ $ticket->status->is_resolved ? '100' : ($ticket->status->is_closed ? '100' : '50') }}%"
                            ></div>
                        </div>
                    </div>
                    <div class="flex justify-between text-xs text-slate-600">
                        <span class="font-medium text-blue-600">Submitted</span>
                        <span class="@if($ticket->status->is_resolved || $ticket->status->is_closed) font-medium text-green-600 @endif">
                            @if($ticket->status->is_resolved) Resolved @elseif($ticket->status->is_closed) Closed @else In Progress @endif
                        </span>
                    </div>
                </div>

                <!-- Ticket Info Grid -->
                <div class="grid md:grid-cols-2 gap-6 border-t border-slate-200 pt-6">
                    <!-- Subject -->
                    <div class="md:col-span-2">
                        <p class="text-sm text-slate-600 mb-1">Subject</p>
                        <p class="text-lg font-semibold text-slate-900">{{ $ticket->subject }}</p>
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <p class="text-sm text-slate-600 mb-1">Description</p>
                        <p class="text-slate-900 whitespace-pre-line">{{ $ticket->description }}</p>
                    </div>

                    <!-- Priority -->
                    <div>
                        <p class="text-sm text-slate-600 mb-1">Priority</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($ticket->priority->name === 'Critical') bg-red-100 text-red-800
                            @elseif($ticket->priority->name === 'High') bg-orange-100 text-orange-800
                            @elseif($ticket->priority->name === 'Medium') bg-yellow-100 text-yellow-800
                            @else bg-blue-100 text-blue-800
                            @endif">
                            {{ $ticket->priority->name }}
                        </span>
                    </div>

                    <!-- Assigned To -->
                    <div>
                        <p class="text-sm text-slate-600 mb-1">Assigned To</p>
                        @if($ticket->assignedTo)
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-amber-500 rounded-full flex items-center justify-center text-white font-semibold text-sm mr-2">
                                    {{ substr($ticket->assignedTo->name, 0, 1) }}
                                </div>
                                <span class="text-slate-900 font-medium">{{ $ticket->assignedTo->name }}</span>
                            </div>
                        @else
                            <span class="text-slate-500 italic">Not yet assigned</span>
                        @endif
                    </div>

                    <!-- Created -->
                    <div>
                        <p class="text-sm text-slate-600 mb-1">Created</p>
                        <p class="text-slate-900">{{ $ticket->created_at->format('F j, Y \a\t g:i A') }}</p>
                        <p class="text-xs text-slate-500">{{ $ticket->created_at->diffForHumans() }}</p>
                    </div>

                    <!-- Last Updated -->
                    <div>
                        <p class="text-sm text-slate-600 mb-1">Last Updated</p>
                        <p class="text-slate-900">{{ $ticket->updated_at->format('F j, Y \a\t g:i A') }}</p>
                        <p class="text-xs text-slate-500">{{ $ticket->updated_at->diffForHumans() }}</p>
                    </div>

                    <!-- Source -->
                    <div>
                        <p class="text-sm text-slate-600 mb-1">Submitted Via</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                            {{ ucfirst($ticket->source) }}
                        </span>
                    </div>

                    <!-- Requester -->
                    <div>
                        <p class="text-sm text-slate-600 mb-1">Requester</p>
                        <p class="text-slate-900 font-medium">{{ $ticket->requester->name }}</p>
                        <p class="text-xs text-slate-500">{{ $ticket->requester->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Status Message -->
            @if($ticket->status->is_resolved)
                <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-green-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-semibold text-green-900 mb-1">This ticket has been resolved!</h3>
                            <p class="text-green-800">Your issue has been resolved by our support team. If you need further assistance with this issue, please contact us directly.</p>
                        </div>
                    </div>
                </div>
            @elseif($ticket->status->is_closed)
                <div class="bg-slate-50 border border-slate-200 rounded-lg p-6 mb-6">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-slate-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900 mb-1">This ticket has been closed</h3>
                            <p class="text-slate-700">This support request has been closed. If you need to reopen this issue, please contact us directly.</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-semibold text-blue-900 mb-1">Your ticket is being worked on</h3>
                            <p class="text-blue-800">Our support team is actively working on your request. You'll receive email updates as progress is made.</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="grid md:grid-cols-3 gap-4">
                <!-- Submit Another Ticket -->
                <a href="{{ route('portal.submit') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow text-center">
                    <svg class="w-10 h-10 text-blue-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <h3 class="font-semibold text-slate-900 mb-1">New Ticket</h3>
                    <p class="text-sm text-slate-600">Submit another issue</p>
                </a>

                <!-- Browse Knowledge Base -->
                <a href="{{ route('portal.kb') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow text-center">
                    <svg class="w-10 h-10 text-green-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <h3 class="font-semibold text-slate-900 mb-1">Knowledge Base</h3>
                    <p class="text-sm text-slate-600">Find solutions</p>
                </a>

                <!-- Return to Portal -->
                <a href="/" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow text-center">
                    <svg class="w-10 h-10 text-purple-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <h3 class="font-semibold text-slate-900 mb-1">Portal Home</h3>
                    <p class="text-sm text-slate-600">Back to portal</p>
                </a>
            </div>

            <!-- Contact Info -->
            <div class="mt-6 text-center text-sm text-slate-600">
                <p>
                    Need immediate assistance? Call
                    <strong class="text-slate-900">Ext. 4357</strong>
                    or email
                    <a href="mailto:helpdesk@company.com" class="text-amber-600 hover:text-amber-700">helpdesk@company.com</a>
                </p>
            </div>
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
