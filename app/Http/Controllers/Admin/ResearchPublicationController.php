<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResearchPublication;
use App\Support\TrixHtmlSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResearchPublicationController extends Controller
{
    public function index(): View
    {
        $items = ResearchPublication::ordered()->paginate(15);
        return view('admin-dashboard.research.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin-dashboard.research.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:2000',
            'authors' => 'nullable|string|max:5000',
            'tenwek_authors' => 'nullable|string|max:5000',
            'journal' => 'nullable|string|max:500',
            'publication_type' => 'nullable|string|max:120',
            'doi' => 'nullable|string|max:255',
            'pmid' => 'nullable|string|max:32',
            'specialty' => 'nullable|string|max:160',
            'full_citation' => 'nullable|string|max:10000',
            'year' => 'nullable|string|max:4',
            'url' => 'nullable|string|max:2000',
            'abstract' => 'nullable|string|max:5000',
            'sort_order' => 'nullable|integer|min:0',
            'is_visible' => 'boolean',
        ]);
        $validated['is_visible'] = $request->boolean('is_visible');
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['abstract'] = TrixHtmlSanitizer::sanitize($validated['abstract'] ?? '');
        ResearchPublication::create($validated);

        return redirect()->route('admin-dashboard.research.index')->with('success', 'Publication added.');
    }

    public function edit(ResearchPublication $research_publication): View
    {
        return view('admin-dashboard.research.edit', ['item' => $research_publication]);
    }

    public function update(Request $request, ResearchPublication $research_publication): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:2000',
            'authors' => 'nullable|string|max:5000',
            'tenwek_authors' => 'nullable|string|max:5000',
            'journal' => 'nullable|string|max:500',
            'publication_type' => 'nullable|string|max:120',
            'doi' => 'nullable|string|max:255',
            'pmid' => 'nullable|string|max:32',
            'specialty' => 'nullable|string|max:160',
            'full_citation' => 'nullable|string|max:10000',
            'year' => 'nullable|string|max:4',
            'url' => 'nullable|string|max:2000',
            'abstract' => 'nullable|string|max:5000',
            'sort_order' => 'nullable|integer|min:0',
            'is_visible' => 'boolean',
        ]);
        $validated['is_visible'] = $request->boolean('is_visible');
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['abstract'] = TrixHtmlSanitizer::sanitize($validated['abstract'] ?? '');
        $research_publication->update($validated);
        return redirect()->route('admin-dashboard.research.index')->with('success', 'Publication updated.');
    }

    public function destroy(ResearchPublication $research_publication): RedirectResponse
    {
        $research_publication->delete();
        return redirect()->route('admin-dashboard.research.index')->with('success', 'Publication deleted.');
    }
}
