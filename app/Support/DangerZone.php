<?php

namespace App\Support;

use App\Models\ApplicantDocument;
use App\Models\Booking;
use App\Models\CollegeApplication;
use App\Models\ContactEnquiry;
use App\Models\GalleryItem;
use App\Models\HeroSlide;
use App\Models\ImpactStory;
use App\Models\ImpactTestimonial;
use App\Models\NewsArticle;
use App\Models\TwoFactorCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class DangerZone
{
    /**
     * @return array<string, array{label: string, description: string, group: string}>
     */
    public static function datasets(): array
    {
        return [
            'bookings' => [
                'label' => 'Bookings / appointments',
                'description' => 'All appointment requests submitted from the public site.',
                'group' => 'Submissions',
            ],
            'enquiries' => [
                'label' => 'Contact enquiries',
                'description' => 'Messages sent through the Contact form.',
                'group' => 'Submissions',
            ],
            'college_applications' => [
                'label' => 'College applications',
                'description' => 'Applications and related applicant records (including uploaded documents). Permanently deleted.',
                'group' => 'Submissions',
            ],
            'two_factor_codes' => [
                'label' => 'Two-factor login codes',
                'description' => 'Temporary 2FA codes issued for admin sign-in.',
                'group' => 'Submissions',
            ],
            'gallery' => [
                'label' => 'Gallery items',
                'description' => 'Public gallery images and captions.',
                'group' => 'Content',
            ],
            'news' => [
                'label' => 'News / articles',
                'description' => 'News, events, and announcements.',
                'group' => 'Content',
            ],
            'impact_stories' => [
                'label' => 'Impact stories',
                'description' => 'Impact page stories and featured success content.',
                'group' => 'Content',
            ],
            'impact_testimonials' => [
                'label' => 'Impact testimonials',
                'description' => 'Testimonials shown on the Impact page.',
                'group' => 'Content',
            ],
            'hero_slides' => [
                'label' => 'Hero carousel slides',
                'description' => 'Homepage carousel slides (does not change hero mode or still image).',
                'group' => 'Content',
            ],
        ];
    }

    /**
     * @return list<string>
     */
    public static function keys(): array
    {
        return array_keys(self::datasets());
    }

    public static function count(string $key): int
    {
        return match ($key) {
            'bookings' => Booking::query()->count(),
            'enquiries' => ContactEnquiry::query()->count(),
            'college_applications' => CollegeApplication::withTrashed()->count(),
            'two_factor_codes' => TwoFactorCode::query()->count(),
            'gallery' => GalleryItem::query()->count(),
            'news' => NewsArticle::query()->count(),
            'impact_stories' => ImpactStory::query()->count(),
            'impact_testimonials' => ImpactTestimonial::query()->count(),
            'hero_slides' => HeroSlide::query()->count(),
            default => 0,
        };
    }

    /**
     * @param  list<string>  $keys
     * @return array<string, int> deleted counts by key
     *
     * @throws Throwable
     */
    public static function purge(array $keys): array
    {
        $allowed = array_flip(self::keys());
        $selected = array_values(array_filter($keys, fn ($key) => isset($allowed[$key])));
        $deleted = [];

        DB::transaction(function () use ($selected, &$deleted): void {
            foreach ($selected as $key) {
                $deleted[$key] = self::purgeOne($key);
            }
        });

        return $deleted;
    }

    private static function purgeOne(string $key): int
    {
        return match ($key) {
            'bookings' => self::deleteAll(Booking::query()),
            'enquiries' => self::deleteAll(ContactEnquiry::query()),
            'college_applications' => self::purgeCollegeApplications(),
            'two_factor_codes' => self::deleteAll(TwoFactorCode::query()),
            'gallery' => self::purgeGallery(),
            'news' => self::purgeNews(),
            'impact_stories' => self::purgeImpactStories(),
            'impact_testimonials' => self::deleteAll(ImpactTestimonial::query()),
            'hero_slides' => self::purgeHeroSlides(),
            default => 0,
        };
    }

    private static function deleteAll($query): int
    {
        $count = (clone $query)->count();
        $query->delete();

        return $count;
    }

    private static function purgeCollegeApplications(): int
    {
        $applications = CollegeApplication::withTrashed()->get();
        $count = $applications->count();

        foreach ($applications as $application) {
            $documents = ApplicantDocument::withTrashed()
                ->where('college_application_id', $application->id)
                ->get();

            foreach ($documents as $document) {
                self::deleteStoredPath($document->storage_disk ?: 'public', $document->storage_path);
            }

            $application->forceDelete();
        }

        return $count;
    }

    private static function purgeGallery(): int
    {
        $items = GalleryItem::query()->get();
        $count = $items->count();

        foreach ($items as $item) {
            if ($item->isStoredUpload()) {
                self::deleteStoredPath('public', $item->image_url);
            }
            $item->delete();
        }

        return $count;
    }

    private static function purgeNews(): int
    {
        $items = NewsArticle::query()->get();
        $count = $items->count();

        foreach ($items as $item) {
            if ($item->featured_image && ! str_starts_with((string) $item->featured_image, 'http')) {
                self::deleteStoredPath('public', $item->featured_image);
            }
            $item->delete();
        }

        return $count;
    }

    private static function purgeImpactStories(): int
    {
        $items = ImpactStory::query()->get();
        $count = $items->count();

        foreach ($items as $item) {
            foreach (['image_path', 'image'] as $field) {
                $path = $item->{$field} ?? null;
                if (filled($path) && ! str_starts_with((string) $path, 'http')) {
                    self::deleteStoredPath('public', (string) $path);
                }
            }
            $item->delete();
        }

        return $count;
    }

    private static function purgeHeroSlides(): int
    {
        $items = HeroSlide::query()->get();
        $count = $items->count();

        foreach ($items as $item) {
            if ($item->image_path && ! str_starts_with((string) $item->image_path, 'http')) {
                self::deleteStoredPath('public', $item->image_path);
            }
            $item->delete();
        }

        return $count;
    }

    private static function deleteStoredPath(string $disk, ?string $path): void
    {
        if (! filled($path) || str_starts_with((string) $path, 'http://') || str_starts_with((string) $path, 'https://')) {
            return;
        }

        try {
            Storage::disk($disk)->delete((string) $path);
            if ($disk === 'public') {
                PublicStorageMirror::delete((string) $path);
            }
        } catch (Throwable $e) {
            report($e);
        }
    }
}
