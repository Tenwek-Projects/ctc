<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\PublicAssetUrl;

class Service extends Model
{
    public const CATEGORY_CARDIAC = 'cardiac_surgery';
    public const CATEGORY_THORACIC = 'thoracic_surgery';
    public const CATEGORY_DIAGNOSTICS = 'diagnostics';

    protected $fillable = [
        'category',
        'name',
        'description',
        'featured_image_path',
        'slug',
        'sort_order',
        'is_visible',
        'show_on_homepage',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'show_on_homepage' => 'boolean',
    ];

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeOnHomepage($query)
    {
        return $query->where('show_on_homepage', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function scopeInCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public static function categoryLabel(string $category): string
    {
        return match ($category) {
            self::CATEGORY_CARDIAC => 'Cardiac surgery',
            self::CATEGORY_THORACIC => 'Thoracic surgery',
            self::CATEGORY_DIAGNOSTICS => 'Diagnostics',
            default => str_replace('_', ' ', ucfirst($category)),
        };
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        return PublicAssetUrl::toUrl($this->featured_image_path);
    }
}
