<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit a Ticket - IT Help Desk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white border-b border-slate-200">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">IT Help Desk</h1>
                        <p class="text-xs text-slate-600">Support Portal</p>
                    </div>
                </a>
                <div class="flex items-center space-x-4">
                    @if(Auth::user()->hasAnyRole(['admin', 'agent', 'super_admin']))
                        <a href="/admin" class="flex items-center space-x-2 px-3 py-2 bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold rounded-lg transition-colors shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Admin Panel</span>
                        </a>
                    @endif
                    <a href="/" class="text-sm text-slate-600 hover:text-amber-600 transition-colors">
                        ← Back to Portal
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-12">
        <!-- Page Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-slate-900 mb-2">Submit a Support Ticket</h2>
            <p class="text-slate-600">Fill out the form below and we'll get back to you as soon as possible</p>
        </div>

        @if($templates->isNotEmpty())
            <!-- Quick Templates -->
            <div class="max-w-4xl mx-auto mb-8">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Quick Start: Common Issues
                    </h3>
                    <p class="text-sm text-slate-600 mb-4">Click a template below to auto-fill the form, or scroll down to create a custom ticket</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach($templates as $template)
                            <button
                                type="button"
                                onclick="useTemplate({{ json_encode($template) }})"
                                class="flex flex-col items-center p-4 border-2 border-slate-200 rounded-lg hover:border-{{ $template->color }}-500 hover:bg-{{ $template->color }}-50 transition-all group"
                            >
                                <svg class="w-8 h-8 mb-2 text-slate-400 group-hover:text-{{ $template->color }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <span class="text-xs font-medium text-slate-700 text-center">{{ $template->name }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Ticket Form -->
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg p-8">
                @if(session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                <form action="{{ route('portal.ticket.store') }}" method="POST">
                    @csrf

                    <!-- Submitter Information -->
                    <div class="mb-8 bg-slate-50 rounded-lg p-4">
                        <h3 class="text-sm font-semibold text-slate-700 mb-2">Submitting as:</h3>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-amber-500 rounded-full flex items-center justify-center text-white font-semibold mr-3">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-medium text-slate-900">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-slate-600">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Issue Details Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Issue Details
                        </h3>

                        <!-- Priority -->
                        <div class="mb-4">
                            <label for="priority_id" class="block text-sm font-medium text-slate-700 mb-2">
                                Priority <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="priority_id"
                                name="priority_id"
                                required
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('priority_id') border-red-500 @enderror"
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
                            <p class="text-sm text-slate-500 mt-1">
                                Select how urgent this issue is. Critical issues will be addressed immediately.
                            </p>
                        </div>

                        <!-- Related Asset (Optional) -->
                        <div class="mb-4">
                            <label for="asset_id" class="block text-sm font-medium text-slate-700 mb-2">
                                Related Equipment/Asset (Optional)
                            </label>
                            <select
                                id="asset_id"
                                name="asset_id"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('asset_id') border-red-500 @enderror"
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
                            <p class="text-sm text-slate-500 mt-1">
                                If this issue is related to a specific computer, printer, or other equipment, select it here.
                            </p>
                        </div>

                        <!-- Subject -->
                        <div class="mb-4">
                            <label for="subject" class="block text-sm font-medium text-slate-700 mb-2">
                                Subject <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="subject"
                                name="subject"
                                value="{{ old('subject') }}"
                                required
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('subject') border-red-500 @enderror"
                                placeholder="Brief description of the issue"
                            >
                            @error('subject')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-slate-700 mb-2">
                                Detailed Description <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                id="description"
                                name="description"
                                rows="6"
                                required
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('description') border-red-500 @enderror"
                                placeholder="Please provide as much detail as possible about the issue you're experiencing..."
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-slate-500 mt-1">
                                Include error messages, steps to reproduce, and what you've already tried.
                            </p>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-between pt-6 border-t border-slate-200">
                        <a href="/" class="text-slate-600 hover:text-slate-900 transition-colors">
                            Cancel
                        </a>
                        <button
                            type="submit"
                            class="px-8 py-3 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all"
                        >
                            Submit Ticket
                        </button>
                    </div>
                </form>
            </div>

            <!-- Help Text -->
            <div class="mt-8 text-center">
                <p class="text-sm text-slate-600">
                    Need immediate assistance? Call
                    <strong class="text-slate-900">Ext. 4357</strong>
                    or email
                    <a href="mailto:helpdesk@company.com" class="text-amber-600 hover:text-amber-700">helpdesk@company.com</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-16 py-6 border-t border-slate-200">
        <div class="container mx-auto px-4 text-center text-sm text-slate-600">
            <p>IT Help Desk Portal &copy; 2025 &bull; Available 24/7</p>
        </div>
    </footer>

    <script>
        function useTemplate(template) {
            // Auto-fill subject and description
            document.getElementById('subject').value = template.subject;
            document.getElementById('description').value = template.description;

            // Set priority if available
            if (template.priority_id) {
                const prioritySelect = document.getElementById('priority_id');
                if (prioritySelect) {
                    prioritySelect.value = template.priority_id;
                }
            }

            // Scroll to form
            document.getElementById('subject').scrollIntoView({ behavior: 'smooth', block: 'center' });

            // Focus on subject field
            setTimeout(() => {
                document.getElementById('subject').focus();
            }, 500);

            // Track usage (increment on server side when ticket is submitted)
            console.log('Using template:', template.name);
        }
    </script>
</body>
</html>
