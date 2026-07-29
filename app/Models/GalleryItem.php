<?php

namespace App\Models;

use App\Support\PublicAssetUrl;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    protected $fillable = [
        'title',
        'caption',
        'album_key',
        'album_sort',
        'image_url',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'album_sort' => 'integer',
        'sort_order' => 'integer',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered($query)
    {
        return $query
            ->orderBy('album_sort')
            ->orderBy('sort_order')
            ->orderByDesc('created_at');
    }

    /** Absolute URL for image src; supports HTTPS URLs and public-disk paths. */
    public function resolvedImageUrl(): string
    {
        if (! $this->image_url) {
            return '';
        }

        return PublicAssetUrl::toUrl($this->image_url) ?: $this->image_url;
    }

    public function isStoredUpload(): bool
    {
        $v = $this->image_url;

        return (bool) $v && ! str_starts_with($v, 'http://') && ! str_starts_with($v, 'https://');
    }
}
