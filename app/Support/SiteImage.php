<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SiteImage
{
    /** @var array<string, string|null> */
    private static array $urlMemo = [];

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function slots(): array
    {
        return config('site_images.slots', []);
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function slot(string $key): ?array
    {
        foreach (self::slots() as $slot) {
            if (($slot['key'] ?? null) === $key) {
                return $slot;
            }
        }

        return null;
    }

    /**
     * @return list<string>
     */
    public static function allowedKeys(): array
    {
        return collect(self::slots())->pluck('key')->all();
    }

    public static function cacheKey(string $key): string
    {
        return 'site_image.url.'.$key;
    }

    public static function forgetUrlCache(?string $key = null): void
    {
        if ($key === null) {
            foreach (self::allowedKeys() as $allowed) {
                self::forgetUrlCache($allowed);
            }

            return;
        }

        unset(self::$urlMemo[$key]);
        Cache::forget(self::cacheKey($key));
    }

    public static function urlFor(string $key): ?string
    {
        if (array_key_exists($key, self::$urlMemo)) {
            return self::$urlMemo[$key];
        }

        $url = Cache::rememberForever(self::cacheKey($key), fn () => self::resolveUrlFor($key));
        self::$urlMemo[$key] = $url;

        return $url;
    }

    private static function resolveUrlFor(string $key): ?string
    {
        $slot = self::slot($key);
        if (! $slot) {
            return null;
        }

        $path = self::resolvedPath($slot);

        if (filled($path)) {
            if (str_starts_with((string) $path, 'http://') || str_starts_with((string) $path, 'https://')) {
                return (string) $path;
            }

            $relative = (string) $path;
            if (Storage::disk('public')->exists($relative)) {
                try {
                    $publicStorage = public_path('storage');
                    if (! is_link($publicStorage)) {
                        $mirrored = $publicStorage.DIRECTORY_SEPARATOR.str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relative);
                        if (! is_file($mirrored)) {
                            PublicStorageMirror::publish($relative);
                        }
                    }
                } catch (\Throwable $e) {
                    report($e);
                }
            }

            $url = PublicAssetUrl::toUrl($relative);
            if ($url) {
                return $url;
            }
        }

        return self::fallbackUrl($slot);
    }

    /**
     * @param  array<string, mixed>  $slot
     */
    public static function resolvedPath(array $slot): ?string
    {
        $settingKey = (string) ($slot['setting_key'] ?? '');
        if ($settingKey && filled($path = SiteSetting::getValue($settingKey))) {
            return (string) $path;
        }

        foreach (($slot['legacy_setting_keys'] ?? []) as $legacyKey) {
            if (filled($path = SiteSetting::getValue((string) $legacyKey))) {
                return (string) $path;
            }
        }

        return null;
    }

    /**
     * @param  array<string, mixed>  $slot
     */
    public static function fallbackUrl(array $slot): ?string
    {
        if (! empty($slot['fallback_asset'])) {
            return asset((string) $slot['fallback_asset']);
        }

        if (! empty($slot['fallback_config'])) {
            $value = config((string) $slot['fallback_config']);
            if (! filled($value)) {
                return null;
            }

            $value = (string) $value;
            if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
                return $value;
            }

            // Prefer files that live directly under public/ (e.g. hero.jpg).
            if (is_file(public_path($value))) {
                return asset($value);
            }

            // Otherwise treat as a public-disk path (storage/app/public/...).
            return PublicAssetUrl::toUrl($value) ?: asset($value);
        }

        return null;
    }

    public static function store(string $key, UploadedFile $file): string
    {
        $slot = self::slot($key);
        if (! $slot) {
            throw new \InvalidArgumentException("Unknown site image slot [{$key}].");
        }

        $settingKey = (string) $slot['setting_key'];
        $folder = (string) ($slot['folder'] ?? 'site');

        self::deleteStored(SiteSetting::getValue($settingKey));

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg');
        if (! in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
            $extension = 'jpg';
        }

        $filename = Str::slug($key).'-'.time().'.'.$extension;
        $disk = Storage::disk('public');

        if (! $disk->exists($folder)) {
            $disk->makeDirectory($folder);
        }

        $path = $file->storeAs($folder, $filename, 'public');
        if (! $path || ! $disk->exists($path)) {
            throw new \RuntimeException('Failed to store site image.');
        }

        PublicStorageMirror::publish($path);
        SiteSetting::setValue($settingKey, $path);

        foreach (($slot['legacy_setting_keys'] ?? []) as $legacyKey) {
            SiteSetting::setValue((string) $legacyKey, null);
        }

        self::forgetUrlCache($key);

        return $path;
    }

    public static function clear(string $key): void
    {
        $slot = self::slot($key);
        if (! $slot) {
            throw new \InvalidArgumentException("Unknown site image slot [{$key}].");
        }

        $settingKey = (string) $slot['setting_key'];
        self::deleteStored(SiteSetting::getValue($settingKey));
        SiteSetting::setValue($settingKey, null);

        foreach (($slot['legacy_setting_keys'] ?? []) as $legacyKey) {
            self::deleteStored(SiteSetting::getValue((string) $legacyKey));
            SiteSetting::setValue((string) $legacyKey, null);
        }

        self::forgetUrlCache($key);
    }

    public static function hasCustom(string $key): bool
    {
        $slot = self::slot($key);
        if (! $slot) {
            return false;
        }

        return filled(self::resolvedPath($slot));
    }

    /**
     * Read width/height/filesize for the currently resolved image when local.
     *
     * @return array{width: ?int, height: ?int, bytes: ?int, path: ?string}
     */
    public static function dimensions(string $key): array
    {
        $slot = self::slot($key);
        $empty = ['width' => null, 'height' => null, 'bytes' => null, 'path' => null];
        if (! $slot) {
            return $empty;
        }

        $path = self::resolvedPath($slot);

        $absolute = null;
        if (filled($path) && ! str_starts_with((string) $path, 'http')) {
            $absolute = Storage::disk('public')->path((string) $path);
        } elseif (! filled($path) && ! empty($slot['fallback_asset'])) {
            $absolute = public_path((string) $slot['fallback_asset']);
        }

        if (! $absolute || ! is_file($absolute)) {
            return $empty;
        }

        $info = @getimagesize($absolute);
        $bytes = @filesize($absolute);

        return [
            'width' => is_array($info) ? (int) $info[0] : null,
            'height' => is_array($info) ? (int) $info[1] : null,
            'bytes' => $bytes !== false ? (int) $bytes : null,
            'path' => filled($path) ? (string) $path : (string) ($slot['fallback_asset'] ?? null),
        ];
    }

    private static function deleteStored(mixed $path): void
    {
        if (! filled($path) || str_starts_with((string) $path, 'http')) {
            return;
        }

        $relative = (string) $path;
        Storage::disk('public')->delete($relative);
        PublicStorageMirror::delete($relative);
    }
}
