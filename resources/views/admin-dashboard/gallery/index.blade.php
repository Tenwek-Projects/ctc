@extends('admin-dashboard.layouts.app')

@section('title', 'Gallery')
@section('header', 'Gallery albums')

@section('content')
    <div class="mb-4 rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-600 shadow-sm sm:px-6">
        Albums appear on the public gallery in this order. Use the up/down controls to reorder albums, then open an album to edit its photos.
    </div>

    <div class="rounded-xl bg-white border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 flex flex-wrap items-center justify-between gap-3 sm:px-6">
            <div>
                <p class="text-sm text-gray-600">{{ $albums->count() }} {{ \Illuminate\Support\Str::plural('album', $albums->count()) }}</p>
                <p class="mt-0.5 text-xs text-gray-500">{{ $items->count() }} photo(s) total</p>
            </div>
            <a href="{{ route('admin-dashboard.gallery.create') }}"
               class="inline-flex items-center px-4 py-2 rounded-lg font-medium bg-admin-teal text-white hover:bg-admin-teal-dark text-sm">
                Add album / images
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="admin-table min-w-full">
                <thead>
                    <tr>
                        <th class="text-left w-24">Order</th>
                        <th class="text-left">Cover</th>
                        <th class="text-left">Album</th>
                        <th class="text-left">Photos</th>
                        <th class="text-left">Published</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($albums as $album)
                        @php
                            $cover = $album['items']->first();
                            $publishedCount = $album['items']->where('is_published', true)->count();
                        @endphp
                        <tr>
                            <td class="align-middle">
                                <div class="inline-flex items-center gap-1">
                                    <form action="{{ route('admin-dashboard.gallery.albums.reorder', $album['key']) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="direction" value="up">
                                        <button
                                            type="submit"
                                            @disabled($loop->first)
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-40"
                                            title="Move album up"
                                            aria-label="Move {{ $album['title'] }} up"
                                        >
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                                            </svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin-dashboard.gallery.albums.reorder', $album['key']) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="direction" value="down">
                                        <button
                                            type="submit"
                                            @disabled($loop->last)
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-40"
                                            title="Move album down"
                                            aria-label="Move {{ $album['title'] }} down"
                                        >
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td class="py-2 align-middle">
                                @if($cover)
                                    <img src="{{ $cover->resolvedImageUrl() }}" alt="" class="h-14 w-20 rounded object-cover bg-gray-100">
                                @endif
                            </td>
                            <td class="align-middle">
                                <a href="{{ route('admin-dashboard.gallery.album', $album['key']) }}" class="text-sm font-medium text-gray-900 hover:text-admin-teal">
                                    {{ $album['title'] }}
                                </a>
                            </td>
                            <td class="text-sm text-gray-600 align-middle">{{ $album['items']->count() }}</td>
                            <td class="text-sm align-middle">
                                @if($publishedCount === $album['items']->count())
                                    <span class="text-green-600">All</span>
                                @elseif($publishedCount === 0)
                                    <span class="text-gray-400">None</span>
                                @else
                                    <span class="text-amber-600">{{ $publishedCount }}/{{ $album['items']->count() }}</span>
                                @endif
                            </td>
                            <td class="text-right text-sm align-middle">
                                <a href="{{ route('admin-dashboard.gallery.album', $album['key']) }}" class="text-admin-teal hover:underline">Open album</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-10">
                                No gallery albums yet.
                                <a href="{{ route('admin-dashboard.gallery.create') }}" class="text-admin-teal hover:underline">Add images</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
