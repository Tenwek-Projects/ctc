<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Support\PublicAssetUrl;
use App\Support\TrixHtmlSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AboutPurposeController extends Controller
{
    public function edit(): View
    {
        return view('admin-dashboard.about.purpose', [
            'kicker' => SiteSetting::getValue('about.purpose.kicker', 'Purpose'),
            'heading' => SiteSetting::getValue('about.purpose.heading', 'Mission & Vision'),

            'mission_kicker' => SiteSetting::getValue('about.purpose.mission.kicker', 'Mission'),
            'mission_title' => SiteSetting::getValue('about.purpose.mission.title', 'A Christian community'),
            'mission_body' => SiteSetting::getValue('about.purpose.mission.body', 'A Christian community committed to excellence in compassionate healthcare, spiritual ministry and training for service in the glory of God.'),

            'vision_kicker' => SiteSetting::getValue('about.purpose.vision.kicker', 'Vision'),
            'vision_title' => SiteSetting::getValue('about.purpose.vision.title', 'Christ-transformed health, lives and world'),
            'vision_body' => SiteSetting::getValue('about.purpose.vision.body', 'Christ-transformed health, lives and world.'),

            'right_kicker' => SiteSetting::getValue('about.purpose.right.kicker', 'Purpose Statement'),
            'right_title' => SiteSetting::getValue('about.purpose.right.title', 'Purpose Statement & Golden Rules'),
            'right_body' => SiteSetting::getValue('about.purpose.right.body', 'To glorify God through provision of holistic (physical, mental, emotional, social, and spiritual) patient- and family-centered cardiothoracic care.'),
            'right_image_url' => PublicAssetUrl::toUrl(SiteSetting::getValue('about.purpose.right.image_path')),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kicker' => ['required', 'string', 'max:80'],
            'heading' => ['required', 'string', 'max:255'],

            'mission_kicker' => ['required', 'string', 'max:80'],
            'mission_title' => ['required', 'string', 'max:255'],
            'mission_body' => ['required', 'string', 'max:20000'],

            'vision_kicker' => ['required', 'string', 'max:80'],
            'vision_title' => ['required', 'string', 'max:255'],
            'vision_body' => ['required', 'string', 'max:20000'],

            'right_kicker' => ['required', 'string', 'max:80'],
            'right_title' => ['required', 'string', 'max:255'],
            'right_body' => ['required', 'string', 'max:20000'],
            'right_image' => ['nullable', 'image', 'max:5120'],
        ]);

        SiteSetting::setValue('about.purpose.kicker', $validated['kicker']);
        SiteSetting::setValue('about.purpose.heading', $validated['heading']);

        SiteSetting::setValue('about.purpose.mission.kicker', $validated['mission_kicker']);
        SiteSetting::setValue('about.purpose.mission.title', $validated['mission_title']);
        SiteSetting::setValue('about.purpose.mission.body', TrixHtmlSanitizer::sanitize($validated['mission_body']));

        SiteSetting::setValue('about.purpose.vision.kicker', $validated['vision_kicker']);
        SiteSetting::setValue('about.purpose.vision.title', $validated['vision_title']);
        SiteSetting::setValue('about.purpose.vision.body', TrixHtmlSanitizer::sanitize($validated['vision_body']));

        SiteSetting::setValue('about.purpose.right.kicker', $validated['right_kicker']);
        SiteSetting::setValue('about.purpose.right.title', $validated['right_title']);
        SiteSetting::setValue('about.purpose.right.body', TrixHtmlSanitizer::sanitize($validated['right_body']));

        $this->maybeStoreImage($request, 'right_image', 'about.purpose.right.image_path');

        return redirect()
            ->route('admin-dashboard.about-purpose.edit')
            ->with('success', 'Purpose section updated.');
    }

    private function maybeStoreImage(Request $request, string $fileKey, string $settingKey): void
    {
        if (! $request->hasFile($fileKey)) {
            return;
        }

        $old = SiteSetting::getValue($settingKey);
        if ($old && ! str_starts_with($old, 'http')) {
            Storage::disk('public')->delete($old);
        }

        $path = $request->file($fileKey)->store('about', 'public');
        SiteSetting::setValue($settingKey, $path);
    }
}
