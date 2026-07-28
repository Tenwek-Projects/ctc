@extends('layouts.app')

@section('title', 'Gallery')

@section('content')
    @include('components.page-banner', [
        'title' => 'Gallery',
        'subtitle' => config('ctc.name'),
        'bannerKey' => 'gallery',
    ])

    @php
        $galleryPayload = $items->map(fn ($item) => [
            'title' => $item->title,
            'caption' => $item->caption,
            'src' => $item->resolvedImageUrl(),
        ])->values();
    @endphp

    <section class="py-16 lg:py-20" x-data="{
        images: {{ \Illuminate\Support\Js::from($galleryPayload) }},
        activeIndex: null,
        open(index) { this.activeIndex = index; document.body.classList.add('overflow-hidden'); },
        close() { this.activeIndex = null; document.body.classList.remove('overflow-hidden'); },
        prev() { if (this.activeIndex === null || this.images.length === 0) return; this.activeIndex = (this.activeIndex - 1 + this.images.length) % this.images.length; },
        next() { if (this.activeIndex === null || this.images.length === 0) return; this.activeIndex = (this.activeIndex + 1) % this.images.length; }
    }"
    @keydown.window.escape="if(activeIndex !== null) close()"
    @keydown.window.arrow-left.prevent="if(activeIndex !== null) prev()"
    @keydown.window.arrow-right.prevent="if(activeIndex !== null) next()">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-accent">Moments</p>
                <h2 class="mt-3 text-2xl sm:text-3xl font-headline font-extrabold tracking-tight text-ctc-blue">
                    Life at the centre
                </h2>
                <p class="mt-4 text-gray-600 leading-relaxed">
                    A visual look at care, teamwork, and the place we serve from. Click any image to zoom and browse.
                </p>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($items as $item)
                    <figure class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                        <button
                            type="button"
                            @click="open({{ $loop->index }})"
                            class="relative block w-full aspect-[4/3] bg-ctc-grey-light text-left"
                            aria-label="Open image: {{ $item->title }}"
                        >
                            <img
                                src="{{ $item->resolvedImageUrl() }}"
                                alt="{{ $item->title }}"
                                class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.02]"
                                loading="lazy"
                            >
                            <span class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/35 via-black/0 to-black/0 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></span>
                            <span class="pointer-events-none absolute right-3 top-3 rounded-full bg-black/55 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                Click to zoom
                            </span>
                        </button>
                        <figcaption class="p-5">
                            <h3 class="text-base font-semibold text-gray-900 group-hover:text-ctc-blue transition-colors">{{ $item->title }}</h3>
                            @if($item->caption)
                                <div class="mt-2 prose prose-sm max-w-none text-gray-600 prose-p:my-1 prose-a:text-ctc-secondary">
                                    {!! $item->caption !!}
                                </div>
                            @endif
                        </figcaption>
                    </figure>
                @empty
                    <div class="col-span-full rounded-3xl border-2 border-dashed border-ctc-secondary/40 bg-ctc-grey-light/50 px-6 py-16 text-center">
                        <p class="text-lg font-semibold text-gray-700">Gallery coming soon</p>
                        <p class="mt-2 text-gray-600">Check back for photos from the CTC.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Lightbox --}}
        <div
            x-show="activeIndex !== null"
            x-cloak
            class="fixed inset-0 z-[90] flex items-center justify-center p-3 sm:p-6"
            x-transition.opacity
            role="dialog"
            aria-modal="true"
            aria-label="Gallery image viewer"
        >
            <button type="button" class="absolute inset-0 bg-black/80 backdrop-blur-sm" @click="close()" aria-label="Close viewer"></button>

            <div class="relative z-[1] w-full max-w-6xl">
                <div class="relative overflow-hidden rounded-2xl border border-white/15 bg-black/35 shadow-[0_35px_90px_rgba(0,0,0,0.5)]">
                    <button
                        type="button"
                        @click="prev()"
                        class="absolute left-3 top-1/2 -translate-y-1/2 z-[2] inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/25 bg-white/12 text-white backdrop-blur-sm transition hover:bg-white/22 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/80"
                        aria-label="Previous image"
                    >
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </button>

                    <button
                        type="button"
                        @click="next()"
                        class="absolute right-3 top-1/2 -translate-y-1/2 z-[2] inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/25 bg-white/12 text-white backdrop-blur-sm transition hover:bg-white/22 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/80"
                        aria-label="Next image"
                    >
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>

                    <button
                        type="button"
                        @click="close()"
                        class="absolute right-3 top-3 z-[2] inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/25 bg-black/30 text-white transition hover:bg-black/50 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/80"
                        aria-label="Close viewer"
                    >
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>

                    <div class="relative aspect-[16/10] sm:aspect-[16/9] bg-black">
                        <img
                            :src="images[activeIndex]?.src"
                            :alt="images[activeIndex]?.title || 'Gallery image'"
                            class="h-full w-full object-contain"
                        >
                    </div>
                </div>

                <div class="mt-3 rounded-xl bg-black/60 px-4 py-3 text-white/95">
                    <p class="text-sm font-semibold" x-text="images[activeIndex]?.title"></p>
                    <div class="mt-1 text-xs text-white/80" x-html="images[activeIndex]?.caption || ''"></div>
                </div>
            </div>
        </div>
    </section>
@endsection
