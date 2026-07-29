<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use App\Support\TrixHtmlSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class GalleryItemController extends Controller
{
    /** Max size per image in kilobytes (Laravel validation). */
    private const MAX_IMAGE_KB = 10240;

    public function index(): View
    {
        $items = GalleryItem::query()->ordered()->paginate(20);

        return view('admin-dashboard.gallery.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin-dashboard.gallery.create');
    }

    public function store(Request $request): RedirectResponse
    {
        if ($uploadError = $this->firstInvalidUploadMessage($request)) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['images' => $uploadError]);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'caption' => 'nullable|string|max:10000',
            'image_url' => 'nullable|string|max:2000',
            'images' => 'nullable|array|max:30',
            'images.*' => 'nullable|file|mimes:jpeg,jpg,png,webp,gif|max:'.self::MAX_IMAGE_KB,
            'sort_order' => 'nullable|integer|min:0|max:999999',
            'is_published' => 'boolean',
        ], [
            'images.*.mimes' => 'Each file must be a JPEG, PNG, WebP, or GIF.',
            'images.*.max' => 'Each image must be under '.(self::MAX_IMAGE_KB / 1024).'MB.',
            'images.*.uploaded' => 'An image failed to upload. Try fewer/smaller files, or ask hosting to raise upload_max_filesize / post_max_size.',
        ]);

        $files = collect($request->file('images', []))
            ->filter(fn ($file) => $file instanceof UploadedFile && $file->isValid())
            ->values();

        if ($files->isEmpty() && ! $request->filled('image_url')) {
            throw ValidationException::withMessages([
                'images' => 'Please upload one or more images, or paste an image URL.',
            ]);
        }

        $validated['is_published'] = $request->boolean('is_published');
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['caption'] = TrixHtmlSanitizer::sanitize($validated['caption'] ?? '');

        if ($files->isNotEmpty()) {
            $baseTitle = $validated['title'];
            $baseSortOrder = $validated['sort_order'];
            $count = $files->count();

            foreach ($files as $index => $uploadedFile) {
                GalleryItem::create([
                    'title' => $count > 1 ? $baseTitle.' #'.($index + 1) : $baseTitle,
                    'caption' => $validated['caption'],
                    'image_url' => $uploadedFile->store('gallery', 'public'),
                    'sort_order' => $baseSortOrder + $index,
                    'is_published' => $validated['is_published'],
                ]);
            }

            return redirect()->route('admin-dashboard.gallery.index')->with('success', $count.' gallery image(s) added.');
        }

        GalleryItem::create([
            'title' => $validated['title'],
            'caption' => $validated['caption'],
            'image_url' => $validated['image_url'],
            'sort_order' => $validated['sort_order'],
            'is_published' => $validated['is_published'],
        ]);

        return redirect()->route('admin-dashboard.gallery.index')->with('success', 'Gallery image added.');
    }

    public function edit(GalleryItem $gallery_item): View
    {
        return view('admin-dashboard.gallery.edit', ['item' => $gallery_item]);
    }

    public function update(Request $request, GalleryItem $gallery_item): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'caption' => 'nullable|string|max:10000',
            'image_url' => 'nullable|string|max:2000',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,webp,gif|max:'.self::MAX_IMAGE_KB,
            'sort_order' => 'nullable|integer|min:0|max:999999',
            'is_published' => 'boolean',
        ], [
            'image.mimes' => 'The image must be a JPEG, PNG, WebP, or GIF.',
            'image.max' => 'The image must be under '.(self::MAX_IMAGE_KB / 1024).'MB.',
            'image.uploaded' => 'The image failed to upload. Try a smaller file, or ask hosting to raise upload_max_filesize.',
        ]);

        if (! $request->hasFile('image') && ! $request->filled('image_url')) {
            throw ValidationException::withMessages([
                'image' => 'Please upload an image or paste an image URL.',
            ]);
        }

        $validated['is_published'] = $request->boolean('is_published');
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['caption'] = TrixHtmlSanitizer::sanitize($validated['caption'] ?? '');

        if ($request->hasFile('image')) {
            if ($gallery_item->isStoredUpload()) {
                Storage::disk('public')->delete($gallery_item->image_url);
            }
            $validated['image_url'] = $request->file('image')->store('gallery', 'public');
        } else {
            $newUrl = $request->input('image_url');
            if ($newUrl !== $gallery_item->image_url && $gallery_item->isStoredUpload()) {
                Storage::disk('public')->delete($gallery_item->image_url);
            }
            $validated['image_url'] = $newUrl;
        }

        $gallery_item->update($validated);

        return redirect()->route('admin-dashboard.gallery.index')->with('success', 'Gallery image updated.');
    }

    public function destroy(GalleryItem $gallery_item): RedirectResponse
    {
        if ($gallery_item->isStoredUpload()) {
            Storage::disk('public')->delete($gallery_item->image_url);
        }

        $gallery_item->delete();

        return redirect()->route('admin-dashboard.gallery.index')->with('success', 'Gallery image removed.');
    }

    /**
     * Detect PHP-level upload failures before Laravel validation (clearer admin message).
     */
    private function firstInvalidUploadMessage(Request $request): ?string
    {
        $bag = $_FILES['images'] ?? null;
        if (! is_array($bag) || ! isset($bag['error'])) {
            return null;
        }

        $errors = is_array($bag['error']) ? $bag['error'] : [$bag['error']];
        $names = is_array($bag['name'] ?? null) ? $bag['name'] : [($bag['name'] ?? 'image')];

        foreach ($errors as $i => $code) {
            $code = (int) $code;
            if ($code === UPLOAD_ERR_OK || $code === UPLOAD_ERR_NO_FILE) {
                continue;
            }

            $label = $names[$i] ?: 'Image '.($i + 1);

            return match ($code) {
                UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => "“{$label}” is too large for the server upload limit. Compress it, upload fewer images at once, or raise upload_max_filesize / post_max_size on hosting.",
                UPLOAD_ERR_PARTIAL => "“{$label}” was only partially uploaded. Please try again.",
                UPLOAD_ERR_NO_TMP_DIR => 'Server temp folder is missing. Contact hosting support.',
                UPLOAD_ERR_CANT_WRITE => 'Server could not write the uploaded file. Contact hosting support.',
                UPLOAD_ERR_EXTENSION => "A PHP extension blocked “{$label}”. Contact hosting support.",
                default => "“{$label}” failed to upload (error code {$code}). Try a smaller JPEG/PNG.",
            };
        }

        return null;
    }
}
