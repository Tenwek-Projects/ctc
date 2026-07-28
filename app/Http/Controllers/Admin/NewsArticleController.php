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

class NewsArticleController extends Controller
{
    public function index(): View
    {
        $articles = NewsArticle::query()
            ->where('type', '!=', NewsArticle::TYPE_EVENT)
            ->latest('published_at')
            ->latest()
            ->paginate(15);
        return view('admin-dashboard.news.index', compact('articles'));
    }

    public function create(): View
    {
        return view('admin-dashboard.news.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'type' => 'required|in:'.implode(',', [NewsArticle::TYPE_NEWS, NewsArticle::TYPE_ANNOUNCEMENT]),
            'excerpt' => 'nullable|string|max:5000',
            'body' => 'nullable|string|max:50000',
            'featured_image' => 'nullable|image|max:5120',
            'featured_image_url' => 'nullable|string|max:500',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean',
        ]);
        $validated['is_published'] = $request->boolean('is_published');
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        $validated['excerpt'] = TrixHtmlSanitizer::sanitize($validated['excerpt'] ?? '');
        $validated['body'] = TrixHtmlSanitizer::sanitize($validated['body'] ?? '');

        $article = NewsArticle::create(collect($validated)->except(['featured_image', 'featured_image_url'])->all());

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('news', 'public');
            $article->update(['featured_image' => $path]);
        } elseif (! empty($validated['featured_image_url'])) {
            $article->update(['featured_image' => $validated['featured_image_url']]);
        }

        return redirect()->route('admin-dashboard.news.index')->with('success', 'Article created.');
    }

    public function edit(NewsArticle $news): View
    {
        return view('admin-dashboard.news.edit', ['article' => $news]);
    }

    public function update(Request $request, NewsArticle $news): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'type' => 'required|in:'.implode(',', [NewsArticle::TYPE_NEWS, NewsArticle::TYPE_ANNOUNCEMENT]),
            'excerpt' => 'nullable|string|max:5000',
            'body' => 'nullable|string|max:50000',
            'featured_image' => 'nullable|image|max:5120',
            'featured_image_url' => 'nullable|string|max:500',
            'remove_featured_image' => 'sometimes|boolean',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean',
        ]);
        $validated['is_published'] = $request->boolean('is_published');
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        $validated['excerpt'] = TrixHtmlSanitizer::sanitize($validated['excerpt'] ?? '');
        $validated['body'] = TrixHtmlSanitizer::sanitize($validated['body'] ?? '');

        $news->update(collect($validated)->except(['featured_image', 'featured_image_url', 'remove_featured_image'])->all());

        if ($request->boolean('remove_featured_image')) {
            if ($news->featured_image && ! str_starts_with($news->featured_image, 'http')) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $news->update(['featured_image' => null]);
        } elseif ($request->hasFile('featured_image')) {
            if ($news->featured_image && ! str_starts_with($news->featured_image, 'http')) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $path = $request->file('featured_image')->store('news', 'public');
            $news->update(['featured_image' => $path]);
        } elseif (! empty($validated['featured_image_url'])) {
            // If switching from a stored file to an external URL, remove old file
            if ($news->featured_image && ! str_starts_with($news->featured_image, 'http')) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $news->update(['featured_image' => $validated['featured_image_url']]);
        }

        return redirect()->route('admin-dashboard.news.index')->with('success', 'Article updated.');
    }

    public function destroy(NewsArticle $news): RedirectResponse
    {
        $news->delete();
        return redirect()->route('admin-dashboard.news.index')->with('success', 'Article deleted.');
    }
}
