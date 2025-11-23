<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\KbArticleResource;
use App\Models\KbArticle;
use App\Models\KbArticleFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KbArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = KbArticle::with(['category', 'author'])
            ->when(!$request->user()->can('kb.view.draft'), fn($q) => $q->where('is_published', true))
            ->when($request->category_id, fn($q, $id) => $q->where('category_id', $id))
            ->when($request->is_featured, fn($q) => $q->where('is_featured', true))
            ->when($request->search, fn($q, $search) =>
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
            )
            ->latest('published_at')
            ->paginate($request->per_page ?? 15);

        return KbArticleResource::collection($articles);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'category_id' => 'nullable|exists:kb_categories,id',
            'tags' => 'nullable|array',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['author_id'] = $request->user()->id;
        if ($validated['is_published'] ?? false) {
            $validated['published_at'] = now();
        }

        $article = KbArticle::create($validated);

        if ($article->is_published) {
            event(new \App\Events\KbArticlePublished($article));
        }

        return new KbArticleResource($article->load(['category', 'author']));
    }

    public function show(KbArticle $kbArticle)
    {
        // Increment view count
        $kbArticle->increment('view_count');

        return new KbArticleResource($kbArticle->load(['category', 'author']));
    }

    public function update(Request $request, KbArticle $kbArticle)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'excerpt' => 'nullable|string',
            'category_id' => 'nullable|exists:kb_categories,id',
            'tags' => 'nullable|array',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        if (isset($validated['title'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $wasUnpublished = !$kbArticle->is_published;
        if (($validated['is_published'] ?? false) && $wasUnpublished) {
            $validated['published_at'] = now();
        }

        $kbArticle->update($validated);

        if ($kbArticle->is_published && $wasUnpublished) {
            event(new \App\Events\KbArticlePublished($kbArticle));
        }

        return new KbArticleResource($kbArticle->fresh(['category', 'author']));
    }

    public function destroy(KbArticle $kbArticle)
    {
        $kbArticle->delete();

        return response()->json(['message' => 'Article deleted successfully']);
    }

    public function submitFeedback(Request $request, KbArticle $kbArticle)
    {
        $validated = $request->validate([
            'is_helpful' => 'required|boolean',
            'comment' => 'nullable|string',
        ]);

        $feedback = $kbArticle->feedback()->create([
            'user_id' => $request->user()->id,
            'is_helpful' => $validated['is_helpful'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return response()->json([
            'message' => 'Feedback submitted successfully',
            'feedback' => $feedback,
        ]);
    }
}
