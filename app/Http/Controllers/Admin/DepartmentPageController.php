<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DepartmentPage;
use App\Support\PublicAssetUrl;
use App\Support\TrixHtmlSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DepartmentPageController extends Controller
{
    public function index(): View
    {
        $pages = DepartmentPage::query()->ordered()->get();

        return view('admin-dashboard.department-pages.index', compact('pages'));
    }

    public function edit(DepartmentPage $departmentPage): View
    {
        return view('admin-dashboard.department-pages.edit', [
            'page' => $departmentPage,
            'featured_image_url' => PublicAssetUrl::toUrl($departmentPage->featured_image_path),
        ]);
    }

    public function update(Request $request, DepartmentPage $departmentPage): RedirectResponse
    {
        $validated = $request->validate([
            'meta_title' => ['nullable', 'string', 'max:200'],
            'meta_description' => ['required', 'string', 'max:320'],
            'intro_kicker' => ['nullable', 'string', 'max:80'],
            'intro_heading' => ['required', 'string', 'max:255'],
            'intro_subheading' => ['nullable', 'string', 'max:500'],
            'body_html' => ['required', 'string', 'max:120000'],
            'is_visible' => ['boolean'],
            'featured_image' => ['nullable', 'image', 'max:5120'],
            'remove_featured_image' => ['sometimes', 'boolean'],
        ]);

        $departmentPage->fill([
            'meta_title' => $validated['meta_title'] ?: null,
            'meta_description' => $validated['meta_description'],
            'intro_kicker' => $validated['intro_kicker'] ?: null,
            'intro_heading' => $validated['intro_heading'],
            'intro_subheading' => $validated['intro_subheading'] ?: null,
            'body_html' => TrixHtmlSanitizer::sanitize($validated['body_html']),
            'is_visible' => $request->boolean('is_visible'),
        ]);

        if ($request->hasFile('featured_image')) {
            $this->storeFeaturedImage($request, $departmentPage);
        } elseif ($request->boolean('remove_featured_image')) {
            $this->deleteFeaturedImageFile($departmentPage);
            $departmentPage->featured_image_path = null;
        }

        $departmentPage->save();

        return redirect()
            ->route('admin-dashboard.department-pages.edit', $departmentPage)
            ->with('success', 'Department page updated.');
    }

    private function storeFeaturedImage(Request $request, DepartmentPage $page): void
    {
        $this->deleteFeaturedImageFile($page);

        $path = $request->file('featured_image')->store('departments', 'public');
        $page->featured_image_path = $path;
    }

    private function deleteFeaturedImageFile(DepartmentPage $page): void
    {
        $old = $page->featured_image_path;
        if ($old && ! str_starts_with($old, 'http')) {
            Storage::disk('public')->delete($old);
        }
    }
}
