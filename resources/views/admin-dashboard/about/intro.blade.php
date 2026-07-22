@extends('admin-dashboard.layouts.app')
@section('title', 'About: Who we are')
@section('header', 'Who we are (About page)')

@section('content')
    <div class="max-w-3xl space-y-6">
        <div class="rounded-xl bg-admin-surface border border-gray-200 shadow-sm p-6">
            <div class="flex items-start justify-between gap-6">
                <div>
                    <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-admin-muted">About page</p>
                    <h2 class="mt-2 text-xl font-semibold text-admin-dark">Edit “Who we are” intro</h2>
                    <p class="mt-1 text-sm text-admin-muted">
                        This content appears at the top of the public About page.
                        <a class="text-admin-teal hover:underline font-medium" href="{{ url('/about') }}" target="_blank" rel="noopener">View About page</a>
                    </p>
                </div>
            </div>
        </div>

        @if($executiveBrochure)
            <div class="rounded-xl bg-admin-surface border border-gray-200 shadow-sm p-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-admin-muted">Download monitoring</p>
                        <h3 class="mt-2 text-lg font-semibold text-admin-dark">{{ $executiveBrochure->title }}</h3>
                        <p class="mt-1 text-sm text-admin-muted">
                            Tracked downloads from the About page button
                            @unless($executiveBrochure->existsOnDisk())
                                <span class="text-amber-700">· PDF file missing from public folder</span>
                            @endunless
                        </p>
                    </div>
                    <div class="rounded-xl border border-gray-200 bg-gray-50 px-5 py-4 text-center">
                        <p class="text-3xl font-extrabold tabular-nums text-admin-dark">{{ number_format($executiveBrochure->download_count) }}</p>
                        <p class="mt-1 text-xs font-semibold uppercase tracking-[0.16em] text-admin-muted">
                            {{ $executiveBrochure->download_count === 1 ? 'Download' : 'Downloads' }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="rounded-xl bg-admin-surface border border-gray-200 shadow-sm p-6">
            <form action="{{ route('admin-dashboard.about-intro.update') }}" method="post" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid gap-6 sm:grid-cols-12">
                    <div class="sm:col-span-7">
                        <label class="block text-sm font-medium text-admin-dark mb-1">Main image (4:3 recommended)</label>
                        <div class="mb-3 aspect-[4/3] rounded-xl overflow-hidden border border-gray-200 bg-gray-50">
                            <img
                                id="aboutIntroPreviewMain"
                                src="{{ !empty($images['main']) ? $images['main'] : config('ctc.placeholder_images.facility') }}"
                                alt=""
                                class="h-full w-full object-cover"
                            >
                        </div>
                        <div class="flex items-center gap-3">
                            <label class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-admin-teal text-white font-medium hover:bg-admin-teal-dark shadow-sm cursor-pointer transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12V4m0 8l-3-3m3 3l3-3"/>
                                </svg>
                                Choose file
                                <input
                                    type="file"
                                    id="aboutIntroFileMain"
                                    name="image_main"
                                    accept="image/*"
                                    class="sr-only"
                                    data-preview-target="aboutIntroPreviewMain"
                                    data-filename-target="aboutIntroFilenameMain"
                                >
                            </label>
                            <span id="aboutIntroFilenameMain" class="text-sm text-admin-muted truncate">No file selected</span>
                        </div>
                        @error('image_main')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        <p class="text-xs text-admin-muted mt-1">Used for the large image on the right.</p>
                    </div>
                    <div class="sm:col-span-5 grid gap-4">
                        <div>
                            <label class="block text-sm font-medium text-admin-dark mb-1">Small image 1 (square)</label>
                            <div class="mb-3 aspect-square rounded-xl overflow-hidden border border-gray-200 bg-gray-50">
                                <img
                                    id="aboutIntroPreviewSide1"
                                    src="{{ !empty($images['side_1']) ? $images['side_1'] : config('ctc.placeholder_images.team') }}"
                                    alt=""
                                    class="h-full w-full object-cover"
                                >
                            </div>
                            <div class="flex items-center gap-3">
                                <label class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-admin-teal text-white font-medium hover:bg-admin-teal-dark shadow-sm cursor-pointer transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12V4m0 8l-3-3m3 3l3-3"/>
                                    </svg>
                                    Choose file
                                    <input
                                        type="file"
                                        id="aboutIntroFileSide1"
                                        name="image_side_1"
                                        accept="image/*"
                                        class="sr-only"
                                        data-preview-target="aboutIntroPreviewSide1"
                                        data-filename-target="aboutIntroFilenameSide1"
                                    >
                                </label>
                                <span id="aboutIntroFilenameSide1" class="text-sm text-admin-muted truncate">No file selected</span>
                            </div>
                            @error('image_side_1')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-admin-dark mb-1">Small image 2 (square)</label>
                            <div class="mb-3 aspect-square rounded-xl overflow-hidden border border-gray-200 bg-gray-50">
                                <img
                                    id="aboutIntroPreviewSide2"
                                    src="{{ !empty($images['side_2']) ? $images['side_2'] : config('ctc.placeholder_images.care') }}"
                                    alt=""
                                    class="h-full w-full object-cover"
                                >
                            </div>
                            <div class="flex items-center gap-3">
                                <label class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-admin-teal text-white font-medium hover:bg-admin-teal-dark shadow-sm cursor-pointer transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12V4m0 8l-3-3m3 3l3-3"/>
                                    </svg>
                                    Choose file
                                    <input
                                        type="file"
                                        id="aboutIntroFileSide2"
                                        name="image_side_2"
                                        accept="image/*"
                                        class="sr-only"
                                        data-preview-target="aboutIntroPreviewSide2"
                                        data-filename-target="aboutIntroFilenameSide2"
                                    >
                                </label>
                                <span id="aboutIntroFilenameSide2" class="text-sm text-admin-muted truncate">No file selected</span>
                            </div>
                            @error('image_side_2')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-admin-dark mb-1">Small label (kicker)</label>
                    <input type="text" name="kicker" value="{{ old('kicker', $kicker) }}" required
                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal">
                    @error('kicker')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-admin-dark mb-1">Heading</label>
                    <input type="text" name="heading" value="{{ old('heading', $heading) }}" required
                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal">
                    @error('heading')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-admin-dark mb-1">Intro paragraph</label>
                    <input id="aboutIntroBody" type="hidden" name="body" value="{{ old('body', $body) }}">
                    <trix-editor input="aboutIntroBody" class="w-full bg-white"></trix-editor>
                    @error('body')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid gap-4">
                    <div>
                        <label class="block text-sm font-medium text-admin-dark mb-1">Bullet 1</label>
                        <input type="text" name="bullet_1" value="{{ old('bullet_1', $bullets[0] ?? '') }}" required
                               class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal">
                        @error('bullet_1')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-admin-dark mb-1">Bullet 2</label>
                        <input type="text" name="bullet_2" value="{{ old('bullet_2', $bullets[1] ?? '') }}" required
                               class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal">
                        @error('bullet_2')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-admin-dark mb-1">Bullet 3</label>
                        <input type="text" name="bullet_3" value="{{ old('bullet_3', $bullets[2] ?? '') }}" required
                               class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal">
                        @error('bullet_3')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('admin-dashboard.about.index') }}"
                       class="px-4 py-2 rounded-lg border border-gray-300 text-admin-dark hover:bg-admin-bg">Back</a>
                    <button type="submit"
                            class="px-4 py-2 rounded-lg bg-admin-teal text-white font-medium hover:bg-admin-teal-dark">
                        Save changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (() => {
            const inputs = Array.from(document.querySelectorAll('input[type="file"][data-preview-target]'));
            if (!inputs.length) return;

            const urlByInput = new Map();

            const setPreview = (input) => {
                const targetId = input.getAttribute('data-preview-target');
                if (!targetId) return;
                const img = document.getElementById(targetId);
                if (!img) return;

                const file = input.files && input.files[0];
                if (!file) return;

                const prevUrl = urlByInput.get(input);
                if (prevUrl) URL.revokeObjectURL(prevUrl);

                const nextUrl = URL.createObjectURL(file);
                urlByInput.set(input, nextUrl);
                img.src = nextUrl;
            };

            const setFilename = (input) => {
                const targetId = input.getAttribute('data-filename-target');
                if (!targetId) return;
                const el = document.getElementById(targetId);
                if (!el) return;
                const file = input.files && input.files[0];
                el.textContent = file ? file.name : 'No file selected';
                if (file) el.title = file.name;
            };

            inputs.forEach((input) => {
                input.addEventListener('change', () => {
                    setPreview(input);
                    setFilename(input);
                }, { passive: true });
            });

            window.addEventListener('beforeunload', () => {
                for (const url of urlByInput.values()) URL.revokeObjectURL(url);
            });
        })();
    </script>
@endsection

