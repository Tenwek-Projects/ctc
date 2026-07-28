@extends('admin-dashboard.layouts.app')

@section('title', 'Add event')
@section('header', 'Add event')

@section('content')
    <div class="rounded-xl bg-white border border-gray-200 shadow-sm p-6 max-w-3xl">
        <form action="{{ route('admin-dashboard.events.store') }}" method="post" enctype="multipart/form-data" class="space-y-5" x-data="{ previewUrl: null }">
            @csrf
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Event title *</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal focus:border-admin-teal">
                @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="event_date" class="block text-sm font-medium text-gray-700 mb-1">Event date *</label>
                    <input type="datetime-local" name="event_date" id="event_date" value="{{ old('event_date') }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal focus:border-admin-teal">
                    @error('event_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug (optional)</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal focus:border-admin-teal" placeholder="Auto-generated if empty">
                </div>
            </div>
            <x-admin.trix-field name="excerpt" label="Excerpt" help="Short teaser for listings." minHeight="8rem" />
            <x-admin.trix-field name="body" label="Description" help="Full event details." />
            <div class="space-y-3">
                <div>
                    <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-1">Event image</label>
                    <input type="file" name="featured_image" id="featured_image" accept="image/*"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal focus:border-admin-teal bg-white"
                           @change="previewUrl = $event.target.files?.[0] ? URL.createObjectURL($event.target.files[0]) : null">
                </div>
                <div>
                    <label for="featured_image_url" class="block text-sm font-medium text-gray-700 mb-1">Or paste image URL</label>
                    <input type="text" name="featured_image_url" id="featured_image_url" value="{{ old('featured_image_url') }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal focus:border-admin-teal" placeholder="https://...">
                </div>
                <div x-show="previewUrl" x-cloak class="rounded-xl overflow-hidden border border-gray-200 bg-gray-50">
                    <div class="aspect-video"><img :src="previewUrl" alt="Preview" class="h-full w-full object-cover"></div>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">Publish date</label>
                    <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at') }}" class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal focus:border-admin-teal">
                </div>
                <div class="flex items-center pt-8">
                    <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }} class="rounded border-gray-300 text-admin-teal focus:ring-ctc-blue">
                    <label for="is_published" class="ml-2 text-sm text-gray-700">Published</label>
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <a href="{{ route('admin-dashboard.events.index') }}" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium">Cancel</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-admin-teal text-white font-medium hover:bg-admin-teal-dark">Save event</button>
            </div>
        </form>
    </div>
@endsection

