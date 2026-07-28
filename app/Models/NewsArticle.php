<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\PublicAssetUrl;

class NewsArticle extends Model
{
    public const TYPE_NEWS = 'news';
    public const TYPE_EVENT = 'event';
    public const TYPE_ANNOUNCEMENT = 'announcement';

    protected $fillable = [
        'title',
        'slug',
        'type',
        'excerpt',
        'body',
        'featured_image',
        'event_date',
        'published_at',
        'is_published',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function getFeaturedImageUrlAttribute(): ?string
    {
        return PublicAssetUrl::toUrl($this->featured_image);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where(function ($q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public function scopeLatest($query)
    {
        return $query->orderByDesc('published_at')->orderByDesc('created_at');
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeEvents($query)
    {
        return $query->where('type', self::TYPE_EVENT);
    }
}
