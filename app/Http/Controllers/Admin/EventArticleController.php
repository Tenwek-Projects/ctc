<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use App\Support\TrixHtmlSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EventArticleController extends Controller
{
    public function index(): View
    {
        $events = NewsArticle::query()
            ->events()
            ->latest('event_date')
            ->latest('published_at')
            ->latest()
            ->paginate(15);

        return view('admin-dashboard.events.index', compact('events'));
    }

    public function create(): View
    {
        return view('admin-dashboard.events.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:news_articles,slug',
            'event_date' => 'required|date',
            'excerpt' => 'nullable|string|max:5000',
            'body' => 'nullable|string|max:50000',
            'featured_image' => 'nullable|image|max:5120',
            'featured_image_url' => 'nullable|string|max:500',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean',
        ]);

        $validated['type'] = NewsArticle::TYPE_EVENT;
        $validated['is_published'] = $request->boolean('is_published');
        $validated['slug'] = filled($validated['slug'] ?? null) ? $validated['slug'] : Str::slug($validated['title']);
        $validated['excerpt'] = TrixHtmlSanitizer::sanitize($validated['excerpt'] ?? '');
        $validated['body'] = TrixHtmlSanitizer::sanitize($validated['body'] ?? '');

        $event = NewsArticle::create(collect($validated)->except(['featured_image', 'featured_image_url'])->all());

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('events', 'public');
            $event->update(['featured_image' => $path]);
        } elseif (! empty($validated['featured_image_url'])) {
            $event->update(['featured_image' => $validated['featured_image_url']]);
        }

        return redirect()->route('admin-dashboard.events.index')->with('success', 'Event created.');
    }

    public function edit(NewsArticle $event_article): View
    {
        abort_unless($event_article->type === NewsArticle::TYPE_EVENT, 404);

        return view('admin-dashboard.events.edit', ['event' => $event_article]);
    }

    public function update(Request $request, NewsArticle $event_article): RedirectResponse
    {
        abort_unless($event_article->type === NewsArticle::TYPE_EVENT, 404);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:news_articles,slug,'.$event_article->id,
            'event_date' => 'required|date',
            'excerpt' => 'nullable|string|max:5000',
            'body' => 'nullable|string|max:50000',
            'featured_image' => 'nullable|image|max:5120',
            'featured_image_url' => 'nullable|string|max:500',
            'remove_featured_image' => 'sometimes|boolean',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean',
        ]);

        $validated['type'] = NewsArticle::TYPE_EVENT;
        $validated['is_published'] = $request->boolean('is_published');
        $validated['slug'] = filled($validated['slug'] ?? null) ? $validated['slug'] : Str::slug($validated['title']);
        $validated['excerpt'] = TrixHtmlSanitizer::sanitize($validated['excerpt'] ?? '');
        $validated['body'] = TrixHtmlSanitizer::sanitize($validated['body'] ?? '');

        $event_article->update(collect($validated)->except(['featured_image', 'featured_image_url', 'remove_featured_image'])->all());

        if ($request->boolean('remove_featured_image')) {
            if ($event_article->featured_image && ! str_starts_with($event_article->featured_image, 'http')) {
                Storage::disk('public')->delete($event_article->featured_image);
            }
            $event_article->update(['featured_image' => null]);
        } elseif ($request->hasFile('featured_image')) {
            if ($event_article->featured_image && ! str_starts_with($event_article->featured_image, 'http')) {
                Storage::disk('public')->delete($event_article->featured_image);
            }
            $path = $request->file('featured_image')->store('events', 'public');
            $event_article->update(['featured_image' => $path]);
        } elseif (! empty($validated['featured_image_url'])) {
            if ($event_article->featured_image && ! str_starts_with($event_article->featured_image, 'http')) {
                Storage::disk('public')->delete($event_article->featured_image);
            }
            $event_article->update(['featured_image' => $validated['featured_image_url']]);
        }

        return redirect()->route('admin-dashboard.events.index')->with('success', 'Event updated.');
    }

    public function destroy(NewsArticle $event_article): RedirectResponse
    {
        abort_unless($event_article->type === NewsArticle::TYPE_EVENT, 404);

        if ($event_article->featured_image && ! str_starts_with($event_article->featured_image, 'http')) {
            Storage::disk('public')->delete($event_article->featured_image);
        }

        $event_article->delete();

        return redirect()->route('admin-dashboard.events.index')->with('success', 'Event deleted.');
    }
}

