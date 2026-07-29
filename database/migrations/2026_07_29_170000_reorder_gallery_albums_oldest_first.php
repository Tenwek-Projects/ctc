<?php

use App\Models\GalleryItem;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Re-order albums so the first album added appears first (oldest → newest),
     * matching public gallery defaults until an admin manually reorders.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('gallery_items', 'album_key')) {
            return;
        }

        $albums = GalleryItem::query()
            ->whereNotNull('album_key')
            ->where('album_key', '!=', '')
            ->get(['id', 'album_key', 'created_at'])
            ->groupBy('album_key')
            ->map(function ($items, string $key) {
                return [
                    'key' => $key,
                    'created_at' => $items->min('created_at'),
                ];
            })
            ->sortBy('created_at')
            ->values();

        foreach ($albums as $position => $album) {
            GalleryItem::query()
                ->where('album_key', $album['key'])
                ->update(['album_sort' => ($position + 1) * 10]);
        }
    }

    public function down(): void
    {
        // Irreversible data correction — no-op.
    }
};
