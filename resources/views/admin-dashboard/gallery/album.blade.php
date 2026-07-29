@extends('admin-dashboard.layouts.app')

@section('title', $group['title'].' · Gallery')
@section('header', $group['title'])

@section('content')
    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
        <div>
            <a href="{{ route('admin-dashboard.gallery.index') }}" class="text-sm text-admin-teal hover:underline">&larr; All albums</a>
            <p class="mt-1 text-sm text-gray-600">{{ $items->count() }} photo(s) in this album</p>
        </div>
        <a href="{{ route('admin-dashboard.gallery.create', ['album' => $albumKey]) }}"
           class="inline-flex items-center px-4 py-2 rounded-lg font-medium bg-admin-teal text-white hover:bg-admin-teal-dark text-sm">
            Add images to album
        </a>
    </div>

    <div class="rounded-xl bg-white border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="admin-table min-w-full">
                <thead>
                    <tr>
                        <th class="text-left w-24">Order</th>
                        <th class="text-left">Preview</th>
                        <th class="text-left">Title</th>
                        <th class="text-left">Published</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($items as $item)
                        <tr>
                            <td class="align-middle">
                                <div class="inline-flex items-center gap-1">
                                    <form action="{{ route('admin-dashboard.gallery.items.reorder', $item) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="direction" value="up">
                                        <button
                                            type="submit"
                                            @disabled($loop->first)
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-40"
                                            title="Move up"
                                        >
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                                            </svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin-dashboard.gallery.items.reorder', $item) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="direction" value="down">
                                        <button
                                            type="submit"
                                            @disabled($loop->last)
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-40"
                                            title="Move down"
                                        >
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td class="py-2 align-middle">
                                <img src="{{ $item->resolvedImageUrl() }}" alt="" class="h-14 w-20 rounded object-cover bg-gray-100">
                            </td>
                            <td class="text-sm font-medium text-gray-900 align-middle">{{ $item->title }}</td>
                            <td class="text-sm align-middle">
                                @if($item->is_published)<span class="text-green-600">Yes</span>@else<span class="text-gray-400">No</span>@endif
                            </td>
                            <td class="text-right text-sm align-middle">
                                <a href="{{ route('admin-dashboard.gallery.edit', $item) }}" class="text-admin-teal hover:underline mr-3">Edit</a>
                                <form action="{{ route('admin-dashboard.gallery.destroy', $item) }}" method="post" class="inline" onsubmit="return confirm('Remove this image from the album?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
