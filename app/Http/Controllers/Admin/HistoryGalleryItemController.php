<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HistoryGalleryItem;
use App\Support\TrixHtmlSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HistoryGalleryItemController extends Controller
{
    public function index(): View
    {
        $items = HistoryGalleryItem::query()->ordered()->paginate(24);

        return view('admin-dashboard.history-gallery.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin-dashboard.history-gallery.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'caption' => 'nullable|string|max:10000',
            'image' => 'required|image|max:5120',
            'sort_order' => 'nullable|integer|min:0|max:999999',
            'is_visible' => 'boolean',
        ]);

        $validated['caption'] = TrixHtmlSanitizer::sanitize($validated['caption'] ?? '');
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['is_visible'] = $request->boolean('is_visible');
        $validated['image_path'] = $request->file('image')->store('history-gallery', 'public');
        unset($validated['image']);

        HistoryGalleryItem::query()->create($validated);

        return redirect()->route('admin-dashboard.history-gallery.index')->with('success', 'History gallery image added.');
    }

    public function edit(HistoryGalleryItem $history_gallery): View
    {
        return view('admin-dashboard.history-gallery.edit', ['item' => $history_gallery]);
    }

    public function update(Request $request, HistoryGalleryItem $history_gallery): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'caption' => 'nullable|string|max:10000',
            'image' => 'nullable|image|max:5120',
            'sort_order' => 'nullable|integer|min:0|max:999999',
            'is_visible' => 'boolean',
        ]);

        $validated['caption'] = TrixHtmlSanitizer::sanitize($validated['caption'] ?? '');
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['is_visible'] = $request->boolean('is_visible');

        if ($request->hasFile('image')) {
            if (filled($history_gallery->image_path)) {
                Storage::disk('public')->delete($history_gallery->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('history-gallery', 'public');
        }

        $history_gallery->update($validated);

        return redirect()->route('admin-dashboard.history-gallery.index')->with('success', 'History gallery image updated.');
    }

    public function destroy(HistoryGalleryItem $history_gallery): RedirectResponse
    {
        if (filled($history_gallery->image_path)) {
            Storage::disk('public')->delete($history_gallery->image_path);
        }

        $history_gallery->delete();

        return redirect()->route('admin-dashboard.history-gallery.index')->with('success', 'History gallery image removed.');
    }
}

