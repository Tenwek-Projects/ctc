<?php

namespace App\Models;

use App\Support\PublicAssetUrl;
use Illuminate\Database\Eloquent\Model;

class HistoryGalleryItem extends Model
{
    protected $fillable = [
        'title',
        'caption',
        'image_path',
        'sort_order',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('created_at');
    }

    public function imageUrl(): string
    {
        return PublicAssetUrl::toUrl($this->image_path) ?: '';
    }
}
