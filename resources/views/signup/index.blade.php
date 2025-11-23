<x-landing-layout title="Sign Up - CwickDesk">
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden py-32">
        <div class="absolute inset-0 gradient-mesh opacity-20"></div>

        <div class="relative z-10 mx-auto max-w-2xl px-4 sm:px-6 lg:px-8 w-full">
            <div class="text-center mb-12 animate-on-scroll">
                <div class="inline-flex items-center glass px-6 py-2 rounded-full mb-6">
                    <span class="w-2 h-2 bg-green-400 rounded-full mr-3 animate-pulse"></span>
                    <span class="text-sm text-slate-200">14-Day Free Trial</span>
                </div>

                <h1 class="font-display text-4xl sm:text-5xl font-bold text-white mb-4">
                    {{ $selectedPlan['name'] }} Plan
                </h1>
                <p class="text-xl text-slate-300">
                    <span class="font-semibold text-gradient">${{ $selectedPlan['price'] }}</span>/month after trial
                </p>
            </div>

            @if(session('error'))
                <div class="glass-dark border-2 border-red-500/30 rounded-2xl p-6 mb-8 animate-on-scroll">
                    <div class="flex items-start space-x-3">
                        <svg class="w-6 h-6 text-red-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-red-400 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <div class="glass-dark rounded-3xl p-8 sm:p-12 animate-on-scroll">
                <form id="signup-form" method="POST" action="{{ route('signup.store') }}" class="space-y-8">
                    @csrf
                    <input type="hidden" name="plan" value="{{ $plan }}">
                    <input type="hidden" name="payment_method" id="payment-method">

                    {{-- Company Information --}}
                    <div>
                        <h2 class="font-display text-2xl font-bold text-white mb-6">Company Information</h2>
                        <div class="space-y-6">
                            <div>
                                <label for="company_name" class="block text-sm font-semibold text-slate-300 mb-2">
                                    Company Name *
                                </label>
                                <input type="text" name="company_name" id="company_name" required
                                       class="w-full px-4 py-3 bg-slate-900/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all input-glow"
                                       placeholder="Acme Corporation"
                                       value="{{ old('company_name') }}">
                                @error('company_name')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="subdomain" class="block text-sm font-semibold text-slate-300 mb-2">
                                    Your Unique URL *
                                </label>
                                <div class="flex rounded-xl overflow-hidden bg-slate-900/50 border border-slate-700 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500/20 transition-all">
                                    <input type="text" name="subdomain" id="subdomain" required
                                           class="flex-1 px-4 py-3 bg-transparent border-0 text-white placeholder-slate-500 focus:ring-0"
                                           placeholder="acme"
                                           value="{{ old('subdomain') }}">
                                    <span class="flex items-center px-4 text-slate-400 font-medium">.cwick.us</span>
                                </div>
                                <p class="mt-2 text-sm text-slate-400">This will be your login URL</p>
                                @error('subdomain')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Admin User --}}
                    <div class="pt-8 border-t border-slate-700/50">
                        <h2 class="font-display text-2xl font-bold text-white mb-6">Admin Account</h2>
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-slate-300 mb-2">
                                    Your Name *
                                </label>
                                <input type="text" name="name" id="name" required
                                       class="w-full px-4 py-3 bg-slate-900/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all input-glow"
                                       placeholder="John Smith"
                                       value="{{ old('name') }}">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-semibold text-slate-300 mb-2">
                                    Email Address *
                                </label>
                                <input type="email" name="email" id="email" required
                                       class="w-full px-4 py-3 bg-slate-900/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all input-glow"
                                       placeholder="john@acme.com"
                                       value="{{ old('email') }}">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-semibold text-slate-300 mb-2">
                                    Password *
                                </label>
                                <input type="password" name="password" id="password" required
                                       class="w-full px-4 py-3 bg-slate-900/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all input-glow"
                                       placeholder="Minimum 8 characters">
                                @error('password')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-slate-300 mb-2">
                                    Confirm Password *
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                       class="w-full px-4 py-3 bg-slate-900/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all input-glow">
                            </div>
                        </div>
                    </div>

                    {{-- Payment Information --}}
                    <div class="pt-8 border-t border-slate-700/50">
                        <h2 class="font-display text-2xl font-bold text-white mb-2">Payment Information</h2>
                        <p class="text-sm text-slate-400 mb-6">You won't be charged until after your 14-day trial</p>

                        <div id="card-element" class="w-full px-4 py-3 bg-slate-900/50 border border-slate-700 rounded-xl"></div>
                        <div id="card-errors" class="mt-2 text-sm text-red-400"></div>
                    </div>

                    {{-- Terms --}}
                    <div class="pt-6">
                        <label class="flex items-start space-x-3 cursor-pointer">
                            <input type="checkbox" name="terms_accepted" id="terms_accepted" required
                                   class="w-5 h-5 rounded border-slate-600 bg-slate-900/50 text-blue-600 focus:ring-2 focus:ring-blue-500/20 mt-0.5">
                            <span class="text-sm text-slate-300">
                                I agree to the <a href="{{ route('legal.terms') }}" target="_blank" class="text-blue-400 hover:text-blue-300 underline">Terms of Service</a>
                                and <a href="{{ route('legal.privacy') }}" target="_blank" class="text-blue-400 hover:text-blue-300 underline">Privacy Policy</a>
                            </span>
                        </label>
                        @error('terms_accepted')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" id="submit-button" class="btn-primary w-full text-center">
                        Start Free Trial
                        <svg class="w-5 h-5 ml-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </button>

                    <p class="text-center text-sm text-slate-400">
                        <svg class="w-4 h-4 inline mr-1 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                        </svg>
                        Your information is encrypted and secure
                    </p>
                </form>
            </div>

            <p class="text-center text-sm text-slate-400 mt-8">
                Already have an account? <a href="{{ route('portal.login') }}" class="text-blue-400 hover:text-blue-300 font-semibold">Sign in</a>
            </p>
        </div>
    </section>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ $stripeKey }}');
        const elements = stripe.elements();

        const cardElement = elements.create('card', {
            style: {
                base: {
                    fontSize: '16px',
                    color: '#fff',
                    fontFamily: '"Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif',
                    '::placeholder': {
                        color: '#64748b'
                    }
                },
                invalid: {
                    color: '#f87171'
                }
            }
        });

        cardElement.mount('#card-element');

        cardElement.on('change', (event) => {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        const form = document.getElementById('signup-form');
        const submitButton = document.getElementById('submit-button');

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            submitButton.disabled = true;
            submitButton.innerHTML = '<svg class="animate-spin w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

            const {paymentMethod, error} = await stripe.createPaymentMethod({
                type: 'card',
                card: cardElement,
                billing_details: {
                    name: form.querySelector('[name="name"]').value,
                    email: form.querySelector('[name="email"]').value,
                }
            });

            if (error) {
                document.getElementById('card-errors').textContent = error.message;
                submitButton.disabled = false;
                submitButton.innerHTML = 'Start Free Trial <svg class="w-5 h-5 ml-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>';
            } else {
                document.getElementById('payment-method').value = paymentMethod.id;
                form.submit();
            }
        });
    </script>
</x-landing-layout>
