<x-filament::section>
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg p-8">
        <!-- Header -->
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    Welcome to CwickDesk! 🎉
                </h2>
                <p class="text-gray-600 dark:text-gray-300">
                    Let's get you started with a quick tour of the platform. Complete any 3 steps to finish onboarding.
                </p>
            </div>
            <button wire:click="dismissOnboarding" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Progress Bar -->
        @php
            $totalSteps = count($steps);
            $completedCount = collect($steps)->filter(fn($step) => $step['completed'])->count();
            $progressPercent = $totalSteps > 0 ? ($completedCount / $totalSteps) * 100 : 0;
        @endphp

        <div class="mb-8">
            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-300 mb-2">
                <span>Progress</span>
                <span>{{ $completedCount }} of {{ $totalSteps }} completed</span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 h-3 rounded-full transition-all duration-500" style="width: {{ $progressPercent }}%"></div>
            </div>
        </div>

        <!-- Steps Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($steps as $step)
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border-2 {{ $step['completed'] ? 'border-green-500' : 'border-gray-200 dark:border-gray-700' }} hover:shadow-md transition-all">
                    <div class="flex items-start justify-between mb-3">
                        <span class="text-4xl">{{ $step['icon'] }}</span>
                        @if($step['completed'])
                            <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        @endif
                    </div>

                    <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2">
                        {{ $step['title'] }}
                    </h3>

                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                        {{ $step['description'] }}
                    </p>

                    @if(!$step['completed'] && isset($step['action']))
                        <a href="{{ $step['action'] }}"
                           wire:click="markStepComplete('{{ $step['id'] }}')"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition">
                            {{ $step['action_label'] }}
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    @elseif($step['completed'])
                        <span class="text-green-600 dark:text-green-400 text-sm font-semibold">
                            ✓ Completed
                        </span>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Help Section -->
        <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-start space-x-4">
                <div class="text-4xl">💡</div>
                <div class="flex-1">
                    <h4 class="font-bold text-gray-900 dark:text-white mb-2">Need Help Getting Started?</h4>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Check out our comprehensive documentation and video tutorials to make the most of CwickDesk.
                    </p>
                    <div class="flex gap-3">
                        <a href="/admin/kb-articles" class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-semibold">
                            View Documentation
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        <button wire:click="dismissOnboarding" class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200">
                            Skip Tour
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament::section>
