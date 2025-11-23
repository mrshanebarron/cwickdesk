<x-landing-layout>
    {{-- Hero Section --}}
    <section class="relative py-32 overflow-hidden particles-container">
        <div class="absolute inset-0 gradient-bg-animated"></div>
        <div class="absolute inset-0 dot-grid-dark"></div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <div class="animate-on-scroll">
                <h1 class="font-display text-5xl sm:text-6xl lg:text-7xl font-bold text-white mb-6">
                    Simple, Transparent <span class="text-gradient">Pricing</span>
                </h1>
                <p class="mx-auto max-w-2xl text-xl text-slate-300 mb-12">
                    No hidden fees. No surprise bills. Just flat-rate plans that scale with your business.
                </p>
            </div>
        </div>
    </section>

    {{-- Pricing Cards --}}
    <section class="relative py-20 bg-slate-950">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">

                {{-- Starter Plan --}}
                <div class="glass-dark rounded-3xl p-8 pricing-card animate-on-scroll">
                    <div class="mb-8">
                        <h3 class="font-display text-2xl font-bold text-white mb-2">Starter</h3>
                        <p class="text-slate-400 text-sm">Perfect for small teams getting started</p>
                    </div>

                    <div class="mb-8">
                        <div class="flex items-baseline">
                            <span class="font-display text-5xl font-bold text-white">$49</span>
                            <span class="text-slate-400 ml-2">/month</span>
                        </div>
                    </div>

                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-slate-300">Up to 10 users</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-slate-300">Unlimited tickets</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-slate-300">Asset management</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-slate-300">Knowledge base</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-slate-300">Email support</span>
                        </li>
                    </ul>

                    <a href="{{ route('signup.index', ['plan' => 'starter']) }}" class="btn-secondary w-full text-center block">
                        Start Free Trial
                    </a>
                </div>

                {{-- Professional Plan (Featured) --}}
                <div class="glass-dark rounded-3xl p-8 pricing-card pricing-card-featured relative animate-on-scroll transform lg:-translate-y-4 scale-105">
                    <!-- Popular Badge -->
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2 rounded-full text-sm font-semibold shadow-lg">
                            Most Popular
                        </div>
                    </div>

                    <div class="mb-8 mt-4">
                        <h3 class="font-display text-2xl font-bold text-white mb-2">Professional</h3>
                        <p class="text-slate-400 text-sm">Everything you need for professional IT teams</p>
                    </div>

                    <div class="mb-8">
                        <div class="flex items-baseline">
                            <span class="font-display text-5xl font-bold text-gradient">$149</span>
                            <span class="text-slate-400 ml-2">/month</span>
                        </div>
                    </div>

                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-slate-300">Up to 50 users</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-slate-300">Everything in Starter</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-slate-300">SSO (Microsoft, Google)</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-slate-300">REST API access</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-slate-300">Advanced reporting</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-slate-300">Priority support</span>
                        </li>
                    </ul>

                    <a href="{{ route('signup.index', ['plan' => 'professional']) }}" class="btn-primary w-full text-center block">
                        Start Free Trial
                    </a>
                </div>

                {{-- Enterprise Plan --}}
                <div class="glass-dark rounded-3xl p-8 pricing-card animate-on-scroll">
                    <div class="mb-8">
                        <h3 class="font-display text-2xl font-bold text-white mb-2">Enterprise</h3>
                        <p class="text-slate-400 text-sm">For larger organizations with advanced needs</p>
                    </div>

                    <div class="mb-8">
                        <div class="flex items-baseline">
                            <span class="font-display text-5xl font-bold text-white">$399</span>
                            <span class="text-slate-400 ml-2">/month</span>
                        </div>
                    </div>

                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-slate-300">Unlimited users</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-slate-300">Everything in Professional</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-slate-300">Dedicated support team</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-slate-300">Advanced security features</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-slate-300">Custom integrations</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-slate-300">SLA guarantees</span>
                        </li>
                    </ul>

                    <a href="{{ route('signup.index', ['plan' => 'enterprise']) }}" class="btn-secondary w-full text-center block">
                        Contact Sales
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ Section --}}
    <section class="relative py-32 overflow-hidden">
        <div class="absolute inset-0 gradient-mesh opacity-20"></div>

        <div class="relative mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 animate-on-scroll">
                <h2 class="font-display text-4xl sm:text-5xl font-bold text-white mb-6">
                    Frequently Asked <span class="text-gradient">Questions</span>
                </h2>
            </div>

            <div class="space-y-6">
                <div class="glass-dark rounded-2xl p-8 animate-on-scroll">
                    <h3 class="font-display text-xl font-bold text-white mb-3">What's included in the free trial?</h3>
                    <p class="text-slate-400">
                        All plans include a 14-day free trial with full access to all features. No credit card required to start.
                    </p>
                </div>

                <div class="glass-dark rounded-2xl p-8 animate-on-scroll">
                    <h3 class="font-display text-xl font-bold text-white mb-3">Can I change plans later?</h3>
                    <p class="text-slate-400">
                        Yes! You can upgrade or downgrade your plan at any time. Changes take effect immediately and we'll prorate the difference.
                    </p>
                </div>

                <div class="glass-dark rounded-2xl p-8 animate-on-scroll">
                    <h3 class="font-display text-xl font-bold text-white mb-3">What payment methods do you accept?</h3>
                    <p class="text-slate-400">
                        We accept all major credit cards (Visa, MasterCard, American Express) and ACH transfers for annual plans.
                    </p>
                </div>

                <div class="glass-dark rounded-2xl p-8 animate-on-scroll">
                    <h3 class="font-display text-xl font-bold text-white mb-3">Is my data secure?</h3>
                    <p class="text-slate-400">
                        Absolutely. We use AES-256 encryption, SOC 2 certified data centers, and follow industry best practices for security.
                    </p>
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
                Ready to get started?
            </h2>
            <p class="text-xl text-slate-300 mb-12">
                Start your free 14-day trial today. No credit card required.
            </p>
            <a href="{{ route('signup.index') }}" class="btn-primary inline-block">
                Start Free Trial
                <svg class="w-5 h-5 ml-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
    </section>
</x-landing-layout>
