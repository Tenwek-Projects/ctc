@extends('admin-dashboard.layouts.app')

@section('title', 'Edit gallery image')
@section('header', 'Edit gallery image')

@section('content')
    <div class="rounded-xl bg-white border border-gray-200 shadow-sm p-6 max-w-3xl">
        <form action="{{ route('admin-dashboard.gallery.update', $item) }}" method="post" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                <input type="text" name="title" id="title" value="{{ old('title', $item->title) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal focus:border-admin-teal">
                @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <x-admin.trix-field
                name="caption"
                id="caption"
                label="Caption"
                :value="$item->caption"
                minHeight="8rem"
            />

            <div>
                <span class="block text-sm font-medium text-gray-700 mb-2">Image *</span>
                @if($item->image_url)
                    <div class="mb-4 rounded-lg border border-gray-200 p-3 bg-gray-50">
                        <p class="text-xs font-medium text-gray-600 mb-2">Current</p>
                        <img src="{{ $item->resolvedImageUrl() }}" alt="" class="max-h-48 rounded object-contain">
                    </div>
                @endif

                <p class="text-xs text-gray-500 mb-3">Replace by dragging a new file here or browsing. Or change the URL below.</p>
                <div
                    class="rounded-xl border-2 border-dashed transition-colors"
                    x-data="{
                        dragging: false,
                        previewUrl: null,
                        fileName: '',
                        pick(files) {
                            const f = files && files[0];
                            if (!f || !f.type.startsWith('image/')) return;
                            if (this.previewUrl) URL.revokeObjectURL(this.previewUrl);
                            this.previewUrl = URL.createObjectURL(f);
                            this.fileName = f.name;
                            const dt = new DataTransfer();
                            dt.items.add(f);
                            this.$refs.fileInput.files = dt.files;
                            document.getElementById('image_url').value = '';
                        },
                        clearFile() {
                            if (this.previewUrl) URL.revokeObjectURL(this.previewUrl);
                            this.previewUrl = null;
                            this.fileName = '';
                            this.$refs.fileInput.value = '';
                        }
                    }"
                    :class="dragging ? 'border-admin-teal bg-admin-teal/5' : 'border-gray-300 bg-gray-50/50'"
                >
                    <input type="file" name="image" x-ref="fileInput" accept="image/jpeg,image/png,image/webp,image/gif" class="sr-only"
                           @change="pick($event.target.files)">

                    <div role="button" tabindex="0"
                         @click="$refs.fileInput.click()"
                         @keydown.enter.prevent="$refs.fileInput.click()"
                         @keydown.space.prevent="$refs.fileInput.click()"
                         @dragover.prevent="dragging = true"
                         @dragleave.prevent="dragging = false"
                         @drop.prevent="dragging = false; pick($event.dataTransfer.files)"
                         class="w-full cursor-pointer px-6 py-8 rounded-xl focus:outline-none focus:ring-2 focus:ring-admin-teal focus:ring-inset">
                        <div class="flex flex-col items-center text-center gap-2 pointer-events-none">
                            <span class="text-sm font-semibold text-gray-900">Drop new image or click to replace</span>
                            <p class="text-xs text-gray-500">JPEG, PNG, WebP or GIF · max 10&nbsp;MB</p>
                        </div>
                    </div>
                    <div x-show="fileName" x-cloak class="px-6 pb-6 flex flex-col items-center gap-2 border-t border-gray-200/80 pt-4">
                        <p class="text-xs font-medium text-admin-teal truncate max-w-full text-center" x-text="fileName"></p>
                        <p class="text-xs text-gray-500">New upload (saved on submit)</p>
                        <img x-bind:src="previewUrl" alt="" class="max-h-40 rounded-lg border border-gray-200 object-contain bg-white">
                        <button type="button" @click="clearFile()" class="text-xs text-red-600 hover:underline">Clear new file</button>
                    </div>
                </div>
                @error('image')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="image_url" class="block text-sm font-medium text-gray-700 mb-1">Image URL (if not uploading)</label>
                <input type="text" name="image_url" id="image_url" value="{{ old('image_url', $item->image_url) }}"
                       class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal focus:border-admin-teal">
                <p class="mt-1 text-xs text-gray-500">HTTPS URL or leave as stored path. Choosing a file above clears this until you submit.</p>
                @error('image_url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Sort order</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $item->sort_order) }}" min="0" class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal focus:border-admin-teal">
                    @error('sort_order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center pt-8">
                    <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $item->is_published) ? 'checked' : '' }} class="rounded border-gray-300 text-ctc-blue focus:ring-ctc-blue">
                    <label for="is_published" class="ml-2 text-sm text-gray-700">Published (visible on site)</label>
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <a href="{{ route('admin-dashboard.gallery.index') }}" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium">Cancel</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-admin-teal text-white font-medium hover:bg-admin-teal-dark">Update</button>
            </div>
        </form>
    </div>
@endsection
