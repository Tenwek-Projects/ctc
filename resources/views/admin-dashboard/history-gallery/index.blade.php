@extends('admin-dashboard.layouts.app')

@section('title', 'History gallery')
@section('header', 'History gallery')

@section('content')
    <div class="rounded-xl bg-white border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 flex flex-wrap items-center justify-between gap-3 sm:px-6">
            <p class="text-sm text-gray-600">{{ $items->total() }} image(s)</p>
            <a href="{{ route('admin-dashboard.history-gallery.create') }}"
               class="inline-flex items-center px-4 py-2 rounded-lg font-medium bg-admin-teal text-white hover:bg-admin-teal-dark text-sm">
                Add image
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="admin-table min-w-full">
                <thead>
                    <tr>
                        <th class="text-left">Preview</th>
                        <th class="text-left">Title</th>
                        <th class="text-left">Sort</th>
                        <th class="text-left">Visible</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($items as $item)
                        <tr class="hover:bg-admin-bg/40">
                            <td class="py-2">
                                <img src="{{ $item->imageUrl() }}" alt="" class="h-14 w-20 rounded object-cover bg-gray-100">
                            </td>
                            <td class="text-sm font-medium text-gray-900">{{ $item->title }}</td>
                            <td class="text-sm text-gray-600">{{ $item->sort_order }}</td>
                            <td class="text-sm">
                                @if($item->is_visible)<span class="text-green-600">Yes</span>@else<span class="text-gray-400">No</span>@endif
                            </td>
                            <td class="text-right text-sm">
                                <a href="{{ route('admin-dashboard.history-gallery.edit', $item) }}" class="text-admin-teal hover:underline mr-3">Edit</a>
                                <form action="{{ route('admin-dashboard.history-gallery.destroy', $item) }}" method="post" class="inline" onsubmit="return confirm('Remove this image from History gallery?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 py-10">
                                No History gallery images yet.
                                <a href="{{ route('admin-dashboard.history-gallery.create') }}" class="text-admin-teal hover:underline">Add one</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($items->hasPages())
            <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $items->links() }}
            </div>
        @endif
    </div>
@endsection

