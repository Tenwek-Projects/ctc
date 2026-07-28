@extends('admin-dashboard.layouts.app')

@section('title', 'Edit event')
@section('header', 'Edit event')

@section('content')
    <div class="rounded-xl bg-white border border-gray-200 shadow-sm p-6 max-w-3xl">
        <form action="{{ route('admin-dashboard.events.update', $event) }}" method="post" enctype="multipart/form-data" class="space-y-5" x-data="{ previewUrl: null }">
            @csrf
            @method('PUT')
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Event title *</label>
                <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal focus:border-admin-teal">
                @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="event_date" class="block text-sm font-medium text-gray-700 mb-1">Event date *</label>
                    <input type="datetime-local" name="event_date" id="event_date" value="{{ old('event_date', $event->event_date?->format('Y-m-d\TH:i')) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal focus:border-admin-teal">
                    @error('event_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $event->slug) }}" class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal focus:border-admin-teal">
                </div>
            </div>
            <x-admin.trix-field name="excerpt" label="Excerpt" :value="$event->excerpt" help="Short teaser for listings." minHeight="8rem" />
            <x-admin.trix-field name="body" label="Description" :value="$event->body" help="Full event details." />
            <div class="space-y-3">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-1">Event image</label>
                        <input type="file" name="featured_image" id="featured_image" accept="image/*"
                               class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal focus:border-admin-teal bg-white"
                               @change="previewUrl = $event.target.files?.[0] ? URL.createObjectURL($event.target.files[0]) : null">
                    </div>
                    <div class="pt-7">
                        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                            <input type="checkbox" name="remove_featured_image" value="1" class="rounded border-gray-300 text-admin-teal focus:ring-admin-teal">
                            Remove image
                        </label>
                    </div>
                </div>
                <div>
                    <label for="featured_image_url" class="block text-sm font-medium text-gray-700 mb-1">Or paste image URL</label>
                    <input type="text" name="featured_image_url" id="featured_image_url" value="{{ old('featured_image_url') }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal focus:border-admin-teal" placeholder="https://...">
                </div>
                @if($event->featured_image_url)
                    <div class="rounded-xl overflow-hidden border border-gray-200 bg-gray-50">
                        <div class="aspect-video"><img src="{{ $event->featured_image_url }}" alt="{{ $event->title }}" class="h-full w-full object-cover"></div>
                    </div>
                @endif
                <div x-show="previewUrl" x-cloak class="rounded-xl overflow-hidden border border-gray-200 bg-gray-50">
                    <div class="aspect-video"><img :src="previewUrl" alt="Preview" class="h-full w-full object-cover"></div>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">Publish date</label>
                    <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', $event->published_at?->format('Y-m-d\TH:i')) }}" class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal focus:border-admin-teal">
                </div>
                <div class="flex items-center pt-8">
                    <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $event->is_published) ? 'checked' : '' }} class="rounded border-gray-300 text-admin-teal focus:ring-ctc-blue">
                    <label for="is_published" class="ml-2 text-sm text-gray-700">Published</label>
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <a href="{{ route('admin-dashboard.events.index') }}" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium">Cancel</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-admin-teal text-white font-medium hover:bg-admin-teal-dark">Update event</button>
            </div>
        </form>
    </div>
@endsection

