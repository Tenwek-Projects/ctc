<?php

namespace App\Models;

use App\Support\PublicAssetUrl;
use Illuminate\Database\Eloquent\Model;

class DepartmentPage extends Model
{
    protected $fillable = [
        'url_segment',
        'admin_label',
        'meta_title',
        'meta_description',
        'intro_kicker',
        'intro_heading',
        'intro_subheading',
        'body_html',
        'featured_image_path',
        'is_visible',
        'sort_order',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'url_segment';
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('admin_label');
    }

    public function featuredImageUrl(): ?string
    {
        return PublicAssetUrl::toUrl($this->featured_image_path);
    }
}
