@extends('portal.layouts.app')

@section('title', 'Submit a Ticket')

@push('scripts')
<script>
    function useTemplate(template) {
        document.getElementById('subject').value = template.subject;
        document.getElementById('description').value = template.description;

        if (template.priority_id) {
            const prioritySelect = document.getElementById('priority_id');
            if (prioritySelect) {
                prioritySelect.value = template.priority_id;
            }
        }

        document.getElementById('subject').scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => {
            document.getElementById('subject').focus();
        }, 500);
    }
</script>
@endpush

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold mb-2">Submit a Support Ticket</h2>
        <p class="text-slate-600 dark:text-slate-400">Fill out the form below and we'll get back to you as soon as possible</p>
    </div>

    @if($templates->isNotEmpty())
        <div class="max-w-4xl mx-auto mb-8">
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-lg font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Quick Start: Common Issues
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">Click a template below to auto-fill the form, or scroll down to create a custom ticket</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach($templates as $template)
                        <button
                            type="button"
                            onclick="useTemplate({{ json_encode($template) }})"
                            class="flex flex-col items-center p-4 border-2 border-slate-300 dark:border-slate-600 rounded-lg hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all group"
                        >
                            <svg class="w-8 h-8 mb-2 text-slate-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <span class="text-xs font-medium text-center">{{ $template->name }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="max-w-3xl mx-auto">
        <div class="glass-card rounded-2xl p-8">
            @if(session('error'))
                <div class="mb-6 bg-red-500/10 border border-red-500/30 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-red-800 dark:text-red-300">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <form action="{{ route('portal.ticket.store') }}" method="POST">
                @csrf

                <div class="mb-8 bg-slate-100 dark:bg-slate-800/50 rounded-lg p-4">
                    <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Submitting as:</h3>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold mr-3">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-medium">{{ Auth::user()->name }}</p>
                            <p class="text-sm text-slate-600 dark:text-slate-400">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Issue Details
                    </h3>

                    <div class="mb-4">
                        <label for="priority_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Priority <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="priority_id"
                            name="priority_id"
                            required
                            class="w-full px-4 py-3 bg-slate-100 dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('priority_id') border-red-500 @enderror"
                        >
                            <option value="">Select priority level...</option>
                            @foreach($priorities as $priority)
                                <option value="{{ $priority->id }}" {{ old('priority_id') == $priority->id ? 'selected' : '' }}>
                                    {{ $priority->name }}
                                    @if($priority->description)
                                        - {{ $priority->description }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('priority_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                            Select how urgent this issue is. Critical issues will be addressed immediately.
                        </p>
                    </div>

                    <div class="mb-4">
                        <label for="asset_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Related Equipment/Asset (Optional)
                        </label>
                        <select
                            id="asset_id"
                            name="asset_id"
                            class="w-full px-4 py-3 bg-slate-100 dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('asset_id') border-red-500 @enderror"
                        >
                            <option value="">None - General issue not related to specific equipment</option>
                            @foreach($assets as $asset)
                                <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
                                    {{ $asset->asset_tag }} - {{ $asset->name }}
                                    @if($asset->manufacturer || $asset->model)
                                        ({{ $asset->manufacturer }} {{ $asset->model }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('asset_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                            If this issue is related to a specific computer, printer, or other equipment, select it here.
                        </p>
                    </div>

                    <div class="mb-4">
                        <label for="subject" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Subject <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="subject"
                            name="subject"
                            value="{{ old('subject') }}"
                            required
                            class="w-full px-4 py-3 bg-slate-100 dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg text-slate-900 dark:text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('subject') border-red-500 @enderror"
                            placeholder="Brief description of the issue"
                        >
                        @error('subject')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Detailed Description <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            id="description"
                            name="description"
                            rows="6"
                            required
                            class="w-full px-4 py-3 bg-slate-100 dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg text-slate-900 dark:text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                            placeholder="Please provide as much detail as possible about the issue you're experiencing..."
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                            Include error messages, steps to reproduce, and what you've already tried.
                        </p>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-6 border-t border-slate-300 dark:border-slate-600">
                    <a href="/" class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                        Cancel
                    </a>
                    <button
                        type="submit"
                        class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all"
                    >
                        Submit Ticket
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-8 text-center">
            <p class="text-sm text-slate-600 dark:text-slate-400">
                Need immediate assistance? Call
                <strong class="text-slate-900 dark:text-white">Ext. 4357</strong>
                or email
                <a href="mailto:helpdesk@company.com" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">helpdesk@company.com</a>
            </p>
        </div>
    </div>
</div>
@endsection
