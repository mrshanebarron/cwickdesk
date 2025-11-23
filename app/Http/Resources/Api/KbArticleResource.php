<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KbArticleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'category' => $this->category?->name,
            'category_id' => $this->category_id,
            'author' => [
                'id' => $this->author_id,
                'name' => $this->author?->name,
            ],
            'tags' => $this->tags ?? [],
            'view_count' => $this->view_count,
            'is_published' => $this->is_published,
            'is_featured' => $this->is_featured,
            'published_at' => $this->published_at?->toISOString(),
            'helpful_count' => $this->helpfulCount(),
            'not_helpful_count' => $this->notHelpfulCount(),
            'helpful_percentage' => $this->helpfulPercentage(),
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
        ];
    }
}
