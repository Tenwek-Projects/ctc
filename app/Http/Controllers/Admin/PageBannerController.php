<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Support\PageBanner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PageBannerController extends Controller
{
    public function index(): View
    {
        $pages = collect(config('page_banners.pages', []))
            ->map(function (array $page) {
                $key = $page['key'];
                $path = SiteSetting::getValue('page_banner.'.$key);
                $page['resolved_url'] = PageBanner::urlFor($key);
                $page['has_custom'] = (bool) $path;

                return $page;
            })
            ->all();

        $defaultUrl = PageBanner::defaultUrl();

        return view('admin-dashboard.page-banners.index', compact('pages', 'defaultUrl'));
    }

    public function update(Request $request, string $key): RedirectResponse
    {
        $this->assertAllowedKey($key);

        $request->validate([
            'banner' => ['required', 'image', 'max:5120'],
        ]);

        $settingKey = 'page_banner.'.$key;
        $old = SiteSetting::getValue($settingKey);
        if ($old && ! str_starts_with($old, 'http')) {
            Storage::disk('public')->delete($old);
            \App\Support\PublicStorageMirror::delete($old);
        }

        $path = $request->file('banner')->store('page-banners', 'public');
        \App\Support\PublicStorageMirror::publish($path);
        SiteSetting::setValue($settingKey, $path);

        return redirect()
            ->back()
            ->with('success', 'Banner updated for this page.');
    }

    public function destroy(string $key): RedirectResponse
    {
        $this->assertAllowedKey($key);

        $settingKey = 'page_banner.'.$key;
        $old = SiteSetting::getValue($settingKey);
        if ($old && ! str_starts_with($old, 'http')) {
            Storage::disk('public')->delete($old);
            \App\Support\PublicStorageMirror::delete($old);
        }

        SiteSetting::setValue($settingKey, null);

        return redirect()
            ->back()
            ->with('success', 'Custom banner removed; the site default is used again.');
    }

    private function assertAllowedKey(string $key): void
    {
        if (! in_array($key, PageBanner::allowedKeys(), true)) {
            abort(404);
        }
    }
}
