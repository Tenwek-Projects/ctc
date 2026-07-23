<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\DangerZone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class DangerZoneController extends Controller
{
    public function show(): View
    {
        $datasets = collect(DangerZone::datasets())->map(function (array $dataset, string $key) {
            return [
                'key' => $key,
                'label' => $dataset['label'],
                'description' => $dataset['description'],
                'group' => $dataset['group'],
                'count' => DangerZone::count($key),
            ];
        });

        $groups = $datasets->groupBy('group');

        return view('admin-dashboard.danger-zone.show', compact('groups'));
    }

    public function purge(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'datasets' => ['required', 'array', 'min:1'],
            'datasets.*' => ['string', 'in:'.implode(',', DangerZone::keys())],
            'confirm' => ['required', 'string', 'in:PURGE'],
        ], [
            'datasets.required' => 'Select at least one data set to purge.',
            'confirm.in' => 'Type PURGE in capital letters to confirm.',
        ]);

        try {
            $deleted = DangerZone::purge($validated['datasets']);
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route('admin-dashboard.danger-zone.show')
                ->with('error', 'Purge failed. Nothing was partially left in an inconsistent state where possible — check the logs and try again.');
        }

        $parts = [];
        foreach ($deleted as $key => $count) {
            $label = DangerZone::datasets()[$key]['label'] ?? $key;
            $parts[] = "{$label}: {$count}";
        }

        return redirect()
            ->route('admin-dashboard.danger-zone.show')
            ->with('success', 'Purged selected test data — '.implode('; ', $parts).'.');
    }
}
