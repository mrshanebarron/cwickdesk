<x-filament::section>
    <div class="flex items-center justify-between p-4 bg-warning-50 dark:bg-warning-900/20 rounded-lg border-2 border-warning-500">
        <div class="flex items-center space-x-4">
            <svg class="w-8 h-8 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <div>
                <h3 class="text-lg font-semibold text-warning-900 dark:text-warning-100">
                    Impersonating: {{ auth()->user()->name }}
                </h3>
                <p class="text-sm text-warning-700 dark:text-warning-300">
                    You are currently viewing this portal as <strong>{{ auth()->user()->email }}</strong>
                </p>
            </div>
        </div>
        <div>
            <a href="{{ route('impersonate.leave') }}"
               class="inline-flex items-center px-4 py-2 bg-warning-600 hover:bg-warning-700 text-white font-semibold rounded-lg shadow transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Leave Impersonation
            </a>
        </div>
    </div>
</x-filament::section>
