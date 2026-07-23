<?php

namespace App\Support;

use App\Models\SiteSetting;

class PageBanner
{
    public static function allowedKeys(): array
    {
        return collect(config('page_banners.pages', []))
            ->pluck('key')
            ->all();
    }

    public static function defaultUrl(): string
    {
        return (string) (SiteImage::urlFor('page_banner_default') ?: config('ctc.page_banner_image', ''));
    }

    public static function urlFor(?string $key): string
    {
        $default = self::defaultUrl();

        if (! $key || ! in_array($key, self::allowedKeys(), true)) {
            return $default;
        }

        $path = SiteSetting::getValue('page_banner.'.$key);
        if (! $path) {
            return $default;
        }

        return PublicAssetUrl::toUrl($path) ?: $default;
    }
}
