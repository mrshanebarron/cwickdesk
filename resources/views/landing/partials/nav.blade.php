<header class="py-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <nav class="relative z-50 flex justify-between">
            <div class="flex items-center md:gap-x-12">
                <a href="/" aria-label="Home">
                    <img src="{{ asset('logo.png') }}" alt="CwickDesk" class="h-10 w-auto">
                </a>
                <div class="hidden md:flex md:gap-x-6">
                    <a href="{{ route('landing.features') }}" class="inline-block rounded-lg px-2 py-1 text-sm text-slate-700 hover:bg-slate-100 hover:text-slate-900">Features</a>
                    <a href="{{ route('landing.pricing') }}" class="inline-block rounded-lg px-2 py-1 text-sm text-slate-700 hover:bg-slate-100 hover:text-slate-900">Pricing</a>
                    <a href="#" class="inline-block rounded-lg px-2 py-1 text-sm text-slate-700 hover:bg-slate-100 hover:text-slate-900">Demo</a>
                </div>
            </div>
            <div class="flex items-center gap-x-5 md:gap-x-8">
                <a href="{{ route('signup.index') }}" class="group inline-flex items-center justify-center rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-500 hover:text-slate-100 focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 active:bg-blue-800 active:text-blue-100">
                    <span>Get started <span class="hidden lg:inline">today</span></span>
                </a>
            </div>
        </nav>
    </div>
</header>
