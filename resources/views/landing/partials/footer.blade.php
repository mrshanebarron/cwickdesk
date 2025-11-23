<footer class="bg-slate-900">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="py-16">
            <img src="{{ asset('logo.png') }}" alt="CwickDesk" class="mx-auto h-10 w-auto">
            <nav class="mt-10 text-sm" aria-label="quick links">
                <div class="-my-1 flex justify-center gap-x-6">
                    <a href="{{ route('landing.features') }}" class="inline-block rounded-lg px-2 py-1 text-sm text-slate-400 hover:bg-slate-800 hover:text-white">Features</a>
                    <a href="{{ route('landing.pricing') }}" class="inline-block rounded-lg px-2 py-1 text-sm text-slate-400 hover:bg-slate-800 hover:text-white">Pricing</a>
                    <a href="#" class="inline-block rounded-lg px-2 py-1 text-sm text-slate-400 hover:bg-slate-800 hover:text-white">Demo</a>
                </div>
            </nav>
        </div>
        <div class="flex flex-col items-center border-t border-slate-400/10 py-10 sm:flex-row-reverse sm:justify-between">
            <div class="flex gap-x-6">
                {{-- Add social icons here if needed --}}
            </div>
            <p class="mt-6 text-sm text-slate-400 sm:mt-0">
                Copyright &copy; {{ date('Y') }} CwickDesk. All rights reserved.
            </p>
        </div>
    </div>
</footer>
