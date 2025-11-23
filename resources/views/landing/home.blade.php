<x-landing-layout>
    {{-- Hero Section --}}
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden particles-container">
        <!-- Background Elements -->
        <div class="absolute inset-0 gradient-bg-animated"></div>
        <div class="absolute inset-0 dot-grid-dark"></div>

        <!-- Floating Orbs -->
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-600/30 rounded-full blur-3xl float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-purple-600/30 rounded-full blur-3xl float-slow"></div>

        <!-- Content -->
        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-32 text-center">
            <div class="animate-on-scroll">
                <!-- Badge -->
                <div class="inline-flex items-center glass px-6 py-2 rounded-full mb-8 border border-white/20">
                    <span class="w-2 h-2 bg-green-400 rounded-full mr-3 animate-pulse"></span>
                    <span class="text-sm text-slate-200">Now Available - Start Your Free Trial</span>
                </div>

                <!-- Main Headline -->
                <h1 class="font-display text-5xl sm:text-7xl lg:text-8xl font-bold tracking-tight mb-8 leading-tight">
                    <span class="text-white">IT Management</span><br/>
                    <span class="text-gradient-blue">Made Simple</span>
                </h1>

                <!-- Subheadline -->
                <p class="mx-auto max-w-3xl text-xl sm:text-2xl text-slate-300 mb-12 leading-relaxed">
                    Stop juggling multiple tools. CwickDesk brings ticketing, assets, passwords, and documentation together in one beautiful platform.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('signup.index') }}" class="btn-primary inline-flex items-center space-x-2">
                        <span>Start Free Trial</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                    <a href="{{ route('landing.features') }}" class="btn-secondary inline-flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Watch Demo</span>
                    </a>
                </div>

                <!-- Trust Indicators -->
                <div class="mt-16 flex flex-wrap items-center justify-center gap-8 text-sm text-slate-400">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>14-day free trial</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>No credit card required</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Cancel anytime</span>
                    </div>
                </div>
            </div>

            <!-- Screenshot / Dashboard Preview -->
            <div class="mt-20 animate-on-scroll">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl blur-2xl opacity-30"></div>
                    <div class="relative glass-dark p-4 rounded-2xl shadow-2xl border border-white/10">
                        <div class="aspect-video bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-24 h-24 text-slate-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-slate-600 font-medium">Dashboard Preview</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    {{-- Features Grid --}}
    <section class="relative py-32 bg-slate-950">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-20 animate-on-scroll">
                <h2 class="font-display text-4xl sm:text-5xl font-bold text-white mb-6">
                    Everything in <span class="text-gradient">One Platform</span>
                </h2>
                <p class="text-xl text-slate-400 max-w-2xl mx-auto">
                    Powerful features that replace multiple tools and save your team hours every week.
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Feature 1: Ticketing -->
                <div class="glass-dark rounded-2xl p-8 card-hover group animate-on-scroll">
                    <div class="feature-icon w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-white mb-3">Service Desk</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Email-to-ticket automation, SLA tracking, and smart routing. Resolve issues faster with built-in workflows.
                    </p>
                </div>

                <!-- Feature 2: Assets -->
                <div class="glass-dark rounded-2xl p-8 card-hover group animate-on-scroll">
                    <div class="feature-icon w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-white mb-3">Asset Management</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Track hardware, software, and licenses. Get warranty alerts and generate QR labels automatically.
                    </p>
                </div>

                <!-- Feature 3: Passwords -->
                <div class="glass-dark rounded-2xl p-8 card-hover group animate-on-scroll">
                    <div class="feature-icon w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-white mb-3">Password Vault</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        AES-256 encryption, role-based access, and complete audit trails. Enterprise security made simple.
                    </p>
                </div>

                <!-- Feature 4: Knowledge Base -->
                <div class="glass-dark rounded-2xl p-8 card-hover group animate-on-scroll">
                    <div class="feature-icon w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-white mb-3">Knowledge Base</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Centralize documentation with full-text search, version control, and ticket linking for self-service.
                    </p>
                </div>
            </div>

            <!-- View All Features Button -->
            <div class="text-center mt-16 animate-on-scroll">
                <a href="{{ route('landing.features') }}" class="btn-secondary">
                    View All Features
                    <svg class="w-5 h-5 ml-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- Stats Section --}}
    <section class="relative py-20 overflow-hidden">
        <div class="absolute inset-0 gradient-mesh opacity-20"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center animate-on-scroll">
                    <div class="font-display text-5xl font-bold text-gradient mb-2">99.9%</div>
                    <div class="text-slate-400 text-sm">Uptime SLA</div>
                </div>
                <div class="text-center animate-on-scroll">
                    <div class="font-display text-5xl font-bold text-gradient mb-2">50%</div>
                    <div class="text-slate-400 text-sm">Faster Resolution</div>
                </div>
                <div class="text-center animate-on-scroll">
                    <div class="font-display text-5xl font-bold text-gradient mb-2">24/7</div>
                    <div class="text-slate-400 text-sm">Support Available</div>
                </div>
                <div class="text-center animate-on-scroll">
                    <div class="font-display text-5xl font-bold text-gradient mb-2">5min</div>
                    <div class="text-slate-400 text-sm">Setup Time</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Integration Section --}}
    <section class="relative py-32 bg-slate-950">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <!-- Content -->
                <div class="animate-on-scroll">
                    <h2 class="font-display text-4xl sm:text-5xl font-bold text-white mb-6">
                        Integrates with Your <span class="text-gradient">Favorite Tools</span>
                    </h2>
                    <p class="text-xl text-slate-400 mb-8">
                        Connect with Microsoft 365, Google Workspace, Slack, and more. Single sign-on, directory sync, and automated workflows out of the box.
                    </p>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-slate-300">Microsoft 365 & Azure AD SSO</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-slate-300">Google Workspace Integration</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-slate-300">Slack & Microsoft Teams Notifications</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-slate-300">REST API & Webhooks</span>
                        </li>
                    </ul>
                    <a href="{{ route('landing.features') }}" class="btn-secondary">
                        Explore Integrations
                    </a>
                </div>

                <!-- Integration Logos Grid -->
                <div class="grid grid-cols-3 gap-6 animate-on-scroll">
                    @foreach(['Microsoft', 'Google', 'Slack', 'Zapier', 'GitHub', 'Jira'] as $tool)
                        <div class="glass-dark rounded-2xl p-8 flex items-center justify-center h-32 card-hover">
                            <span class="text-slate-500 font-semibold">{{ $tool }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="relative py-32 overflow-hidden">
        <div class="absolute inset-0 gradient-bg-animated"></div>
        <div class="absolute inset-0 dot-grid-dark"></div>

        <div class="relative z-10 mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-display text-4xl sm:text-6xl font-bold text-white mb-6">
                Ready to simplify your IT?
            </h2>
            <p class="text-xl text-slate-300 mb-12">
                Join teams who trust CwickDesk to manage their IT infrastructure.
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
