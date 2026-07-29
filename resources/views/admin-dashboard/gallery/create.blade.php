@extends('admin-dashboard.layouts.app')

@section('title', !empty($albumKey) ? 'Add to album' : 'Add gallery album')
@section('header', !empty($albumKey) ? 'Add images to album' : 'Add gallery album')

@section('content')
    <div class="mb-4">
        <a href="{{ !empty($albumKey) ? route('admin-dashboard.gallery.album', $albumKey) : route('admin-dashboard.gallery.index') }}" class="text-sm text-admin-teal hover:underline">&larr; Back</a>
    </div>

    <div class="rounded-xl bg-white border border-gray-200 shadow-sm p-6 max-w-3xl">
        @if ($errors->any())
            <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <p class="font-semibold">Upload could not be saved</p>
                <ul class="mt-1 list-disc pl-5 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin-dashboard.gallery.store') }}" method="post" enctype="multipart/form-data" class="space-y-5"
              x-data="{
                  dragging: false,
                  previews: [],
                  fileNames: [],
                  error: '',
                  maxBytes: 10 * 1024 * 1024,
                  maxFiles: 20,
                  pick(files) {
                      this.error = '';
                      const selected = Array.from(files || []).filter(f => f && f.type && f.type.startsWith('image/'));
                      if (!selected.length) {
                          this.error = 'Please choose JPEG, PNG, WebP, or GIF files.';
                          return;
                      }
                      if (selected.length > this.maxFiles) {
                          this.error = 'Please upload at most ' + this.maxFiles + ' images at a time.';
                          return;
                      }
                      const tooBig = selected.find(f => f.size > this.maxBytes);
                      if (tooBig) {
                          this.error = '“' + tooBig.name + '” is over 10MB. Compress it or choose a smaller file.';
                          return;
                      }
                      const total = selected.reduce((sum, f) => sum + f.size, 0);
                      if (total > 32 * 1024 * 1024) {
                          this.error = 'Total batch is too large. Upload fewer images at once (under ~32MB total).';
                          return;
                      }
                      this.previews.forEach(p => URL.revokeObjectURL(p));
                      this.previews = selected.map(f => URL.createObjectURL(f));
                      this.fileNames = selected.map(f => f.name);
                      const dt = new DataTransfer();
                      selected.forEach(f => dt.items.add(f));
                      this.$refs.filesInput.files = dt.files;
                      const url = document.getElementById('image_url');
                      if (url) url.value = '';
                  },
                  clearFile() {
                      this.error = '';
                      this.previews.forEach(p => URL.revokeObjectURL(p));
                      this.previews = [];
                      this.fileNames = [];
                      this.$refs.filesInput.value = '';
                  }
              }">
            @csrf
            @if(!empty($albumKey))
                <input type="hidden" name="album_key" value="{{ $albumKey }}">
            @endif
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal focus:border-admin-teal">
                <p class="mt-1 text-xs text-gray-500">Used as the album name for new albums (and photo titles when uploading multiple).</p>
                @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <x-admin.trix-field
                name="caption"
                id="caption"
                label="Caption"
                help="One caption is applied to every image in this upload batch."
                minHeight="8rem"
            />

            <div>
                <span class="block text-sm font-medium text-gray-700 mb-2">Images *</span>
                <p class="text-xs text-gray-500 mb-3">Drag and drop one or many files. JPEG/PNG/WebP/GIF · max 10MB each · up to 20 files per batch.</p>

                <div
                    class="rounded-xl border-2 border-dashed transition-colors"
                    :class="dragging ? 'border-admin-teal bg-admin-teal/5' : 'border-gray-300 bg-gray-50/50'"
                >
                    <input type="file" name="images[]" x-ref="filesInput" multiple accept="image/jpeg,image/png,image/webp,image/gif,.jpg,.jpeg,.png,.webp,.gif" class="sr-only"
                           @change="pick($event.target.files)">

                    <div role="button" tabindex="0"
                         @click="$refs.filesInput.click()"
                         @keydown.enter.prevent="$refs.filesInput.click()"
                         @keydown.space.prevent="$refs.filesInput.click()"
                         @dragover.prevent="dragging = true"
                         @dragleave.prevent="dragging = false"
                         @drop.prevent="dragging = false; pick($event.dataTransfer.files)"
                         class="w-full cursor-pointer px-6 py-10 rounded-xl focus:outline-none focus:ring-2 focus:ring-admin-teal focus:ring-inset">
                        <div class="flex flex-col items-center text-center gap-3 pointer-events-none">
                            <span class="flex h-12 w-12 items-center justify-center rounded-full bg-admin-teal/15 text-admin-teal">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                            </span>
                            <div>
                                <span class="text-sm font-semibold text-gray-900">Drop image(s) here or click to upload</span>
                                <p class="mt-1 text-xs text-gray-500">If a batch fails, try fewer or smaller files.</p>
                            </div>
                        </div>
                    </div>
                    <div x-show="fileNames.length" x-cloak class="px-6 pb-6 border-t border-gray-200/80 pt-4">
                        <p class="text-xs font-medium text-admin-teal text-center">
                            <span x-text="fileNames.length"></span> file(s) selected
                        </p>
                        <div class="mt-3 grid grid-cols-2 sm:grid-cols-3 gap-3">
                            <template x-for="(preview, idx) in previews" :key="idx">
                                <img :src="preview" alt="" class="h-24 w-full rounded-lg border border-gray-200 object-cover bg-white">
                            </template>
                        </div>
                        <button type="button" @click="clearFile()" class="mt-3 text-xs text-red-600 hover:underline">Clear files</button>
                    </div>
                </div>
                <p x-show="error" x-cloak class="mt-2 text-sm text-red-600" x-text="error"></p>
                @error('images')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                @error('images.*')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="relative">
                <label for="image_url" class="block text-sm font-medium text-gray-700 mb-1">Or paste image URL</label>
                <input type="text" name="image_url" id="image_url" value="{{ old('image_url') }}"
                       placeholder="https://…"
                       class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal focus:border-admin-teal">
                <p class="mt-1 text-xs text-gray-500">Optional for adding one external image without upload.</p>
                @error('image_url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }} class="rounded border-gray-300 text-admin-teal focus:ring-ctc-blue">
                <label for="is_published" class="ml-2 text-sm text-gray-700">Published (visible on site)</label>
            </div>
            <div class="flex gap-3 pt-2">
                <a href="{{ !empty($albumKey) ? route('admin-dashboard.gallery.album', $albumKey) : route('admin-dashboard.gallery.index') }}" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium">Cancel</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-admin-teal text-white font-medium hover:bg-admin-teal-dark">Save</button>
            </div>
        </form>
    </div>
@endsection
