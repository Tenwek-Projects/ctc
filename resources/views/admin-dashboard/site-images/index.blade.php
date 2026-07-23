@extends('admin-dashboard.layouts.app')

@section('title', 'Site images')
@section('header', 'Site images')

@section('content')
    @if($errors->has('image'))
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            {{ $errors->first('image') }}
        </div>
    @endif

    @php
        $pageGuide = collect(config('site_images.slots', []))
            ->filter(fn ($slot) => filled($slot['public_path'] ?? null) && filled($slot['public_label'] ?? null))
            ->groupBy('public_path')
            ->map(function ($items, $path) {
                $first = $items->first();
                return [
                    'path' => $path,
                    'label' => $first['public_label'] ?? $path,
                    'sections' => $items->pluck('label')->unique()->values()->all(),
                ];
            })
            ->values();
    @endphp

    <div class="rounded-xl bg-white border border-gray-200 shadow-sm overflow-hidden mb-6">
        <div class="px-4 py-4 sm:px-6 border-b border-gray-100">
            <p class="text-xs font-extrabold uppercase tracking-[0.18em] text-admin-muted">Pages edited here</p>
            <p class="mt-2 text-sm text-gray-700 leading-relaxed max-w-3xl">
                Upload shared photos used on public pages. Each card names the <strong>page</strong> and <strong>section</strong>.
                Team, news, gallery, and service detail photos are managed in their own admin sections (linked at the bottom).
            </p>
        </div>
        <div class="px-4 py-4 sm:px-6">
            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($pageGuide as $page)
                    <a href="{{ url($page['path']) }}" target="_blank" rel="noopener"
                       class="rounded-xl border border-gray-200 bg-admin-bg/40 px-4 py-3 hover:border-admin-teal/40 hover:bg-admin-bg transition-colors">
                        <p class="text-sm font-semibold text-admin-dark">{{ $page['label'] }}</p>
                        <p class="mt-0.5 font-mono text-[11px] text-admin-teal">{{ $page['path'] === '/' ? '/' : $page['path'] }} ↗</p>
                        <p class="mt-2 text-xs text-gray-500 leading-relaxed">
                            {{ implode(' · ', array_slice($page['sections'], 0, 3)) }}{{ count($page['sections']) > 3 ? '…' : '' }}
                        </p>
                    </a>
                @endforeach
                <a href="{{ route('admin-dashboard.page-banners.index') }}"
                   class="rounded-xl border border-dashed border-gray-300 bg-white px-4 py-3 hover:border-admin-teal/40 transition-colors">
                    <p class="text-sm font-semibold text-admin-dark">Page header banners</p>
                    <p class="mt-0.5 text-[11px] text-admin-teal">Per-page top banners →</p>
                    <p class="mt-2 text-xs text-gray-500 leading-relaxed">About, Support, Services, Contact, and more</p>
                </a>
            </div>
        </div>
    </div>

    @foreach($slots as $group => $groupSlots)
        @php
            $groupPublicPath = collect($groupSlots)->pluck('public_path')->filter()->unique();
            $groupPublicLabel = collect($groupSlots)->pluck('public_label')->filter()->unique();
            $singlePage = $groupPublicPath->count() === 1 ? $groupPublicPath->first() : null;
            $singleLabel = $groupPublicLabel->count() === 1 ? $groupPublicLabel->first() : null;
        @endphp
        <div class="mb-8" @if($singlePage) id="page-{{ trim(str_replace('/', '-', $singlePage), '-') ?: 'home' }}" @endif>
            <div class="mb-3 flex flex-wrap items-end justify-between gap-2">
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-[0.18em] text-admin-muted">{{ $group }}</h2>
                    @if($singlePage && $singleLabel)
                        <p class="mt-1 text-xs text-gray-500">
                            Public page:
                            <a href="{{ url($singlePage) }}" target="_blank" rel="noopener" class="font-semibold text-admin-teal hover:underline">
                                {{ $singleLabel }} ({{ $singlePage === '/' ? '/' : $singlePage }}) ↗
                            </a>
                        </p>
                    @endif
                </div>
            </div>
            <div class="grid gap-4 lg:grid-cols-2">
                @foreach($groupSlots as $slot)
                    <div class="rounded-xl bg-white border border-gray-200 shadow-sm overflow-hidden">
                        <div class="grid sm:grid-cols-[10rem_1fr] gap-0">
                            <div class="bg-gray-50 border-b sm:border-b-0 sm:border-r border-gray-200 p-3 flex items-center justify-center min-h-[8rem]">
                                @if(!empty($slot['resolved_url']))
                                    <img src="{{ $slot['resolved_url'] }}?v={{ $slot['bytes'] ?? time() }}" alt="" class="max-h-36 w-full object-contain">
                                @else
                                    <span class="text-xs text-gray-400 text-center px-2">No image yet</span>
                                @endif
                            </div>
                            <div class="p-4 sm:p-5 flex flex-col">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h3 class="text-sm font-semibold text-gray-900">{{ $slot['label'] }}</h3>
                                        <p class="mt-1 text-xs text-gray-500 leading-relaxed">{{ $slot['description'] }}</p>
                                    </div>
                                    @if($slot['has_custom'])
                                        <span class="shrink-0 rounded-full bg-green-50 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-green-700">Custom</span>
                                    @else
                                        <span class="shrink-0 rounded-full bg-gray-100 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-gray-500">Default</span>
                                    @endif
                                </div>

                                @if(!empty($slot['public_label']) || !empty($slot['used_on']))
                                    <div class="mt-3 rounded-lg border border-admin-teal/15 bg-admin-bg/50 px-3 py-2">
                                        @if(!empty($slot['public_label']) && !empty($slot['public_path']))
                                            <p class="text-[11px] font-semibold text-admin-dark">
                                                Page:
                                                <a href="{{ url($slot['public_path']) }}" target="_blank" rel="noopener" class="text-admin-teal hover:underline">
                                                    {{ $slot['public_label'] }}
                                                    <span class="font-mono font-normal text-gray-500">({{ $slot['public_path'] === '/' ? '/' : $slot['public_path'] }})</span>
                                                </a>
                                            </p>
                                        @endif
                                        @if(!empty($slot['used_on']))
                                            <p class="mt-0.5 text-[11px] text-gray-500">
                                                Section: {{ implode(' · ', $slot['used_on']) }}
                                            </p>
                                        @endif
                                    </div>
                                @endif

                                <dl class="mt-3 grid grid-cols-2 gap-x-3 gap-y-1 text-xs">
                                    <div>
                                        <dt class="text-gray-400">Recommended</dt>
                                        <dd class="font-medium text-gray-800">{{ $slot['recommended'] }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-gray-400">Aspect</dt>
                                        <dd class="font-medium text-gray-800">{{ $slot['aspect'] ?? '—' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-gray-400">Max upload</dt>
                                        <dd class="font-medium text-gray-800">{{ number_format(($slot['max_kb'] ?? 5120) / 1024, 1) }} MB</dd>
                                    </div>
                                    <div>
                                        <dt class="text-gray-400">Current file</dt>
                                        <dd class="font-medium text-gray-800">
                                            @if($slot['width'] && $slot['height'])
                                                {{ $slot['width'] }} × {{ $slot['height'] }} px
                                                @if($slot['bytes'])
                                                    <span class="text-gray-400">({{ number_format($slot['bytes'] / 1024, 0) }} KB)</span>
                                                @endif
                                            @else
                                                —
                                            @endif
                                        </dd>
                                    </div>
                                </dl>

                                <div class="mt-4 flex flex-wrap items-center gap-2">
                                    <form action="{{ route('admin-dashboard.site-images.update', $slot['key']) }}" method="post" enctype="multipart/form-data" class="flex flex-wrap items-center gap-2">
                                        @csrf
                                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif" required class="text-xs text-gray-700 max-w-[220px]">
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-admin-teal text-white hover:bg-admin-teal-dark">
                                            Upload / replace
                                        </button>
                                    </form>
                                    @if($slot['has_custom'])
                                        <form action="{{ route('admin-dashboard.site-images.destroy', $slot['key']) }}" method="post" onsubmit="return confirm('Clear this custom image and use the default?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-red-600 hover:underline">Clear</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <div class="mb-8" id="page-banners">
        <div class="flex items-end justify-between gap-4 mb-3">
            <div>
                <h2 class="text-sm font-bold uppercase tracking-[0.18em] text-admin-muted">Page header banners</h2>
                <p class="mt-1 text-xs text-gray-500">Top banner on each inner page (About, Support, Services, Contact, …)</p>
            </div>
            <a href="{{ route('admin-dashboard.page-banners.index') }}" class="text-xs font-semibold text-admin-teal hover:underline">Open full banners list →</a>
        </div>
        <div class="rounded-xl bg-white border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="admin-table min-w-full">
                    <thead>
                        <tr>
                            <th class="text-left">Preview</th>
                            <th class="text-left">Page</th>
                            <th class="text-left">Recommended</th>
                            <th class="text-left">Upload</th>
                            <th class="text-right">Reset</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pageBanners as $page)
                            <tr class="align-top">
                                <td class="py-3">
                                    <img src="{{ $page['resolved_url'] }}" alt="" class="h-14 w-24 rounded object-cover bg-gray-100 border border-gray-200">
                                    @if($page['has_custom'])
                                        <p class="mt-1 text-[10px] font-semibold uppercase tracking-wide text-green-600">Custom</p>
                                    @else
                                        <p class="mt-1 text-[10px] font-semibold uppercase tracking-wide text-gray-400">Default</p>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $page['label'] }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5 font-mono">{{ $page['key'] }}</p>
                                    @if(!empty($page['route']))
                                        <a href="{{ route($page['route'], $page['route_params'] ?? []) }}" target="_blank" rel="noopener" class="text-xs text-admin-teal hover:underline">View page ↗</a>
                                    @endif
                                </td>
                                <td class="py-3 text-xs text-gray-600">
                                    1920 × 800 px<br>
                                    <span class="text-gray-400">~2.4:1 · max 5 MB</span>
                                </td>
                                <td class="py-3">
                                    <form action="{{ route('admin-dashboard.page-banners.update', $page['key']) }}" method="post" enctype="multipart/form-data" class="flex flex-wrap items-center gap-2">
                                        @csrf
                                        <input type="file" name="banner" accept="image/*" required class="text-xs text-gray-700 max-w-[180px]">
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-admin-teal text-white hover:bg-admin-teal-dark">Upload</button>
                                    </form>
                                </td>
                                <td class="py-3 text-right">
                                    @if($page['has_custom'])
                                        <form action="{{ route('admin-dashboard.page-banners.destroy', $page['key']) }}" method="post" class="inline" onsubmit="return confirm('Remove this custom banner?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-red-600 hover:underline">Clear</button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mb-2">
        <h2 class="text-sm font-bold uppercase tracking-[0.18em] text-admin-muted mb-3">Content images (managed elsewhere)</h2>
        <div class="rounded-xl bg-white border border-gray-200 shadow-sm divide-y divide-gray-100">
            @foreach($contentManagers as $item)
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 px-4 py-3">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $item['label'] }}</p>
                        <p class="text-xs text-gray-500">{{ $item['note'] ?? '' }}</p>
                    </div>
                    <a href="{{ route($item['route']) }}{{ !empty($item['hash']) ? '#'.$item['hash'] : '' }}"
                       class="text-xs font-semibold text-admin-teal hover:underline shrink-0">
                        Open →
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
