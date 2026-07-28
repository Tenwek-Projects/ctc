<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use App\Support\TrixHtmlSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class GalleryItemController extends Controller
{
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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'caption' => 'nullable|string|max:10000',
            'image_url' => 'nullable|string|max:2000',
            'image' => 'nullable|image|max:5120',
            'images' => 'nullable|array|max:30',
            'images.*' => 'image|max:5120',
            'sort_order' => 'nullable|integer|min:0|max:999999',
            'is_published' => 'boolean',
        ]);

        $hasMultiImages = $request->hasFile('images');

        if (! $hasMultiImages && ! $request->hasFile('image') && ! $request->filled('image_url')) {
            throw ValidationException::withMessages([
                'image' => 'Please upload an image or paste an image URL.',
            ]);
        }

        $validated['is_published'] = $request->boolean('is_published');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['caption'] = TrixHtmlSanitizer::sanitize($validated['caption'] ?? '');

        if ($hasMultiImages) {
            $baseTitle = $validated['title'];
            $baseSortOrder = (int) $validated['sort_order'];
            $images = $request->file('images');
            foreach ($images as $index => $uploadedFile) {
                GalleryItem::create([
                    'title' => count($images) > 1 ? $baseTitle.' #'.($index + 1) : $baseTitle,
                    'caption' => $validated['caption'],
                    'image_url' => $uploadedFile->store('gallery', 'public'),
                    'sort_order' => $baseSortOrder + $index,
                    'is_published' => $validated['is_published'],
                ]);
            }

            return redirect()->route('admin-dashboard.gallery.index')->with('success', count($images).' gallery image(s) added.');
        }

        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')->store('gallery', 'public');
        } else {
            $validated['image_url'] = $request->input('image_url');
        }
        GalleryItem::create($validated);

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
            'image' => 'nullable|image|max:5120',
            'sort_order' => 'nullable|integer|min:0|max:999999',
            'is_published' => 'boolean',
        ]);

        if (! $request->hasFile('image') && ! $request->filled('image_url')) {
            throw ValidationException::withMessages([
                'image' => 'Please upload an image or paste an image URL.',
            ]);
        }

        $validated['is_published'] = $request->boolean('is_published');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
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
}
