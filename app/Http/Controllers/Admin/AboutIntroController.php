<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResourceDownload;
use App\Models\SiteSetting;
use App\Support\PublicAssetUrl;
use App\Support\TrixHtmlSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AboutIntroController extends Controller
{
    public function edit(): View
    {
        $data = [
            'kicker' => SiteSetting::getValue('about.who_we_are.kicker', 'Who we are'),
            'heading' => SiteSetting::getValue('about.who_we_are.heading', 'Specialist heart & chest care, grounded in compassion'),
            'body' => SiteSetting::getValue('about.who_we_are.body', "The Cardiothoracic Centre (CTC) at Tenwek Hospital provides comprehensive care for adult and pediatric patients with cardiac and thoracic conditions,\nfrom diagnosis through surgery and follow‑up."),
            'bullets' => [
                SiteSetting::getValue('about.who_we_are.bullet_1', 'Integrated teams across surgery, anesthesia, ICU, nursing, and diagnostics.'),
                SiteSetting::getValue('about.who_we_are.bullet_2', 'Focused on safe, evidence‑based care with long‑term follow‑up.'),
                SiteSetting::getValue('about.who_we_are.bullet_3', 'Training and mentorship that strengthens local capacity across Africa.'),
            ],
            'images' => [
                'main' => PublicAssetUrl::toUrl(SiteSetting::getValue('about.who_we_are.image_main_path')),
                'side_1' => PublicAssetUrl::toUrl(SiteSetting::getValue('about.who_we_are.image_side_1_path')),
                'side_2' => PublicAssetUrl::toUrl(SiteSetting::getValue('about.who_we_are.image_side_2_path')),
            ],
            'executiveBrochure' => ResourceDownload::findBySlug('ctc-executive-brochure'),
        ];

        return view('admin-dashboard.about.intro', $data);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kicker' => ['required', 'string', 'max:80'],
            'heading' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:20000'],
            'bullet_1' => ['required', 'string', 'max:255'],
            'bullet_2' => ['required', 'string', 'max:255'],
            'bullet_3' => ['required', 'string', 'max:255'],
            'image_main' => ['nullable', 'image', 'max:5120'],
            'image_side_1' => ['nullable', 'image', 'max:5120'],
            'image_side_2' => ['nullable', 'image', 'max:5120'],
        ]);

        $sanitizedBody = TrixHtmlSanitizer::sanitize($validated['body']);

        SiteSetting::setValue('about.who_we_are.kicker', $validated['kicker']);
        SiteSetting::setValue('about.who_we_are.heading', $validated['heading']);
        SiteSetting::setValue('about.who_we_are.body', $sanitizedBody);
        SiteSetting::setValue('about.who_we_are.bullet_1', $validated['bullet_1']);
        SiteSetting::setValue('about.who_we_are.bullet_2', $validated['bullet_2']);
        SiteSetting::setValue('about.who_we_are.bullet_3', $validated['bullet_3']);

        $this->maybeStoreImage($request, 'image_main', 'about.who_we_are.image_main_path');
        $this->maybeStoreImage($request, 'image_side_1', 'about.who_we_are.image_side_1_path');
        $this->maybeStoreImage($request, 'image_side_2', 'about.who_we_are.image_side_2_path');

        return redirect()
            ->route('admin-dashboard.about-intro.edit')
            ->with('success', 'Who we are section updated.');
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
