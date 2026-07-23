<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

/**
 * Shared hosting often has a real public/storage directory instead of a symlink.
 * Mirror uploaded public-disk files so the web server can serve them.
 */
class PublicStorageMirror
{
    public static function publish(string $relativePath): void
    {
        $publicStorage = public_path('storage');

        if (is_link($publicStorage)) {
            return;
        }

        $source = Storage::disk('public')->path($relativePath);
        $target = $publicStorage.DIRECTORY_SEPARATOR.str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relativePath);
        $dir = dirname($target);

        if (! is_dir($dir) && ! mkdir($dir, 0755, true) && ! is_dir($dir)) {
            throw new \RuntimeException('Could not create public storage directory.');
        }

        if (! is_file($source) || ! @copy($source, $target)) {
            throw new \RuntimeException('Could not publish file to the public web folder.');
        }
    }

    public static function delete(string $relativePath): void
    {
        $publicStorage = public_path('storage');

        if (is_link($publicStorage)) {
            return;
        }

        $target = $publicStorage.DIRECTORY_SEPARATOR.str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relativePath);

        if (is_file($target)) {
            @unlink($target);
        }
    }
}
