<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class KbArticle extends Model
{
    use SoftDeletes, BelongsToTenant, LogsActivity;

    protected $fillable = [
        'category_id',
        'author_id',
        'title',
        'slug',
        'content',
        'excerpt',
        'tags',
        'view_count',
        'is_published',
        'is_featured',
        'published_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'view_count' => 'integer',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(KbCategory::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function feedback(): HasMany
    {
        return $this->hasMany(KbArticleFeedback::class);
    }

    public function helpfulCount(): int
    {
        return $this->feedback()->where('is_helpful', true)->count();
    }

    public function notHelpfulCount(): int
    {
        return $this->feedback()->where('is_helpful', false)->count();
    }

    public function helpfulPercentage(): int
    {
        $total = $this->feedback()->count();
        if ($total === 0) {
            return 0;
        }
        return (int) round(($this->helpfulCount() / $total) * 100);
    }
}
