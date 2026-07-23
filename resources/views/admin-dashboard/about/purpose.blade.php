@extends('admin-dashboard.layouts.app')
@section('title', 'About: Purpose')
@section('header', 'Purpose (Mission & Vision)')

@section('content')
    <div class="max-w-7xl space-y-6">
        <div class="rounded-2xl bg-admin-surface border border-gray-200 shadow-sm p-6 sm:p-8">
            <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-admin-muted">About page</p>
            <div class="mt-2 flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <h2 class="text-xl font-semibold text-admin-dark">Edit Purpose section</h2>
                    <p class="mt-1 text-sm text-admin-muted">
                        This content appears on the public About page.
                        <a class="text-admin-teal hover:underline font-medium" href="{{ url('/about') }}" target="_blank" rel="noopener">View About page</a>
                    </p>
                </div>
                <div class="shrink-0 hidden sm:flex items-center gap-2">
                    <a href="{{ route('admin-dashboard.index') }}"
                       class="px-4 py-2 rounded-lg border border-gray-300 text-admin-dark hover:bg-admin-bg">Back</a>
                    <button type="submit" form="aboutPurposeForm"
                            class="px-4 py-2 rounded-lg bg-admin-teal text-white font-medium hover:bg-admin-teal-dark">
                        Save changes
                    </button>
                </div>
            </div>
        </div>

        <div class="rounded-2xl bg-admin-surface border border-gray-200 shadow-sm p-6 sm:p-8">
            <form id="aboutPurposeForm" action="{{ route('admin-dashboard.about-purpose.update') }}" method="post" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div>
                    <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-admin-muted">Section header</p>
                    <p class="mt-1 text-sm text-admin-muted">Shown above the three cards on the About page.</p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-admin-dark mb-1">Section kicker</label>
                        <input type="text" name="kicker" value="{{ old('kicker', $kicker) }}" required
                               class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal">
                        @error('kicker')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-admin-dark mb-1">Section heading</label>
                        <input type="text" name="heading" value="{{ old('heading', $heading) }}" required
                               class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal">
                        @error('heading')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="pt-2">
                    <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-admin-muted">Cards</p>
                    <p class="mt-1 text-sm text-admin-muted">Edit Mission, Vision, and the right feature card (“How we work”).</p>
                </div>

                <div class="grid gap-6 lg:grid-cols-3">
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-admin-muted">Mission card</p>
                            <span class="inline-flex items-center rounded-full bg-admin-gold/15 text-admin-gold-dark px-2 py-0.5 text-[11px] font-semibold">Left</span>
                        </div>
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-admin-dark mb-1">Kicker</label>
                            <input type="text" name="mission_kicker" value="{{ old('mission_kicker', $mission_kicker) }}" required
                                   class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal">
                            @error('mission_kicker')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-admin-dark mb-1">Title</label>
                            <input type="text" name="mission_title" value="{{ old('mission_title', $mission_title) }}" required
                                   class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal">
                            @error('mission_title')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="mt-3">
                            <x-admin.trix-field
                                name="mission_body"
                                label="Body"
                                :value="$mission_body"
                                minHeight="12rem"
                            />
                        </div>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-admin-muted">Vision card</p>
                            <span class="inline-flex items-center rounded-full bg-admin-teal/10 text-admin-teal-dark px-2 py-0.5 text-[11px] font-semibold">Left</span>
                        </div>
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-admin-dark mb-1">Kicker</label>
                            <input type="text" name="vision_kicker" value="{{ old('vision_kicker', $vision_kicker) }}" required
                                   class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal">
                            @error('vision_kicker')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-admin-dark mb-1">Title</label>
                            <input type="text" name="vision_title" value="{{ old('vision_title', $vision_title) }}" required
                                   class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal">
                            @error('vision_title')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="mt-3">
                            <x-admin.trix-field
                                name="vision_body"
                                label="Body"
                                :value="$vision_body"
                                minHeight="12rem"
                            />
                        </div>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-admin-muted">How we work (feature card)</p>
                            <span class="inline-flex items-center rounded-full bg-admin-coral/10 text-admin-coral-dark px-2 py-0.5 text-[11px] font-semibold">Right</span>
                        </div>
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-admin-dark mb-1">Kicker</label>
                            <input type="text" name="right_kicker" value="{{ old('right_kicker', $right_kicker) }}" required
                                   class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal">
                            @error('right_kicker')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-admin-dark mb-1">Title</label>
                            <input type="text" name="right_title" value="{{ old('right_title', $right_title) }}" required
                                   class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal">
                            @error('right_title')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-admin-dark mb-1">Image (optional)</label>
                            <div class="mb-3 aspect-[4/3] rounded-xl overflow-hidden border border-gray-200 bg-gray-50">
                                <img
                                    id="aboutPurposeRightPreview"
                                    src="{{ !empty($right_image_url) ? $right_image_url : (\App\Support\SiteImage::urlFor('placeholder_care') ?: config('ctc.placeholder_images.care')) }}"
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
                                        name="right_image"
                                        accept="image/*"
                                        class="sr-only"
                                        data-preview-target="aboutPurposeRightPreview"
                                        data-filename-target="aboutPurposeRightFilename"
                                    >
                                </label>
                                <span id="aboutPurposeRightFilename" class="text-sm text-admin-muted truncate">No file selected</span>
                            </div>
                            @error('right_image')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            <p class="text-xs text-admin-muted mt-1">Shown on the right side of the “How we work” card.</p>
                        </div>
                        <div class="mt-3">
                            <x-admin.trix-field
                                name="right_body"
                                label="Body"
                                :value="$right_body"
                                minHeight="12rem"
                            />
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-2">
                    <p class="text-xs text-admin-muted">
                        Tip: Keep headings short so cards scan well.
                    </p>
                    <div class="flex gap-3">
                    <a href="{{ route('admin-dashboard.index') }}"
                       class="px-4 py-2 rounded-lg border border-gray-300 text-admin-dark hover:bg-admin-bg">Back</a>
                    <button type="submit"
                            class="px-4 py-2 rounded-lg bg-admin-teal text-white font-medium hover:bg-admin-teal-dark">
                        Save changes
                    </button>
                    </div>
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

