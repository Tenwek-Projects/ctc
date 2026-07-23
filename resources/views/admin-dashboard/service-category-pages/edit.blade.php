@extends('admin-dashboard.layouts.app')
@section('title', 'Edit: ' . $page->admin_label)
@section('header', $page->admin_label)

@section('content')
    <div class="max-w-4xl space-y-6">
        <div class="rounded-xl bg-admin-surface border border-gray-200 shadow-sm p-6">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-admin-muted">SEO &amp; content</p>
                    <h2 class="mt-2 text-xl font-semibold text-admin-dark">Edit service area page</h2>
                    <p class="mt-1 text-sm text-admin-muted">
                        Public URL:
                        <a class="text-admin-teal font-medium hover:underline" href="{{ route('services.category', ['serviceCategory' => $page->url_segment]) }}" target="_blank" rel="noopener">
                            {{ route('services.category', ['serviceCategory' => $page->url_segment]) }}
                        </a>
                    </p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin-dashboard.service-category-pages.index') }}"
                       class="px-4 py-2 rounded-lg border border-gray-300 text-admin-dark hover:bg-admin-bg text-sm font-medium">All areas</a>
                    <button type="submit" form="serviceCategoryPageForm"
                            class="px-4 py-2 rounded-lg bg-admin-teal text-white text-sm font-medium hover:bg-admin-teal-dark">
                        Save
                    </button>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-900 px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-xl bg-admin-surface border border-gray-200 shadow-sm p-6 sm:p-8">
            <form id="serviceCategoryPageForm" action="{{ route('admin-dashboard.service-category-pages.update', $page) }}" method="post" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div>
                    <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-admin-muted">Search &amp; social</p>
                    <p class="mt-1 text-sm text-admin-muted">Title and description are used for meta tags, Open Graph, and JSON-LD on this URL.</p>
                </div>

                <div class="grid gap-4">
                    <div>
                        <label class="block text-sm font-medium text-admin-dark mb-1">Meta title (optional)</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}"
                               placeholder="Defaults to intro heading + site name"
                               class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal">
                        @error('meta_title')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-admin-dark mb-1">Meta description <span class="text-admin-muted font-normal">(max 320)</span></label>
                        <textarea name="meta_description" rows="3" required maxlength="320"
                                  class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal">{{ old('meta_description', $page->meta_description) }}</textarea>
                        @error('meta_description')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-admin-muted">Page hero (banner)</p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-admin-dark mb-1">Kicker (small label)</label>
                        <input type="text" name="intro_kicker" value="{{ old('intro_kicker', $page->intro_kicker) }}"
                               class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal">
                        @error('intro_kicker')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-admin-dark mb-1">Banner heading (H1)</label>
                        <input type="text" name="intro_heading" value="{{ old('intro_heading', $page->intro_heading) }}" required
                               class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal">
                        @error('intro_heading')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-admin-dark mb-1">Banner subtitle</label>
                    <input type="text" name="intro_subheading" value="{{ old('intro_subheading', $page->intro_subheading) }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-admin-teal">
                    @error('intro_subheading')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="rounded-2xl border-2 border-admin-teal/25 bg-admin-teal/[0.04] p-6 sm:p-8 space-y-4">
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-admin-teal">Image on public page</p>
                        <h3 class="mt-2 text-lg font-semibold text-admin-dark">Main photo for this service area</h3>
                        <p class="mt-1 text-sm text-admin-muted max-w-2xl">
                            This image appears on the public category page (for example
                            <a href="{{ route('services.category', ['serviceCategory' => $page->url_segment]) }}" target="_blank" rel="noopener" class="text-admin-teal font-medium hover:underline">{{ route('services.category', ['serviceCategory' => $page->url_segment]) }}</a>)
                            above the article text. It is also used for Open Graph / social previews. Recommended aspect ratio 16:9, JPG or WebP, up to 5&nbsp;MB.
                        </p>
                    </div>
                    <div class="aspect-[16/9] max-w-2xl rounded-xl overflow-hidden border-2 border-dashed border-admin-teal/35 bg-white shadow-inner">
                        <img id="svcCatFeaturedPreview"
                             src="{{ $featured_image_url ?: (\App\Support\SiteImage::urlFor('placeholder_facility') ?: config('ctc.placeholder_images.facility')) }}"
                             alt=""
                             class="h-full w-full object-cover min-h-[200px]">
                    </div>
                    @if($page->featured_image_path)
                        <p class="text-sm text-admin-dark">
                            <span class="font-medium">Saved file:</span>
                            <code class="text-xs bg-white border border-gray-200 rounded px-2 py-0.5 ml-1">{{ basename($page->featured_image_path) }}</code>
                        </p>
                    @endif
                    <div class="flex flex-wrap items-center gap-3">
                        <label class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-admin-teal text-white font-semibold hover:bg-admin-teal-dark shadow-sm cursor-pointer transition-colors text-sm">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12V4m0 8l-3-3m3 3l3-3"/>
                            </svg>
                            Upload image
                            <input type="file" name="featured_image" accept="image/*" class="sr-only"
                                   data-preview-target="svcCatFeaturedPreview"
                                   data-filename-target="svcCatFeaturedFilename">
                        </label>
                        <span id="svcCatFeaturedFilename" class="text-sm text-admin-muted truncate max-w-[14rem] sm:max-w-md" title="">
                            @if($page->featured_image_path)
                                Replace by choosing a new file
                            @else
                                No image uploaded yet
                            @endif
                        </span>
                    </div>
                    @if($page->featured_image_path)
                        <label class="inline-flex items-center gap-2 text-sm text-admin-dark cursor-pointer select-none">
                            <input type="checkbox" name="remove_featured_image" value="1" class="rounded border-gray-300 text-admin-teal focus:ring-admin-teal">
                            <span>Remove saved image (page will use placeholder until you upload again)</span>
                        </label>
                    @endif
                    @error('featured_image')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-admin-dark mb-1">Main article (rich text)</label>
                    <p class="text-xs text-admin-muted mb-2">Headings, lists, bold, and links to trusted sites (e.g. tenwekhosp.org) are allowed.</p>
                    <input id="svcCatBodyHtml" type="hidden" name="body_html" value="{{ old('body_html', $page->body_html) }}">
                    <trix-editor input="svcCatBodyHtml" class="w-full bg-white min-h-[22rem]"></trix-editor>
                    @error('body_html')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex gap-3 pt-2">
                    <a href="{{ route('admin-dashboard.service-category-pages.index') }}"
                       class="px-4 py-2 rounded-lg border border-gray-300 text-admin-dark hover:bg-admin-bg">Cancel</a>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-admin-teal text-white font-medium hover:bg-admin-teal-dark">
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
            };
            inputs.forEach((input) => {
                input.addEventListener('change', () => { setPreview(input); setFilename(input); }, { passive: true });
            });
            window.addEventListener('beforeunload', () => { for (const url of urlByInput.values()) URL.revokeObjectURL(url); });
        })();
    </script>
@endsection
