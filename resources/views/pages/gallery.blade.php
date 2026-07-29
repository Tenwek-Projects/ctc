@extends('layouts.app')

@section('title', 'Gallery')

@section('content')
    @include('components.page-banner', [
        'title' => 'Gallery',
        'subtitle' => config('ctc.name'),
        'bannerKey' => 'gallery',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'News & Media', 'url' => route('news')],
            ['label' => 'Gallery', 'url' => route('gallery')],
        ],
    ])

    @php
        $galleryPayload = $groups
            ->flatMap(fn ($group) => $group['items'])
            ->map(fn ($item) => [
                'title' => $item->title,
                'caption' => $item->caption,
                'src' => $item->resolvedImageUrl(),
            ])
            ->values();

        $photoCount = $galleryPayload->count();
        $groupCount = $groups->count();
        $flatIndex = 0;
        $albumOrdinal = 0;
    @endphp

    <section
        class="ctc-gallery-page relative overflow-hidden py-16 lg:py-20"
        x-data="{
            images: {{ \Illuminate\Support\Js::from($galleryPayload) }},
            activeIndex: null,
            open(index) { this.activeIndex = index; document.body.classList.add('overflow-hidden'); },
            close() { this.activeIndex = null; document.body.classList.remove('overflow-hidden'); },
            prev() { if (this.activeIndex === null || this.images.length === 0) return; this.activeIndex = (this.activeIndex - 1 + this.images.length) % this.images.length; },
            next() { if (this.activeIndex === null || this.images.length === 0) return; this.activeIndex = (this.activeIndex + 1) % this.images.length; }
        }"
        @keydown.window.escape="if(activeIndex !== null) close()"
        @keydown.window.arrow-left.prevent="if(activeIndex !== null) prev()"
        @keydown.window.arrow-right.prevent="if(activeIndex !== null) next()"
    >
        <div class="pointer-events-none absolute inset-0 -z-10" aria-hidden="true">
            <div class="ctc-gallery-atmosphere absolute -left-24 top-10 h-72 w-72 rounded-full bg-ctc-secondary/15 blur-3xl"></div>
            <div class="ctc-gallery-atmosphere absolute -right-16 top-40 h-80 w-80 rounded-full bg-ctc-accent/20 blur-3xl"></div>
            <div class="ctc-gallery-atmosphere absolute bottom-10 left-1/3 h-64 w-64 rounded-full bg-ctc-blue/10 blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl" data-ctc-reveal="fade-up">
                <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-accent">Moments</p>
                <h2 class="mt-3 text-2xl sm:text-3xl font-headline font-extrabold tracking-tight text-ctc-blue">
                    Life at the centre
                </h2>
                <p class="mt-4 text-gray-600 leading-relaxed">
                    Stories told in photographs — grouped by moment. Click any image to zoom and scroll through the full gallery.
                </p>
                @if($photoCount > 0)
                    <div class="mt-6 flex flex-wrap gap-3" data-ctc-stagger="0.08" data-ctc-stagger-reveal="scale-in">
                        <span class="inline-flex items-center rounded-full border border-ctc-blue/15 bg-white px-4 py-2 text-xs font-bold uppercase tracking-[0.16em] text-ctc-blue shadow-sm">
                            {{ $groupCount }} {{ \Illuminate\Support\Str::plural('album', $groupCount) }}
                        </span>
                        <span class="inline-flex items-center rounded-full border border-ctc-secondary/25 bg-ctc-secondary/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.16em] text-ctc-secondary-dark">
                            {{ $photoCount }} {{ \Illuminate\Support\Str::plural('photo', $photoCount) }}
                        </span>
                    </div>
                @endif
            </div>

            @forelse($rows as $rowIndex => $row)
                @php
                    $isPairRow = $row['type'] === 'pair';
                @endphp
                <div
                    class="mt-14 lg:mt-20 {{ $isPairRow ? 'grid gap-8 sm:grid-cols-2 lg:gap-10' : '' }}"
                    data-ctc-reveal="fade-up"
                    data-ctc-reveal-delay="{{ min(0.12, $rowIndex * 0.03) }}"
                >
                    @foreach($row['groups'] as $group)
                        @php
                            $groupItems = $group['items'];
                            $count = $groupItems->count();
                            $isFeaturedLayout = $count >= 3;
                            $albumOrdinal++;
                            $isCompact = $count === 1;
                        @endphp
                        <section class="ctc-gallery-album {{ ! $isPairRow && $albumOrdinal % 2 === 0 ? 'ctc-gallery-album--alt' : '' }}">
                            <div class="mb-5 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between {{ $isCompact ? 'mb-4' : 'mb-7' }}">
                                <div class="max-w-2xl">
                                    <div class="flex items-center gap-3">
                                        <span class="inline-flex h-8 min-w-8 items-center justify-center rounded-full bg-ctc-blue px-2 text-[11px] font-extrabold text-white">
                                            {{ str_pad((string) $albumOrdinal, 2, '0', STR_PAD_LEFT) }}
                                        </span>
                                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-secondary">Album</p>
                                    </div>
                                    <h3 class="mt-3 {{ $isCompact ? 'text-lg sm:text-xl' : 'text-xl sm:text-2xl' }} font-headline font-extrabold tracking-tight text-ctc-blue">
                                        {{ $group['title'] }}
                                    </h3>
                                    @if(! $isCompact && !empty($group['caption_html']) && strip_tags($group['caption_html']) !== $group['title'])
                                        <div class="mt-2 prose prose-sm max-w-none text-gray-600 prose-p:my-1 prose-a:text-ctc-secondary">
                                            {!! $group['caption_html'] !!}
                                        </div>
                                    @endif
                                </div>
                                @unless($isCompact)
                                    <p class="text-sm font-semibold text-gray-500">
                                        {{ $count }} {{ \Illuminate\Support\Str::plural('photo', $count) }}
                                    </p>
                                @endunless
                            </div>

                            @if($isFeaturedLayout)
                                <div class="grid gap-4 lg:grid-cols-12 lg:gap-5" data-ctc-stagger="0.09" data-ctc-stagger-reveal="scale-in">
                                    @foreach($groupItems as $itemIndex => $item)
                                        @php
                                            $currentIndex = $flatIndex++;
                                            $isLead = $itemIndex === 0;
                                        @endphp
                                        <figure class="ctc-gallery-tile group relative overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm {{ $isLead ? 'lg:col-span-7 lg:row-span-2' : 'lg:col-span-5' }}">
                                            <button
                                                type="button"
                                                @click="open({{ $currentIndex }})"
                                                class="relative block w-full text-left {{ $isLead ? 'aspect-[4/3] lg:aspect-auto lg:h-full lg:min-h-[28rem]' : 'aspect-[4/3]' }}"
                                                aria-label="Open image: {{ $item->title }}"
                                            >
                                                <img
                                                    src="{{ $item->resolvedImageUrl() }}"
                                                    alt="{{ $item->title }}"
                                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.04]"
                                                    loading="lazy"
                                                >
                                                <span class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent opacity-80 transition-opacity duration-300 group-hover:opacity-95"></span>
                                                <span class="pointer-events-none absolute left-3 top-3 rounded-full bg-white/90 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-ctc-blue">
                                                    {{ $itemIndex + 1 }}/{{ $count }}
                                                </span>
                                                <span class="pointer-events-none absolute bottom-3 left-3 right-3 flex items-end justify-between gap-3">
                                                    <span class="text-sm font-semibold text-white drop-shadow">{{ preg_replace('/\s+#\d+$/u', '', $item->title) }}</span>
                                                    <span class="shrink-0 rounded-full bg-black/45 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                                        Zoom
                                                    </span>
                                                </span>
                                            </button>
                                        </figure>
                                    @endforeach
                                </div>
                            @else
                                <div class="grid gap-5 {{ $count >= 2 ? 'sm:grid-cols-2' : '' }} {{ $count >= 3 ? 'lg:grid-cols-3' : '' }}" data-ctc-stagger="0.1" data-ctc-stagger-reveal="fade-up">
                                    @foreach($groupItems as $itemIndex => $item)
                                        @php $currentIndex = $flatIndex++; @endphp
                                        <figure class="ctc-gallery-tile group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                                            <button
                                                type="button"
                                                @click="open({{ $currentIndex }})"
                                                class="relative block w-full aspect-[4/3] bg-ctc-grey-light text-left"
                                                aria-label="Open image: {{ $item->title }}"
                                            >
                                                <img
                                                    src="{{ $item->resolvedImageUrl() }}"
                                                    alt="{{ $item->title }}"
                                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.04]"
                                                    loading="lazy"
                                                >
                                                <span class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></span>
                                                <span class="pointer-events-none absolute left-3 top-3 rounded-full bg-white/90 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-ctc-blue">
                                                    {{ $itemIndex + 1 }}/{{ $count }}
                                                </span>
                                                <span class="pointer-events-none absolute right-3 top-3 rounded-full bg-black/55 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                                    Click to zoom
                                                </span>
                                            </button>
                                            @unless($isCompact)
                                                <figcaption class="p-4">
                                                    <h4 class="text-sm font-semibold text-gray-900 group-hover:text-ctc-blue transition-colors">
                                                        {{ preg_replace('/\s+#\d+$/u', '', $item->title) }}
                                                    </h4>
                                                </figcaption>
                                            @endunless
                                        </figure>
                                    @endforeach
                                </div>
                            @endif
                        </section>
                    @endforeach
                </div>
            @empty
                <div class="mt-12 rounded-3xl border-2 border-dashed border-ctc-secondary/40 bg-ctc-grey-light/50 px-6 py-16 text-center">
                    <p class="text-lg font-semibold text-gray-700">Gallery coming soon</p>
                    <p class="mt-2 text-gray-600">Check back for photos from the CTC.</p>
                </div>
            @endforelse
        </div>

        {{-- Lightbox: edge-to-edge image, minimal chrome --}}
        <div
            x-show="activeIndex !== null"
            x-cloak
            class="fixed inset-0 z-[90] flex items-center justify-center"
            x-transition.opacity
            role="dialog"
            aria-modal="true"
            aria-label="Gallery image viewer"
        >
            <button type="button" class="absolute inset-0 bg-black/90" @click="close()" aria-label="Close viewer"></button>

            <div class="relative z-[1] flex h-full w-full max-h-full max-w-full flex-col">
                <button
                    type="button"
                    @click="close()"
                    class="absolute right-2 top-2 z-[3] inline-flex h-10 w-10 items-center justify-center rounded-full bg-black/55 text-white transition hover:bg-black/75 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/80 sm:right-3 sm:top-3"
                    aria-label="Close viewer"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <button
                    type="button"
                    @click="prev()"
                    class="absolute left-2 top-1/2 z-[3] -translate-y-1/2 inline-flex h-11 w-11 items-center justify-center rounded-full bg-black/55 text-white transition hover:bg-black/75 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/80 sm:left-3"
                    aria-label="Previous image"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>

                <button
                    type="button"
                    @click="next()"
                    class="absolute right-2 top-1/2 z-[3] -translate-y-1/2 inline-flex h-11 w-11 items-center justify-center rounded-full bg-black/55 text-white transition hover:bg-black/75 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/80 sm:right-3"
                    aria-label="Next image"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>

                <div class="flex min-h-0 flex-1 items-center justify-center">
                    <img
                        :src="images[activeIndex]?.src"
                        :alt="images[activeIndex]?.title || 'Gallery image'"
                        class="max-h-[100dvh] max-w-[100vw] object-contain"
                    >
                </div>

                <div class="pointer-events-none absolute inset-x-0 bottom-0 z-[2] bg-gradient-to-t from-black/80 via-black/45 to-transparent px-4 pb-4 pt-16 sm:px-6 sm:pb-5">
                    <div class="pointer-events-auto mx-auto flex max-w-4xl items-end justify-between gap-3 text-white">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold" x-text="images[activeIndex]?.title"></p>
                            <div class="mt-0.5 line-clamp-2 text-xs text-white/80" x-html="images[activeIndex]?.caption || ''"></div>
                        </div>
                        <p class="shrink-0 text-xs font-semibold text-white/70" x-text="activeIndex !== null ? ((activeIndex + 1) + ' / ' + images.length) : ''"></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
