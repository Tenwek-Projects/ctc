<?php

use App\Models\GalleryItem;
use App\Support\GalleryAlbums;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            $table->string('album_key', 120)->nullable()->after('caption')->index();
            $table->unsignedInteger('album_sort')->default(0)->after('album_key')->index();
        });

        $items = GalleryItem::query()
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->orderBy('id')
            ->get();

        if ($items->isEmpty()) {
            return;
        }

        $grouped = $items->groupBy(fn (GalleryItem $item) => GalleryAlbums::legacyGroupKey($item));
        $albumSort = 10;
        $usedKeys = [];

        foreach ($grouped as $legacyKey => $groupItems) {
            /** @var \Illuminate\Support\Collection<int, GalleryItem> $groupItems */
            $first = $groupItems->first();
            $baseKey = GalleryAlbums::makeAlbumKey((string) ($first?->title ?? 'gallery'), $first?->caption);
            $albumKey = $baseKey;
            $suffix = 2;
            while (isset($usedKeys[$albumKey])) {
                $albumKey = $baseKey.'-'.$suffix;
                $suffix++;
            }
            $usedKeys[$albumKey] = true;

            $itemSort = 10;
            foreach ($groupItems->values() as $item) {
                $item->forceFill([
                    'album_key' => $albumKey,
                    'album_sort' => $albumSort,
                    'sort_order' => $itemSort,
                ])->save();
                $itemSort += 10;
            }

            $albumSort += 10;
        }
    }

    public function down(): void
    {
        Schema::table('gallery_items', function (Blueprint $table) {
            $table->dropColumn(['album_key', 'album_sort']);
        });
    }
};
