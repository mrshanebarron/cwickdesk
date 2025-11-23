<x-landing-layout>
    {{-- Hero Section --}}
    <section class="relative min-h-[60vh] flex items-center justify-center overflow-hidden particles-container">
        <div class="absolute inset-0 gradient-bg-animated"></div>
        <div class="absolute inset-0 dot-grid-dark"></div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-32 text-center">
            <div class="animate-on-scroll">
                <h1 class="font-display text-5xl sm:text-6xl lg:text-7xl font-bold text-white mb-6">
                    Powerful Features for <span class="text-gradient">Modern IT</span>
                </h1>
                <p class="mx-auto max-w-3xl text-xl text-slate-300 mb-12">
                    Everything your IT team needs in one unified platform. No more context switching between tools.
                </p>
            </div>
        </div>
    </section>

    {{-- Core Features --}}
    <section class="relative py-32 bg-slate-950">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center mb-32">
                {{-- Service Desk --}}
                <div class="animate-on-scroll">
                    <div class="inline-flex items-center glass px-4 py-2 rounded-full mb-6">
                        <span class="text-sm text-blue-400 font-semibold">Service Desk</span>
                    </div>
                    <h2 class="font-display text-4xl font-bold text-white mb-6">
                        Ticketing That <span class="text-gradient">Actually Works</span>
                    </h2>
                    <p class="text-xl text-slate-400 mb-8">
                        Transform support chaos into structured workflows. Track every request from creation to resolution.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-blue-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-white mb-1">Email-to-Ticket Automation</h3>
                                <p class="text-slate-400 text-sm">Forward emails directly into tickets. No manual data entry.</p>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-blue-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-white mb-1">SLA Tracking & Alerts</h3>
                                <p class="text-slate-400 text-sm">Never miss a deadline. Automatic escalation for overdue tickets.</p>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-blue-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-white mb-1">Smart Routing</h3>
                                <p class="text-slate-400 text-sm">AI-powered assignment based on skills, workload, and availability.</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="glass-dark p-4 rounded-2xl animate-on-scroll">
                    <div class="aspect-video bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl flex items-center justify-center">
                        <svg class="w-24 h-24 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Asset Management --}}
            <div class="grid lg:grid-cols-2 gap-16 items-center mb-32">
                <div class="glass-dark p-4 rounded-2xl animate-on-scroll order-2 lg:order-1">
                    <div class="aspect-video bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl flex items-center justify-center">
                        <svg class="w-24 h-24 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                        </svg>
                    </div>
                </div>

                <div class="animate-on-scroll order-1 lg:order-2">
                    <div class="inline-flex items-center glass px-4 py-2 rounded-full mb-6">
                        <span class="text-sm text-cyan-400 font-semibold">Asset Management</span>
                    </div>
                    <h2 class="font-display text-4xl font-bold text-white mb-6">
                        Track Every <span class="text-gradient">Asset</span>
                    </h2>
                    <p class="text-xl text-slate-400 mb-8">
                        From laptops to licenses, know exactly what you have, where it is, and when it needs attention.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-cyan-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-4 h-4 text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-white mb-1">Complete Inventory</h3>
                                <p class="text-slate-400 text-sm">Hardware, software, licenses all in one place with custom fields.</p>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-cyan-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-4 h-4 text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-white mb-1">Warranty Alerts</h3>
                                <p class="text-slate-400 text-sm">Get notified before warranties expire. Never lose coverage.</p>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-cyan-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-4 h-4 text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-white mb-1">QR Code Labels</h3>
                                <p class="text-slate-400 text-sm">Generate printable labels for instant asset lookup via phone.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Password Vault --}}
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="animate-on-scroll">
                    <div class="inline-flex items-center glass px-4 py-2 rounded-full mb-6">
                        <span class="text-sm text-purple-400 font-semibold">Security</span>
                    </div>
                    <h2 class="font-display text-4xl font-bold text-white mb-6">
                        Enterprise <span class="text-gradient">Password Vault</span>
                    </h2>
                    <p class="text-xl text-slate-400 mb-8">
                        Secure credential storage that your whole team can use. Bank-level encryption with complete audit trails.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-purple-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-4 h-4 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-white mb-1">AES-256 Encryption</h3>
                                <p class="text-slate-400 text-sm">Military-grade encryption keeps credentials safe at rest and in transit.</p>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-purple-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-4 h-4 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-white mb-1">Role-Based Access</h3>
                                <p class="text-slate-400 text-sm">Control who can view, edit, or share each credential.</p>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-purple-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-4 h-4 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-white mb-1">Complete Audit Logs</h3>
                                <p class="text-slate-400 text-sm">See who accessed what and when for compliance.</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="glass-dark p-4 rounded-2xl animate-on-scroll">
                    <div class="aspect-video bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl flex items-center justify-center">
                        <svg class="w-24 h-24 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Integrations --}}
    <section class="relative py-32 overflow-hidden">
        <div class="absolute inset-0 gradient-mesh opacity-20"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <div class="animate-on-scroll mb-16">
                <h2 class="font-display text-4xl sm:text-5xl font-bold text-white mb-6">
                    Works With Your <span class="text-gradient">Favorite Tools</span>
                </h2>
                <p class="text-xl text-slate-400 max-w-3xl mx-auto">
                    Connect seamlessly with the tools you already use. Single sign-on, webhooks, and REST API included.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 max-w-5xl mx-auto">
                @foreach(['Microsoft 365', 'Google Workspace', 'Slack', 'Teams', 'Zapier', 'GitHub'] as $integration)
                    <div class="glass-dark rounded-2xl p-6 card-hover animate-on-scroll">
                        <div class="text-slate-400 font-semibold text-sm">{{ $integration }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="relative py-32 overflow-hidden">
        <div class="absolute inset-0 gradient-bg-animated"></div>
        <div class="absolute inset-0 dot-grid-dark"></div>

        <div class="relative z-10 mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-display text-4xl sm:text-6xl font-bold text-white mb-6">
                See it in action
            </h2>
            <p class="text-xl text-slate-300 mb-12">
                Start your free trial and experience the difference.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('signup.index') }}" class="btn-primary">
                    Start Free Trial
                    <svg class="w-5 h-5 ml-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                <a href="{{ route('landing.pricing') }}" class="btn-secondary">
                    View Pricing
                </a>
            </div>
        </div>
    </section>
</x-landing-layout>
