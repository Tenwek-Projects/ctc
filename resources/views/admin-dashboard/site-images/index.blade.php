@extends('admin-dashboard.layouts.app')

@section('title', 'Site images')
@section('header', 'Site images')

@section('content')
    @if($errors->has('image'))
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            {{ $errors->first('image') }}
        </div>
    @endif

    <div class="rounded-xl bg-white border border-gray-200 shadow-sm overflow-hidden mb-6">
        <div class="px-4 py-4 sm:px-6">
            <p class="text-sm text-gray-700 leading-relaxed max-w-3xl">
                Upload or replace the shared images used across the public site. Each card shows the
                <strong>recommended size</strong> and current dimensions when available.
                Content-specific photos (team, news, gallery, services) stay in their own sections — linked below.
            </p>
        </div>
    </div>

    @foreach($slots as $group => $groupSlots)
        <div class="mb-8">
            <h2 class="text-sm font-bold uppercase tracking-[0.18em] text-admin-muted mb-3">{{ $group }}</h2>
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

                                @if(!empty($slot['used_on']))
                                    <p class="mt-2 text-[11px] text-gray-400">
                                        Used on: {{ implode(', ', $slot['used_on']) }}
                                    </p>
                                @endif

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

    <div class="mb-8">
        <div class="flex items-end justify-between gap-4 mb-3">
            <h2 class="text-sm font-bold uppercase tracking-[0.18em] text-admin-muted">Page header banners</h2>
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
                                        <a href="{{ route($page['route'], $page['route_params'] ?? []) }}" target="_blank" rel="noopener" class="text-xs text-admin-teal hover:underline">View page</a>
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
