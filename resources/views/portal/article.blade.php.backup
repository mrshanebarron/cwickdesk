<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $article->title }} - Knowledge Base</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Article content styling */
        .article-content {
            line-height: 1.8;
        }
        .article-content h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: #1e293b;
        }
        .article-content h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
            color: #334155;
        }
        .article-content h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-top: 1.25rem;
            margin-bottom: 0.5rem;
            color: #475569;
        }
        .article-content p {
            margin-bottom: 1rem;
        }
        .article-content ul, .article-content ol {
            margin-left: 1.5rem;
            margin-bottom: 1rem;
        }
        .article-content ul {
            list-style-type: disc;
        }
        .article-content ol {
            list-style-type: decimal;
        }
        .article-content li {
            margin-bottom: 0.5rem;
        }
        .article-content code {
            background-color: #f1f5f9;
            padding: 0.2rem 0.4rem;
            border-radius: 0.25rem;
            font-family: ui-monospace, monospace;
            font-size: 0.875rem;
        }
        .article-content pre {
            background-color: #1e293b;
            color: #e2e8f0;
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            margin-bottom: 1rem;
        }
        .article-content pre code {
            background-color: transparent;
            padding: 0;
            color: inherit;
        }
        .article-content a {
            color: #f59e0b;
            text-decoration: underline;
        }
        .article-content a:hover {
            color: #d97706;
        }
        .article-content blockquote {
            border-left: 4px solid #f59e0b;
            padding-left: 1rem;
            margin-left: 0;
            margin-bottom: 1rem;
            color: #64748b;
            font-style: italic;
        }
        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 1rem 0;
        }
        .article-content table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }
        .article-content th, .article-content td {
            border: 1px solid #e2e8f0;
            padding: 0.75rem;
            text-align: left;
        }
        .article-content th {
            background-color: #f8fafc;
            font-weight: 600;
        }
    </style>
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
                <a href="{{ route('portal.kb') }}" class="text-sm text-slate-600 hover:text-amber-600 transition-colors">
                    ← Back to Knowledge Base
                </a>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-12">
        <div class="max-w-4xl mx-auto">
            <!-- Breadcrumbs -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-slate-600">
                    <li>
                        <a href="/" class="hover:text-amber-600">Portal</a>
                    </li>
                    <li>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </li>
                    <li>
                        <a href="{{ route('portal.kb') }}" class="hover:text-amber-600">Knowledge Base</a>
                    </li>
                    @if($article->category)
                        <li>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </li>
                        <li>
                            <a href="{{ route('portal.kb', ['category' => $article->category->id]) }}" class="hover:text-amber-600">
                                {{ $article->category->name }}
                            </a>
                        </li>
                    @endif
                    <li>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </li>
                    <li class="text-slate-900">{{ Str::limit($article->title, 40) }}</li>
                </ol>
            </nav>

            <!-- Article Header -->
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-6">
                <!-- Category Badge -->
                @if($article->category)
                    <div class="mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-800">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            {{ $article->category->name }}
                        </span>
                    </div>
                @endif

                <!-- Title -->
                <h1 class="text-4xl font-bold text-slate-900 mb-4">{{ $article->title }}</h1>

                <!-- Excerpt -->
                @if($article->excerpt)
                    <p class="text-lg text-slate-600 mb-6">{{ $article->excerpt }}</p>
                @endif

                <!-- Article Meta -->
                <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500 pb-6 border-b border-slate-200">
                    @if($article->author)
                        <span class="flex items-center">
                            <div class="w-6 h-6 bg-amber-500 rounded-full flex items-center justify-center text-white text-xs font-semibold mr-2">
                                {{ substr($article->author->name, 0, 1) }}
                            </div>
                            {{ $article->author->name }}
                        </span>
                    @endif

                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Published {{ $article->created_at->format('F j, Y') }}
                    </span>

                    @if($article->updated_at && $article->updated_at != $article->created_at)
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Updated {{ $article->updated_at->format('M j, Y') }}
                        </span>
                    @endif

                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        {{ number_format($article->view_count) }} {{ Str::plural('view', $article->view_count) }}
                    </span>

                    @if($article->is_featured)
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            Featured
                        </span>
                    @endif
                </div>

                <!-- Article Content -->
                <div class="article-content mt-8">
                    {!! $article->content !!}
                </div>
            </div>

            <!-- Helpful Section -->
            @auth
                <div id="feedbackSection" class="bg-white rounded-xl shadow p-6 mb-6">
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-slate-900 mb-2">Was this article helpful?</h3>
                        <p class="text-sm text-slate-600 mb-4" id="feedbackMessage">
                            @if($userFeedback)
                                You rated this article as {{ $userFeedback->is_helpful ? 'helpful' : 'not helpful' }}. You can change your rating below.
                            @else
                                Let us know if you found this information useful
                            @endif
                        </p>
                        <div class="flex items-center justify-center gap-3">
                            <button
                                onclick="submitFeedback(true)"
                                id="helpfulBtn"
                                class="px-6 py-2 bg-green-100 hover:bg-green-200 text-green-800 font-medium rounded-lg transition-colors flex items-center {{ $userFeedback && $userFeedback->is_helpful ? 'ring-2 ring-green-500' : '' }}"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                                </svg>
                                Yes, helpful
                            </button>
                            <button
                                onclick="submitFeedback(false)"
                                id="notHelpfulBtn"
                                class="px-6 py-2 bg-red-100 hover:bg-red-200 text-red-800 font-medium rounded-lg transition-colors flex items-center {{ $userFeedback && !$userFeedback->is_helpful ? 'ring-2 ring-red-500' : '' }}"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"></path>
                                </svg>
                                No, not helpful
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-6">
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-blue-900 mb-2">Help us improve</h3>
                        <p class="text-blue-800 mb-4">Please <a href="{{ route('portal.login') }}" class="underline font-semibold">log in</a> to provide feedback on this article.</p>
                    </div>
                </div>
            @endauth

            <!-- Still Need Help -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-6">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-blue-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-blue-900 mb-1">Still need help?</h3>
                        <p class="text-blue-800 mb-4">If this article didn't solve your issue, our support team is ready to assist you.</p>
                        <a href="{{ route('portal.submit') }}" class="inline-flex items-center px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Submit a Support Ticket
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid md:grid-cols-2 gap-4">
                <a href="{{ route('portal.kb') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow text-center">
                    <svg class="w-10 h-10 text-green-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <h3 class="font-semibold text-slate-900 mb-1">Browse More Articles</h3>
                    <p class="text-sm text-slate-600">Find more solutions</p>
                </a>

                <a href="/" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow text-center">
                    <svg class="w-10 h-10 text-purple-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <h3 class="font-semibold text-slate-900 mb-1">Return to Portal</h3>
                    <p class="text-sm text-slate-600">Back to help desk</p>
                </a>
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
        function submitFeedback(isHelpful) {
            const helpfulBtn = document.getElementById('helpfulBtn');
            const notHelpfulBtn = document.getElementById('notHelpfulBtn');
            const feedbackMessage = document.getElementById('feedbackMessage');

            // Disable buttons during submission
            helpfulBtn.disabled = true;
            notHelpfulBtn.disabled = true;

            fetch('{{ route("portal.article.feedback") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    article_id: {{ $article->id }},
                    is_helpful: isHelpful
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI to show feedback
                    feedbackMessage.textContent = data.message;

                    // Update button styles
                    helpfulBtn.classList.remove('ring-2', 'ring-green-500');
                    notHelpfulBtn.classList.remove('ring-2', 'ring-red-500');

                    if (isHelpful) {
                        helpfulBtn.classList.add('ring-2', 'ring-green-500');
                    } else {
                        notHelpfulBtn.classList.add('ring-2', 'ring-red-500');
                    }

                    // Re-enable buttons
                    helpfulBtn.disabled = false;
                    notHelpfulBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                feedbackMessage.textContent = 'An error occurred. Please try again.';
                helpfulBtn.disabled = false;
                notHelpfulBtn.disabled = false;
            });
        }
    </script>
</body>
</html>
