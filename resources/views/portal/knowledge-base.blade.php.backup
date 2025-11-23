<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knowledge Base - IT Help Desk</title>
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
                <a href="/" class="text-sm text-slate-600 hover:text-amber-600 transition-colors">
                    ← Back to Portal
                </a>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-12">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-slate-900 mb-2">Knowledge Base</h2>
            <p class="text-slate-600">Find solutions, guides, and helpful articles</p>
        </div>

        <!-- Search Bar -->
        <div class="max-w-2xl mx-auto mb-12">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <form action="{{ route('portal.kb') }}" method="GET">
                    <div class="flex gap-3">
                        <div class="flex-1 relative">
                            <input
                                type="text"
                                name="search"
                                placeholder="Search for articles, guides, or solutions..."
                                value="{{ request('search') }}"
                                class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                            >
                            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <button type="submit" class="px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Categories Section -->
        @if($categories->count() > 0)
            <div class="mb-12">
                <h3 class="text-2xl font-bold text-slate-900 mb-6">Browse by Category</h3>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($categories as $category)
                        <a href="{{ route('portal.kb', ['category' => $category->id]) }}" class="bg-white rounded-xl shadow p-6 hover:shadow-lg transition-all transform hover:-translate-y-1">
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-gradient-to-br from-amber-400 to-amber-600 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-slate-900 mb-1">{{ $category->name }}</h4>
                                    @if($category->description)
                                        <p class="text-sm text-slate-600">{{ Str::limit($category->description, 60) }}</p>
                                    @endif
                                    <p class="text-xs text-amber-600 mt-2">
                                        {{ $category->articles->count() }} {{ Str::plural('article', $category->articles->count()) }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Featured/Popular Articles -->
        @if($articles->count() > 0)
            <div class="mb-12">
                <h3 class="text-2xl font-bold text-slate-900 mb-6">Popular Articles</h3>
                <div class="space-y-4">
                    @foreach($articles as $article)
                        <a href="{{ route('portal.article', $article->slug) }}" class="block bg-white rounded-xl shadow hover:shadow-lg transition-shadow p-6">
                            <div class="flex items-start">
                                <!-- Article Icon -->
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>

                                <!-- Article Content -->
                                <div class="flex-1">
                                    <h4 class="text-lg font-semibold text-slate-900 mb-2">{{ $article->title }}</h4>

                                    @if($article->excerpt)
                                        <p class="text-slate-600 mb-3">{{ Str::limit($article->excerpt, 150) }}</p>
                                    @endif

                                    <!-- Article Meta -->
                                    <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500">
                                        @if($article->category)
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                </svg>
                                                {{ $article->category->name }}
                                            </span>
                                        @endif

                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            {{ number_format($article->view_count) }} {{ Str::plural('view', $article->view_count) }}
                                        </span>

                                        @if($article->created_at)
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $article->created_at->format('M j, Y') }}
                                            </span>
                                        @endif

                                        @if($article->is_featured)
                                            <span class="px-2 py-1 bg-amber-100 text-amber-800 text-xs font-semibold rounded">
                                                Featured
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Arrow Icon -->
                                <div class="ml-4 flex-shrink-0">
                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <!-- No Articles Found -->
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">No Articles Found</h3>
                    <p class="text-slate-600 mb-6">
                        @if(request('search'))
                            No articles match your search. Try different keywords or browse by category.
                        @else
                            Our knowledge base is being updated. Check back soon for helpful articles and guides.
                        @endif
                    </p>
                    <a href="{{ route('portal.submit') }}" class="inline-flex items-center px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Submit a Ticket Instead
                    </a>
                </div>
            </div>
        @endif

        <!-- Need More Help -->
        <div class="max-w-4xl mx-auto mt-12">
            <div class="bg-slate-800 rounded-2xl p-8 text-center text-white">
                <h3 class="text-xl font-bold mb-4">Can't Find What You're Looking For?</h3>
                <p class="text-slate-300 mb-6">Our support team is here to help you with any questions or issues</p>
                <div class="flex flex-col md:flex-row items-center justify-center gap-4">
                    <a href="{{ route('portal.submit') }}" class="px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all">
                        Submit a Ticket
                    </a>
                    <div class="flex items-center text-slate-300">
                        <svg class="w-5 h-5 mr-2 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Call: <strong class="ml-1">Ext. 4357</strong>
                    </div>
                    <div class="flex items-center text-slate-300">
                        <svg class="w-5 h-5 mr-2 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <a href="mailto:helpdesk@company.com" class="hover:text-white"><strong>helpdesk@company.com</strong></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-16 py-6 border-t border-slate-200">
        <div class="container mx-auto px-4 text-center text-sm text-slate-600">
            <p>IT Help Desk Portal &copy; 2025 &bull; Available 24/7</p>
        </div>
    </footer>
</body>
</html>
