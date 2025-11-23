@extends('portal.layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center relative overflow-hidden py-12">
    <div class="absolute inset-0 gradient-mesh opacity-20"></div>

    <div class="relative z-10 w-full max-w-2xl px-4 sm:px-6 lg:px-8">
        <div class="glass-card rounded-3xl p-8 sm:p-12">
            {{-- Logo --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center space-x-3 mb-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="text-left">
                        <div class="font-display text-2xl text-slate-900 dark:text-white">IT Help Desk</div>
                        <div class="text-xs text-slate-600 dark:text-slate-400">Support Portal</div>
                    </div>
                </div>
            </div>

            {{-- Title --}}
            <h2 class="text-2xl font-bold text-center mb-2 text-slate-900 dark:text-white">Create Your Account</h2>
            <p class="text-slate-600 dark:text-slate-400 text-center mb-8">Join the portal to submit tickets and access support</p>

            {{-- Error Messages --}}
            @if($errors->any())
                <div class="mb-6 bg-red-500/10 border border-red-500/30 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <p class="text-red-400 text-sm font-semibold mb-1">Please correct the following errors:</p>
                            <ul class="list-disc list-inside text-red-300 text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Registration Form --}}
            <form action="{{ route('portal.register.submit') }}" method="POST">
                @csrf

                {{-- Required Information --}}
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center text-slate-900 dark:text-white">
                        <svg class="w-5 h-5 mr-2 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Required Information
                    </h3>

                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        {{-- Full Name --}}
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Full Name <span class="text-red-400">*</span>
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                class="w-full px-4 py-3 bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-lg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror"
                                placeholder="John Doe"
                            >
                            @error('name')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="md:col-span-2">
                            <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Email Address <span class="text-red-400">*</span>
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                class="w-full px-4 py-3 bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-lg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                                placeholder="john.doe@company.com"
                            >
                            @error('email')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Password <span class="text-red-400">*</span>
                            </label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                class="w-full px-4 py-3 bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-lg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror"
                                placeholder="At least 8 characters"
                            >
                            @error('password')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Confirm Password <span class="text-red-400">*</span>
                            </label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                required
                                class="w-full px-4 py-3 bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-lg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all"
                                placeholder="Re-enter password"
                            >
                        </div>
                    </div>
                </div>

                {{-- Optional Information --}}
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 flex items-center text-slate-900 dark:text-white">
                        <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Optional Information
                    </h3>

                    <div class="grid md:grid-cols-2 gap-4">
                        {{-- Extension --}}
                        <div>
                            <label for="extension" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Phone Extension
                            </label>
                            <input
                                type="text"
                                id="extension"
                                name="extension"
                                value="{{ old('extension') }}"
                                class="w-full px-4 py-3 bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-lg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all @error('extension') border-red-500 @enderror"
                                placeholder="1234"
                            >
                            @error('extension')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Cell Phone --}}
                        <div>
                            <label for="cell" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Cell Phone
                            </label>
                            <input
                                type="text"
                                id="cell"
                                name="cell"
                                value="{{ old('cell') }}"
                                class="w-full px-4 py-3 bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-lg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all @error('cell') border-red-500 @enderror"
                                placeholder="(555) 123-4567"
                            >
                            @error('cell')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Department --}}
                        <div class="md:col-span-2">
                            <label for="department" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Department
                            </label>
                            <input
                                type="text"
                                id="department"
                                name="department"
                                value="{{ old('department') }}"
                                class="w-full px-4 py-3 bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-lg text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all @error('department') border-red-500 @enderror"
                                placeholder="Sales, Marketing, Engineering, etc."
                            >
                            @error('department')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <button
                    type="submit"
                    class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all"
                >
                    Create Account
                </button>
            </form>

            {{-- Divider --}}
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-300 dark:border-white/10"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-transparent text-slate-600 dark:text-slate-400">Already have an account?</span>
                </div>
            </div>

            {{-- Login Link --}}
            <a
                href="{{ route('portal.login') }}"
                class="block w-full px-6 py-3 bg-slate-100 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/10 border border-slate-300 dark:border-white/10 text-slate-900 dark:text-white font-semibold text-center rounded-lg transition-all"
            >
                Sign In Instead
            </a>
        </div>

        {{-- Back to Home --}}
        <div class="mt-8 text-center">
            <a href="/" class="text-sm text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                ← Back to Home
            </a>
        </div>
    </div>
</div>
@endsection
