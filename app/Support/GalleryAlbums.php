<?php

namespace App\Support;

use App\Models\GalleryItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class GalleryAlbums
{
    public static function legacyGroupKey(GalleryItem $item): string
    {
        $captionKey = self::normalizeText(strip_tags((string) $item->caption));
        if ($captionKey !== '') {
            return mb_strtolower($captionKey);
        }

        $baseTitle = self::baseTitle((string) $item->title);

        return mb_strtolower($baseTitle !== '' ? $baseTitle : 'gallery');
    }

    public static function makeAlbumKey(string $title, ?string $caption = null): string
    {
        $captionText = self::normalizeText(strip_tags((string) $caption));
        $source = $captionText !== '' ? $captionText : self::baseTitle($title);
        $slug = Str::slug(Str::limit($source !== '' ? $source : 'gallery', 80, ''));

        return $slug !== '' ? $slug : 'gallery';
    }

    public static function displayTitle(GalleryItem $item): string
    {
        $captionText = self::normalizeText(strip_tags((string) $item->caption));
        if ($captionText !== '') {
            return Str::limit($captionText, 90);
        }

        $baseTitle = self::baseTitle((string) $item->title);

        return $baseTitle !== '' ? $baseTitle : 'Gallery';
    }

    public static function baseTitle(string $title): string
    {
        return self::normalizeText(preg_replace('/\s+#\d+$/u', '', $title) ?? '');
    }

    /**
     * @param  Collection<int, GalleryItem>  $items
     * @return Collection<int, array{key: string, title: string, caption_html: ?string, album_sort: int, items: Collection<int, GalleryItem>}>
     */
    public static function buildGroups(Collection $items): Collection
    {
        return $items
            ->groupBy(function (GalleryItem $item) {
                if (filled($item->album_key)) {
                    return (string) $item->album_key;
                }

                return self::legacyGroupKey($item);
            })
            ->map(function (Collection $groupItems, string $key) {
                $ordered = $groupItems->sortBy([
                    ['sort_order', 'asc'],
                    ['created_at', 'asc'],
                    ['id', 'asc'],
                ])->values();

                $first = $ordered->first();
                $createdAt = $groupItems
                    ->map(fn (GalleryItem $item) => optional($item->created_at)?->getTimestamp() ?? 0)
                    ->min();

                return [
                    'key' => $key,
                    'title' => $first ? self::displayTitle($first) : 'Gallery',
                    'caption_html' => $first?->caption,
                    'album_sort' => (int) ($ordered->min('album_sort') ?? 0),
                    'created_at' => (int) $createdAt,
                    'items' => $ordered,
                ];
            })
            ->sortBy([
                ['album_sort', 'asc'],
                ['created_at', 'asc'],
                ['title', 'asc'],
            ])
            ->values();
    }

    /**
     * Pack consecutive single-photo albums into pairs for a 2-up public layout.
     *
     * @param  Collection<int, array{key: string, title: string, caption_html: ?string, album_sort: int, items: Collection<int, GalleryItem>}>  $groups
     * @return Collection<int, array{type: string, groups: Collection<int, array>}>
     */
    public static function packRows(Collection $groups): Collection
    {
        $rows = collect();
        $pending = collect();

        $flushPending = function () use (&$rows, &$pending): void {
            if ($pending->isEmpty()) {
                return;
            }
            $rows->push([
                'type' => 'pair',
                'groups' => $pending->values(),
            ]);
            $pending = collect();
        };

        foreach ($groups as $group) {
            if ($group['items']->count() === 1) {
                $pending->push($group);
                if ($pending->count() === 2) {
                    $flushPending();
                }
                continue;
            }

            $flushPending();
            $rows->push([
                'type' => 'full',
                'groups' => collect([$group]),
            ]);
        }

        $flushPending();

        return $rows;
    }

    public static function nextAlbumSort(): int
    {
        return ((int) GalleryItem::query()->max('album_sort')) + 10;
    }

    public static function nextSortOrderForAlbum(string $albumKey): int
    {
        $max = GalleryItem::query()
            ->where('album_key', $albumKey)
            ->max('sort_order');

        return ((int) $max) + 10;
    }

    private static function normalizeText(string $value): string
    {
        return trim(preg_replace('/\s+/u', ' ', $value) ?? '');
    }
}
