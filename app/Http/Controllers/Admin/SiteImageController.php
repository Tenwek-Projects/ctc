<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\PageBanner;
use App\Support\SiteImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteImageController extends Controller
{
    public function index(): View
    {
        $slots = collect(SiteImage::slots())
            ->map(function (array $slot) {
                $key = (string) $slot['key'];
                $dims = SiteImage::dimensions($key);
                $slot['resolved_url'] = SiteImage::urlFor($key);
                $slot['has_custom'] = SiteImage::hasCustom($key);
                $slot['width'] = $dims['width'];
                $slot['height'] = $dims['height'];
                $slot['bytes'] = $dims['bytes'];

                return $slot;
            })
            ->groupBy(fn (array $slot) => $slot['group'] ?? 'Other');

        $pageBanners = collect(config('page_banners.pages', []))
            ->map(function (array $page) {
                $key = $page['key'];
                $page['resolved_url'] = PageBanner::urlFor($key);
                $page['has_custom'] = (bool) \App\Models\SiteSetting::getValue('page_banner.'.$key);

                return $page;
            })
            ->all();

        $contentManagers = config('site_images.content_managers', []);

        return view('admin-dashboard.site-images.index', compact('slots', 'pageBanners', 'contentManagers'));
    }

    public function update(Request $request, string $key): RedirectResponse
    {
        if (! in_array($key, SiteImage::allowedKeys(), true)) {
            abort(404);
        }

        $slot = SiteImage::slot($key);
        $maxKb = (int) ($slot['max_kb'] ?? 5120);

        $request->validate([
            'image' => ['required', 'image', 'max:'.$maxKb],
        ]);

        try {
            SiteImage::store($key, $request->file('image'));
        } catch (\Throwable $e) {
            report($e);

            return redirect()
                ->route('admin-dashboard.site-images.index')
                ->with('error', 'Could not save the image. Ensure storage and public/storage/'.$slot['folder'].' are writable.');
        }

        return redirect()
            ->route('admin-dashboard.site-images.index')
            ->with('success', ($slot['label'] ?? 'Image').' updated.');
    }

    public function destroy(string $key): RedirectResponse
    {
        if (! in_array($key, SiteImage::allowedKeys(), true)) {
            abort(404);
        }

        $slot = SiteImage::slot($key);
        SiteImage::clear($key);

        return redirect()
            ->route('admin-dashboard.site-images.index')
            ->with('success', ($slot['label'] ?? 'Image').' cleared; the default is used again.');
    }
}
