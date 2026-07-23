@extends('admin-dashboard.layouts.app')

@section('title', 'Page banners')
@section('header', 'Page header banners')

@section('content')
    @if($errors->has('banner'))
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            {{ $errors->first('banner') }}
        </div>
    @endif

    <div class="rounded-xl bg-white border border-gray-200 shadow-sm overflow-hidden mb-6">
        <div class="px-4 py-4 sm:px-6 border-b border-gray-200">
            <p class="text-sm text-gray-700 leading-relaxed max-w-3xl">
                Each inner page can use its own header image. If you do not upload one, the site uses the
                <strong>default banner</strong> from
                <a href="{{ route('admin-dashboard.site-images.index') }}" class="text-admin-teal font-semibold hover:underline">Site images</a>
                (or <code class="text-xs bg-gray-100 px-1 rounded">CTC_PAGE_BANNER_IMAGE</code> when none is uploaded).
            </p>
            <div class="mt-4 flex items-start gap-4">
                <div class="shrink-0">
                    <p class="text-xs font-medium text-gray-500 mb-1">Default (placeholder)</p>
                    <img src="{{ $defaultUrl }}" alt="" class="h-16 w-28 rounded-lg object-cover bg-gray-100 border border-gray-200">
                </div>
            </div>
        </div>
    </div>

    <div class="rounded-xl bg-white border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="admin-table min-w-full">
                <thead>
                    <tr>
                        <th class="text-left">Preview</th>
                        <th class="text-left">Page</th>
                        <th class="text-left">Public link</th>
                        <th class="text-left">Upload</th>
                        <th class="text-right">Reset</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($pages as $page)
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
                            </td>
                            <td class="py-3 text-sm">
                                @if(!empty($page['route']))
                                    <a href="{{ route($page['route'], $page['route_params'] ?? []) }}" target="_blank" rel="noopener" class="text-admin-teal hover:underline">View page</a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="py-3">
                                <form action="{{ route('admin-dashboard.page-banners.update', $page['key']) }}" method="post" enctype="multipart/form-data" class="flex flex-wrap items-center gap-2">
                                    @csrf
                                    <input type="file" name="banner" accept="image/*" required class="text-xs text-gray-700 max-w-[200px]">
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-admin-teal text-white hover:bg-admin-teal-dark">Upload</button>
                                </form>
                            </td>
                            <td class="py-3 text-right">
                                @if($page['has_custom'])
                                    <form action="{{ route('admin-dashboard.page-banners.destroy', $page['key']) }}" method="post" class="inline" onsubmit="return confirm('Remove this custom banner and use the site default?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-600 hover:underline">Clear</button>
                                    </form>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
