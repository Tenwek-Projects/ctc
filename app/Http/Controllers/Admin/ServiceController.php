<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Support\TrixHtmlSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::ordered()->orderBy('id')->get();

        $categories = [
            Service::CATEGORY_CARDIAC,
            Service::CATEGORY_THORACIC,
            Service::CATEGORY_DIAGNOSTICS,
        ];

        $grouped = collect($categories)->mapWithKeys(function (string $category) use ($services) {
            $members = $services->where('category', $category)->values();

            return [
                $category => [
                    'label' => Service::categoryLabel($category),
                    'services' => $members,
                ],
            ];
        })->filter(fn (array $group) => $group['services']->isNotEmpty());

        $uncategorized = $services->reject(fn (Service $service) => in_array($service->category, $categories, true))->values();
        if ($uncategorized->isNotEmpty()) {
            $grouped->put('_other', [
                'label' => 'Other',
                'services' => $uncategorized,
            ]);
        }

        return view('admin-dashboard.services.index', compact('services', 'grouped'));
    }

    public function create(): View
    {
        return view('admin-dashboard.services.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category' => 'required|in:'.implode(',', [Service::CATEGORY_CARDIAC, Service::CATEGORY_THORACIC, Service::CATEGORY_DIAGNOSTICS]),
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:20000',
            'featured_image' => 'nullable|image|max:5120',
            'slug' => 'nullable|string|max:255',
            'is_visible' => 'boolean',
            'show_on_homepage' => 'boolean',
        ]);
        $validated['is_visible'] = $request->boolean('is_visible');
        $validated['show_on_homepage'] = $request->boolean('show_on_homepage');
        $validated['sort_order'] = $this->nextSortOrderForCategory($validated['category']);
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $desc = TrixHtmlSanitizer::sanitize($validated['description'] ?? '');
        $validated['description'] = $desc === '' ? null : $desc;

        $service = Service::create(collect($validated)->except('featured_image')->all());

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('services', 'public');
            $service->update(['featured_image_path' => $path]);
        }

        return redirect()->route('admin-dashboard.services.index')->with('success', 'Service created.');
    }

    public function edit(Service $service): View
    {
        return view('admin-dashboard.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $request->validate([
            'category' => 'required|in:'.implode(',', [Service::CATEGORY_CARDIAC, Service::CATEGORY_THORACIC, Service::CATEGORY_DIAGNOSTICS]),
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:20000',
            'featured_image' => 'nullable|image|max:5120',
            'slug' => 'nullable|string|max:255',
            'is_visible' => 'boolean',
            'show_on_homepage' => 'boolean',
        ]);
        $validated['is_visible'] = $request->boolean('is_visible');
        $validated['show_on_homepage'] = $request->boolean('show_on_homepage');
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $desc = TrixHtmlSanitizer::sanitize($validated['description'] ?? '');
        $validated['description'] = $desc === '' ? null : $desc;

        $service->update(collect($validated)->except('featured_image')->all());

        if ($request->hasFile('featured_image')) {
            if ($service->featured_image_path && ! str_starts_with($service->featured_image_path, 'http')) {
                Storage::disk('public')->delete($service->featured_image_path);
            }
            $path = $request->file('featured_image')->store('services', 'public');
            $service->update(['featured_image_path' => $path]);
        }

        return redirect()->route('admin-dashboard.services.index')->with('success', 'Service updated.');
    }

    public function toggleHomepage(int $service): RedirectResponse
    {
        $model = Service::query()->findOrFail($service);

        $model->update([
            'show_on_homepage' => ! $model->show_on_homepage,
        ]);

        $state = $model->show_on_homepage ? 'shown on' : 'removed from';

        return redirect()
            ->route('admin-dashboard.services.index')
            ->with('success', "{$model->name} {$state} the homepage.");
    }

    public function reorder(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category' => 'required|in:'.implode(',', [
                Service::CATEGORY_CARDIAC,
                Service::CATEGORY_THORACIC,
                Service::CATEGORY_DIAGNOSTICS,
            ]),
            'order' => 'required|array|min:1',
            'order.*' => 'integer|distinct|exists:services,id',
        ]);

        $ids = array_map('intval', $validated['order']);

        $services = Service::query()
            ->where('category', $validated['category'])
            ->whereIn('id', $ids)
            ->get()
            ->keyBy('id');

        if ($services->count() !== count($ids)) {
            return redirect()
                ->route('admin-dashboard.services.index')
                ->with('error', 'Could not reorder services — one or more items were missing from that category.');
        }

        DB::transaction(function () use ($ids, $services): void {
            foreach ($ids as $position => $id) {
                $services[$id]->update(['sort_order' => ($position + 1) * 10]);
            }
        });

        if ($request->expectsJson()) {
            return response()->json(['ok' => true]);
        }

        return redirect()
            ->route('admin-dashboard.services.index')
            ->with('success', 'Service order updated.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()->route('admin-dashboard.services.index')->with('success', 'Service deleted.');
    }

    private function nextSortOrderForCategory(string $category): int
    {
        $max = Service::query()
            ->where('category', $category)
            ->max('sort_order');

        return ((int) $max) + 10;
    }
}
