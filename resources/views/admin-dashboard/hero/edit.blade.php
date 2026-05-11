@extends('admin-dashboard.layouts.app')

@section('title', 'Hero / Homepage')
@section('header', 'Hero / Homepage')

@section('content')
    <div class="max-w-6xl space-y-8">
        <div class="rounded-xl border border-gray-200 bg-admin-surface shadow-sm p-6">
            <h2 class="text-lg font-semibold text-admin-dark mb-1">Hero mode</h2>
            <p class="text-sm text-admin-muted mb-6">Choose whether the homepage hero uses a looping video or a rotating carousel.</p>

            <form method="post" action="{{ route('admin-dashboard.hero.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="flex items-start gap-3 rounded-xl border border-gray-200 p-4 cursor-pointer hover:border-admin-teal/50">
                        <input type="radio" name="mode" value="video" class="mt-1" {{ old('mode', $mode) === 'video' ? 'checked' : '' }}>
                        <span class="min-w-0">
                            <span class="block font-semibold text-admin-dark">Video</span>
                            <span class="block text-sm text-admin-muted">Use a URL (YouTube or direct MP4) or upload an MP4 from your computer.</span>
                        </span>
                    </label>

                    <label class="flex items-start gap-3 rounded-xl border border-gray-200 p-4 cursor-pointer hover:border-admin-teal/50">
                        <input type="radio" name="mode" value="carousel" class="mt-1" {{ old('mode', $mode) === 'carousel' ? 'checked' : '' }}>
                        <span class="min-w-0">
                            <span class="block font-semibold text-admin-dark">Carousel</span>
                            <span class="block text-sm text-admin-muted">Rotate through multiple slides with background images and optional CTA.</span>
                        </span>
                    </label>
                </div>

                <div class="grid gap-4 lg:grid-cols-12 items-start">
                    <div class="lg:col-span-7">
                        <label for="video_url" class="block text-sm font-semibold text-admin-dark">Hero video URL (optional)</label>
                    <input
                        id="video_url"
                        name="video_url"
                        type="text"
                        value="{{ old('video_url', $videoUrl) }}"
                        placeholder="https://www.youtube.com/watch?v=... or https://your-domain/videos/hero.mp4"
                        class="mt-1.5 block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm text-admin-dark focus:border-admin-teal focus:ring-admin-teal"
                    />
                    @error('video_url')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        <p class="mt-2 text-xs text-admin-muted">Tip: a direct MP4 URL will play as a background video. YouTube URLs embed automatically.</p>
                    </div>

                    <div class="lg:col-span-5">
                        <label class="block text-sm font-semibold text-admin-dark">Upload MP4 (optional)</label>
                        <input type="file" name="video_file" accept="video/mp4,video/quicktime" class="mt-1.5 block w-full text-sm">
                        @error('video_file')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        @if(!empty($videoFileUrl))
                            <div class="mt-3 rounded-xl border border-gray-200 bg-white p-3">
                                <p class="text-xs font-semibold text-admin-dark">Current uploaded video</p>
                                <a href="{{ $videoFileUrl }}" target="_blank" rel="noopener" class="mt-1 inline-flex items-center text-sm font-medium text-admin-teal hover:underline break-all">
                                    {{ $videoFileUrl }}
                                </a>
                            </div>
                        @endif
                        <p class="mt-2 text-xs text-admin-muted">Upload size limit: 50MB. If an upload exists, it takes priority over the URL.</p>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-4">
                    <h3 class="text-sm font-semibold text-admin-dark">Hero text</h3>
                    <p class="mt-1 text-xs text-admin-muted">This content appears on the homepage hero overlay.</p>

                    <div class="mt-4 grid gap-4 lg:grid-cols-12">
                        <div class="lg:col-span-6">
                            <label for="hero_title" class="block text-sm font-semibold text-admin-dark">Title</label>
                            <input
                                id="hero_title"
                                name="hero_title"
                                type="text"
                                value="{{ old('hero_title', $heroTitle ?? '') }}"
                                class="mt-1.5 block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm text-admin-dark focus:border-admin-teal focus:ring-admin-teal"
                                placeholder="Cardiothoracic Centre"
                                required
                            />
                            @error('hero_title')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="lg:col-span-6">
                            <label for="hero_subtitle" class="block text-sm font-semibold text-admin-dark">Badge subtitle</label>
                            <input
                                id="hero_subtitle"
                                name="hero_subtitle"
                                type="text"
                                value="{{ old('hero_subtitle', $heroSubtitle ?? '') }}"
                                class="mt-1.5 block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm text-admin-dark focus:border-admin-teal focus:ring-admin-teal"
                                placeholder="Tenwek Hospital"
                                required
                            />
                            @error('hero_subtitle')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="lg:col-span-12">
                            <label for="hero_description" class="block text-sm font-semibold text-admin-dark">Description</label>
                            <textarea
                                id="hero_description"
                                name="hero_description"
                                rows="4"
                                class="mt-1.5 block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm text-admin-dark focus:border-admin-teal focus:ring-admin-teal"
                                required
                            >{{ old('hero_description', $heroDescription ?? '') }}</textarea>
                            @error('hero_description')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                @error('mode')<p class="text-xs text-red-600">{{ $message }}</p>@enderror

                <div class="flex items-center gap-3">
                    <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-admin-teal text-white text-sm font-medium hover:bg-admin-teal-dark transition-colors">
                        Save hero settings
                    </button>
                </div>
            </form>
        </div>

        <div class="rounded-xl border border-gray-200 bg-admin-surface shadow-sm p-6">
            <h2 class="text-lg font-semibold text-admin-dark mb-1">Homepage: Services image</h2>
            <p class="text-sm text-admin-muted mb-6">Upload one image to visually represent the services section on the homepage.</p>

            <form method="post" action="{{ route('admin-dashboard.hero.services-image.update') }}" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-12 items-end">
                @csrf
                @method('PUT')

                <div class="md:col-span-4">
                    <label class="block text-sm font-semibold text-admin-dark">Current image</label>
                    <div class="mt-1.5 aspect-video rounded-xl overflow-hidden bg-admin-bg border border-gray-200">
                        @if(!empty($servicesImageUrl))
                            <img src="{{ $servicesImageUrl }}" alt="" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full flex items-center justify-center text-sm text-admin-muted">No image uploaded</div>
                        @endif
                    </div>
                </div>

                <div class="md:col-span-6">
                    <label class="block text-sm font-semibold text-admin-dark">Upload new image</label>
                    <input type="file" name="services_image" accept="image/*" class="mt-1.5 block w-full text-sm">
                    @error('services_image')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 rounded-xl bg-admin-teal text-white text-sm font-medium hover:bg-admin-teal-dark transition-colors">
                        Save image
                    </button>
                </div>
            </form>
        </div>

        <div id="carousel-slides" class="rounded-xl border border-gray-200 bg-admin-surface shadow-sm p-6">
            <div class="flex items-start justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-lg font-semibold text-admin-dark">Carousel slides</h2>
                    <p class="text-sm text-admin-muted">These are used when Hero mode is set to <strong>Carousel</strong>.</p>
                </div>
            </div>

            <form method="post" action="{{ route('admin-dashboard.hero.slides.store') }}" enctype="multipart/form-data" class="grid gap-4 lg:grid-cols-12 items-end rounded-xl border border-gray-200 p-4 mb-8">
                @csrf

                <div class="lg:col-span-3">
                    <label class="block text-sm font-semibold text-admin-dark">Image</label>
                    <input type="file" name="image" accept="image/*" class="mt-1.5 block w-full text-sm" required>
                    @error('image')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="lg:col-span-3">
                    <label class="block text-sm font-semibold text-admin-dark">Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="mt-1.5 block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-admin-teal focus:ring-admin-teal">
                </div>

                <div class="lg:col-span-3">
                    <label class="block text-sm font-semibold text-admin-dark">Subtitle</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle') }}" class="mt-1.5 block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-admin-teal focus:ring-admin-teal">
                </div>

                <div class="lg:col-span-2">
                    <label class="block text-sm font-semibold text-admin-dark">Sort order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="mt-1.5 block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-admin-teal focus:ring-admin-teal">
                </div>

                <div class="lg:col-span-1 flex items-center gap-2 pb-2">
                    <input id="is_visible_new" type="checkbox" name="is_visible" value="1" class="rounded border-gray-300" checked>
                    <label for="is_visible_new" class="text-sm text-admin-dark">Visible</label>
                </div>

                <div class="lg:col-span-4">
                    <label class="block text-sm font-semibold text-admin-dark">CTA label</label>
                    <input type="text" name="cta_label" value="{{ old('cta_label') }}" class="mt-1.5 block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-admin-teal focus:ring-admin-teal" placeholder="Book Appointment">
                </div>

                <div class="lg:col-span-6">
                    <label class="block text-sm font-semibold text-admin-dark">CTA URL</label>
                    <input type="text" name="cta_url" value="{{ old('cta_url') }}" class="mt-1.5 block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-admin-teal focus:ring-admin-teal" placeholder="https://... or /contact">
                </div>

                <div class="lg:col-span-2">
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 rounded-xl bg-admin-coral text-white text-sm font-medium hover:bg-admin-coral-dark transition-colors">
                        Add slide
                    </button>
                </div>
            </form>

            <div class="space-y-4">
                @forelse($slides as $slide)
                    <div class="rounded-xl border border-gray-200 p-4">
                        <div class="grid gap-4 lg:grid-cols-12 items-start">
                            <div class="lg:col-span-3">
                                <div class="aspect-video rounded-lg overflow-hidden bg-admin-bg border border-gray-200">
                                    <img src="{{ $slide->image_url }}" alt="" class="h-full w-full object-cover">
                                </div>
                            </div>

                            <div class="lg:col-span-9">
                                <div class="grid gap-4 md:grid-cols-2">
                                    <form method="post" action="{{ route('admin-dashboard.hero.slides.update', $slide) }}" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-2 md:col-span-2">
                                    @csrf
                                    @method('PUT')

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-admin-dark">Replace image (optional)</label>
                                        <input type="file" name="image" accept="image/*" class="mt-1.5 block w-full text-sm">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-admin-dark">Title</label>
                                        <input type="text" name="title" value="{{ old('title', $slide->title) }}" class="mt-1.5 block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-admin-teal focus:ring-admin-teal">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-admin-dark">Subtitle</label>
                                        <input type="text" name="subtitle" value="{{ old('subtitle', $slide->subtitle) }}" class="mt-1.5 block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-admin-teal focus:ring-admin-teal">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-admin-dark">CTA label</label>
                                        <input type="text" name="cta_label" value="{{ old('cta_label', $slide->cta_label) }}" class="mt-1.5 block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-admin-teal focus:ring-admin-teal">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-admin-dark">CTA URL</label>
                                        <input type="text" name="cta_url" value="{{ old('cta_url', $slide->cta_url) }}" class="mt-1.5 block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-admin-teal focus:ring-admin-teal">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-admin-dark">Sort order</label>
                                        <input type="number" name="sort_order" value="{{ old('sort_order', $slide->sort_order) }}" min="0" class="mt-1.5 block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-admin-teal focus:ring-admin-teal">
                                    </div>

                                    <div class="flex items-center gap-2 pt-7">
                                        <input id="is_visible_{{ $slide->id }}" type="checkbox" name="is_visible" value="1" class="rounded border-gray-300" {{ $slide->is_visible ? 'checked' : '' }}>
                                        <label for="is_visible_{{ $slide->id }}" class="text-sm text-admin-dark">Visible</label>
                                    </div>

                                    <div class="md:col-span-2 flex flex-wrap items-center gap-3 pt-2">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-admin-teal text-white text-sm font-medium hover:bg-admin-teal-dark transition-colors">
                                            Save slide
                                        </button>
                                    </div>
                                    </form>

                                    <form method="post" action="{{ route('admin-dashboard.hero.slides.destroy', $slide) }}" onsubmit="return confirm('Delete this slide?')" class="md:col-span-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg border border-red-200 bg-red-50 text-red-700 text-sm font-medium hover:bg-red-100 transition-colors">
                                            Delete slide
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-xl border border-dashed border-gray-300 p-8 text-center text-sm text-admin-muted">
                        No slides yet. Add your first slide above.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

