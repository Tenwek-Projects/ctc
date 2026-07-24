@extends('admin-dashboard.layouts.app')

@section('title', 'Edit service')
@section('header', 'Edit service')

@section('content')
    <div class="rounded-xl bg-white border border-gray-200 shadow-sm p-6 max-w-3xl">
        <form action="{{ route('admin-dashboard.services.update', $service) }}" method="post" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $service->name) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal focus:border-admin-teal">
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                <select name="category" id="category" required class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal focus:border-admin-teal">
                    <option value="{{ App\Models\Service::CATEGORY_CARDIAC }}" {{ old('category', $service->category) === App\Models\Service::CATEGORY_CARDIAC ? 'selected' : '' }}>Cardiac surgery</option>
                    <option value="{{ App\Models\Service::CATEGORY_THORACIC }}" {{ old('category', $service->category) === App\Models\Service::CATEGORY_THORACIC ? 'selected' : '' }}>Thoracic surgery</option>
                    <option value="{{ App\Models\Service::CATEGORY_DIAGNOSTICS }}" {{ old('category', $service->category) === App\Models\Service::CATEGORY_DIAGNOSTICS ? 'selected' : '' }}>Diagnostics</option>
                </select>
            </div>
            <x-admin.trix-field
                name="description"
                id="serviceDescriptionTrix"
                label="Description"
                :value="$service->description"
                help="Rich text (headings, lists, bold, links). Shown on the public service detail page."
            />
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Featured image</label>
                @if($service->featured_image_url)
                    <div class="mb-3 aspect-video rounded-xl overflow-hidden border border-gray-200 bg-gray-50">
                        <img src="{{ $service->featured_image_url }}" alt="" class="h-full w-full object-cover">
                    </div>
                @endif
                <input type="file" name="featured_image" id="featured_image" accept="image/*" class="w-full text-sm">
                @error('featured_image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                <p class="mt-1 text-xs text-gray-500">Upload to replace the current image (recommended: 1200×675).</p>
            </div>
            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $service->slug) }}" class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal focus:border-admin-teal">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="flex items-center">
                    <input type="checkbox" name="is_visible" id="is_visible" value="1" {{ old('is_visible', $service->is_visible) ? 'checked' : '' }} class="rounded border-gray-300 text-ctc-blue focus:ring-ctc-blue">
                    <label for="is_visible" class="ml-2 text-sm text-gray-700">Visible on site</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="show_on_homepage" id="show_on_homepage" value="1" {{ old('show_on_homepage', $service->show_on_homepage) ? 'checked' : '' }} class="rounded border-gray-300 text-ctc-blue focus:ring-ctc-blue">
                    <label for="show_on_homepage" class="ml-2 text-sm text-gray-700">Show on homepage</label>
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <a href="{{ route('admin-dashboard.services.index') }}" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium">Cancel</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-admin-teal text-white font-medium hover:bg-admin-teal-dark">Update</button>
            </div>
        </form>
    </div>
@endsection
