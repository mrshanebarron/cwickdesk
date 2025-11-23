<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Submitted Successfully - IT Help Desk</title>
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
        <div class="max-w-2xl mx-auto">
            <!-- Success Message -->
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-6">
                <!-- Success Icon -->
                <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>

                <!-- Success Text -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-slate-900 mb-2">Ticket Submitted Successfully!</h2>
                    <p class="text-slate-600">Your support request has been received and assigned to our team.</p>
                </div>

                <!-- Ticket Number -->
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-6 mb-6">
                    <div class="text-center">
                        <p class="text-sm text-slate-600 mb-2">Your Ticket Number</p>
                        <p class="text-3xl font-bold text-amber-600 mb-2">{{ $ticket->ticket_number }}</p>
                        <p class="text-sm text-slate-500">Save this number to check your ticket status</p>
                    </div>
                </div>

                <!-- Ticket Details Summary -->
                <div class="border-t border-slate-200 pt-6 mb-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Ticket Details</h3>

                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-slate-600">Subject</p>
                            <p class="text-slate-900 font-medium">{{ $ticket->subject }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-600">Priority</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($ticket->priority->name === 'Critical') bg-red-100 text-red-800
                                @elseif($ticket->priority->name === 'High') bg-orange-100 text-orange-800
                                @elseif($ticket->priority->name === 'Medium') bg-yellow-100 text-yellow-800
                                @else bg-blue-100 text-blue-800
                                @endif">
                                {{ $ticket->priority->name }}
                            </span>
                        </div>

                        <div>
                            <p class="text-sm text-slate-600">Status</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-slate-100 text-slate-800">
                                {{ $ticket->status->name }}
                            </span>
                        </div>

                        <div>
                            <p class="text-sm text-slate-600">Submitted</p>
                            <p class="text-slate-900">{{ $ticket->created_at->format('F j, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                </div>

                <!-- What Happens Next -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        What Happens Next?
                    </h3>
                    <ul class="space-y-2 text-sm text-slate-700">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span>Your ticket has been assigned to our support team</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span>You'll receive email updates at {{ $ticket->requester->email }}</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span>
                                @if($ticket->priority->name === 'Critical')
                                    Critical issues are addressed immediately - expect contact within 15 minutes
                                @elseif($ticket->priority->name === 'High')
                                    High priority issues are addressed within 2 hours
                                @elseif($ticket->priority->name === 'Medium')
                                    Medium priority issues are addressed within 4 hours
                                @else
                                    We'll respond within 24 hours during business hours
                                @endif
                            </span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span>Check your ticket status anytime using your ticket number</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid md:grid-cols-2 gap-4">
                <!-- Submit Another Ticket -->
                <a href="{{ route('portal.submit') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow text-center">
                    <svg class="w-10 h-10 text-blue-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <h3 class="font-semibold text-slate-900 mb-1">Submit Another Ticket</h3>
                    <p class="text-sm text-slate-600">Report another issue</p>
                </a>

                <!-- Return to Portal -->
                <a href="/" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow text-center">
                    <svg class="w-10 h-10 text-green-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <h3 class="font-semibold text-slate-900 mb-1">Return to Portal</h3>
                    <p class="text-sm text-slate-600">Back to help desk</p>
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
