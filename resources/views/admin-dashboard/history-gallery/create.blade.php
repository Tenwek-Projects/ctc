@extends('admin-dashboard.layouts.app')

@section('title', 'Add history gallery image')
@section('header', 'Add history gallery image')

@section('content')
    <div class="rounded-xl bg-white border border-gray-200 shadow-sm p-6 max-w-3xl">
        <form action="{{ route('admin-dashboard.history-gallery.store') }}" method="post" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                       class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal focus:border-admin-teal">
                @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <x-admin.trix-field name="caption" id="caption" label="Caption" minHeight="8rem" />

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image *</label>
                <input type="file" name="image" id="image" required accept="image/jpeg,image/png,image/webp,image/gif"
                       class="w-full rounded-lg border border-gray-300 px-3 py-2 file:mr-3 file:rounded-md file:border-0 file:bg-admin-teal file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-white hover:file:bg-admin-teal-dark">
                <p class="mt-1 text-xs text-gray-500">JPEG, PNG, WebP or GIF up to 5MB.</p>
                @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Sort order</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal focus:border-admin-teal">
                    @error('sort_order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center pt-8">
                    <input type="checkbox" name="is_visible" id="is_visible" value="1" {{ old('is_visible', true) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-admin-teal focus:ring-admin-teal">
                    <label for="is_visible" class="ml-2 text-sm text-gray-700">Visible on History page</label>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('admin-dashboard.history-gallery.index') }}" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium">Cancel</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-admin-teal text-white font-medium hover:bg-admin-teal-dark">Save</button>
            </div>
        </form>
    </div>
@endsection

