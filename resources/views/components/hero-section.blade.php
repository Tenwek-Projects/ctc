@props([
    'title',
    'subtitle' => null,
    'description' => null,
    'buttons' => [],
    'mode' => 'video', // 'video' | 'carousel' | 'image'
    'video' => null,
    'image' => null,
    'slides' => [],
    'scrollIndicatorTarget' => '#home-stats',
])

@php
    $mode = in_array($mode, ['video', 'carousel', 'image'], true) ? $mode : 'video';
    $slides = $slides instanceof \Illuminate\Support\Collection ? $slides : collect($slides);
    $useCarousel = $mode === 'carousel';
    $useImage = $mode === 'image';
    $carouselFallbackImage = config('ctc.page_banner_image');

    $heroImageSource = $image ?? config('ctc.hero_image');
    $heroImageUrl = $heroImageSource
        ? (str_starts_with((string) $heroImageSource, 'http') ? $heroImageSource : asset($heroImageSource))
        : null;

    $videoSource = $video ?? config('ctc.hero_video');
    $isYoutube = $videoSource && (str_contains($videoSource, 'youtube.com/watch') || str_contains($videoSource, 'youtu.be/'));
    $youtubeId = null;
    if ($isYoutube && preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $videoSource, $m)) {
        $youtubeId = $m[1];
    }
    $videoUrl = null;
    if (!$isYoutube && $videoSource) {
        $videoUrl = str_starts_with($videoSource, 'http') ? $videoSource : asset($videoSource);
    }
    $isHeroHls = $videoUrl && (bool) preg_match('/\.m3u8(\?|#|$)/i', $videoUrl);

    $slidesPayload = $slides->values()->map(function ($slide) {
        return [
            'title' => $slide->title,
            'subtitle' => $slide->subtitle,
            'cta_label' => $slide->cta_label,
            'cta_url' => $slide->cta_url,
        ];
    })->values();

    $primaryBtn = collect($buttons)->firstWhere('primary', true) ?? ($buttons[0] ?? null);
    $secondaryBtn = collect($buttons)->first(fn ($b) => !($b['primary'] ?? false)) ?? ($buttons[1] ?? null);
    $carouselDots = $useCarousel && $slides->count() > 0;

    $titleWords = preg_split('/\s+/', trim((string) ($title ?? '')), -1, PREG_SPLIT_NO_EMPTY);
@endphp

<section
    class="relative bg-ctc-blue text-white overflow-hidden min-h-[90svh] sm:min-h-[100svh]"
    data-ctc-hero
    aria-busy="true"
>
    <div
        class="absolute inset-0 z-[30] flex flex-col items-center justify-center gap-4 bg-ctc-blue transition-opacity duration-500 ease-out"
        data-ctc-hero-preloader
        aria-live="polite"
        aria-label="Loading hero"
    >
        <span class="sr-only">Loading hero media</span>
        <span
            class="h-12 w-12 rounded-full border-2 border-white/20 border-t-ctc-ruby animate-spin motion-reduce:animate-none"
            aria-hidden="true"
        ></span>
    </div>
    <noscript>
        <style>[data-ctc-hero-preloader]{display:none!important}</style>
    </noscript>

    @if($useCarousel)
        <div class="absolute inset-0 w-full h-full overflow-hidden" data-ctc-hero-media aria-hidden="true">
            @if($slides->count() > 0)
                @foreach($slides->values() as $index => $slide)
                    <div
                        class="ctc-hero-slide absolute inset-0 bg-cover bg-center {{ $index === 0 ? 'opacity-100 z-[1]' : 'opacity-0 z-0' }}"
                        style="background-image:url('{{ $slide->image_url ?? '' }}')"
                        data-slide-index="{{ $index }}"
                        @if($index === 0 && ($slide->image_url ?? '')) data-hero-preload="{{ $slide->image_url }}" @endif
                    ></div>
                @endforeach
            @else
                <div
                    class="absolute inset-0 bg-cover bg-center scale-105"
                    style="background-image:url('{{ $carouselFallbackImage }}')"
                    data-hero-preload="{{ $carouselFallbackImage }}"
                ></div>
            @endif
        </div>
    @elseif($useImage && $heroImageUrl)
        <div class="absolute inset-0 w-full h-full overflow-hidden" data-ctc-hero-media aria-hidden="true">
            <div
                class="absolute inset-0 bg-cover bg-center scale-105"
                style="background-image:url('{{ $heroImageUrl }}')"
                data-hero-preload="{{ $heroImageUrl }}"
            ></div>
        </div>
    @else
        <div class="absolute inset-0 w-full h-full overflow-hidden" data-ctc-hero-media aria-hidden="true">
            @if($youtubeId)
                <iframe
                    src="https://www.youtube.com/embed/{{ $youtubeId }}?autoplay=1&mute=1&loop=1&playlist={{ $youtubeId }}&controls=0&rel=0&showinfo=0&playsinline=1&modestbranding=1&disablekb=1&fs=0&iv_load_policy=3"
                    title=""
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    class="absolute left-1/2 top-1/2 min-w-[177.78vh] min-h-[100vh] w-[100vw] h-[56.25vw] -translate-x-1/2 -translate-y-1/2 pointer-events-none object-cover"
                    style="width: 100vw; height: 56.25vw; min-width: 177.78vh; min-height: 100vh;"
                ></iframe>
            @elseif($videoUrl)
                <video
                    autoplay
                    muted
                    loop
                    playsinline
                    preload="metadata"
                    poster="{{ $heroImageUrl ?? $carouselFallbackImage }}"
                    class="absolute inset-0 w-full h-full object-cover min-w-full min-h-full scale-105"
                    @if($isHeroHls) data-ctc-hero-hls="{{ $videoUrl }}" @endif
                >
                    @unless($isHeroHls)
                        <source src="{{ $videoUrl }}" type="video/mp4">
                    @endunless
                </video>
            @else
                <div
                    class="absolute inset-0 bg-cover bg-center scale-105"
                    style="background-image:url('{{ $carouselFallbackImage }}')"
                    data-hero-preload="{{ $carouselFallbackImage }}"
                ></div>
            @endif
        </div>
    @endif

    {{-- Readability overlay --}}
    <div
        aria-hidden="true"
        data-ctc-hero-overlay
        class="absolute inset-0 z-[1] bg-[linear-gradient(180deg,rgba(0,0,0,0.42),rgba(0,0,0,0.38),rgba(0,0,0,0.58))]"
    ></div>

    {{-- Center: flagship, title, badge --}}
    <div class="absolute inset-0 z-[3] flex items-center justify-center px-4 pb-24 sm:pb-28">
        <div class="text-center [perspective:1400px]" data-ctc-hero-headline>
            <div class="mb-3 flex justify-center sm:mb-4" data-ctc-hero-emblem aria-hidden="true">
                <img
                    src="{{ \App\Support\SiteImage::urlFor('logo') ?: asset('logo-ctc.png') }}"
                    alt=""
                    width="320"
                    height="120"
                    decoding="async"
                    class="h-auto w-[min(92vw,14rem)] max-h-24 object-contain object-center drop-shadow-[0_12px_36px_rgba(0,0,0,0.45)] sm:w-[min(88vw,16rem)] sm:max-h-28 md:w-[min(72vw,18rem)] md:max-h-32"
                />
            </div>
            <h1 id="ctc-hero-title" class="font-sans font-extrabold tracking-tight leading-[1.05] text-white drop-shadow-[0_18px_45px_rgba(0,0,0,0.50)]" style="font-size:clamp(2.2rem,5.4vw,4.25rem);">
                @foreach ($titleWords as $word)
                    <span class="block" data-ctc-hero-title-word>{{ $word }}</span>
                @endforeach
            </h1>
            @if($subtitle)
                <div class="mt-4 flex justify-center sm:mt-5" data-ctc-hero-subtitle-wrap>
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-black/45 px-5 py-2.5 text-[0.65rem] font-semibold uppercase tracking-[0.26em] text-white shadow-[0_12px_40px_rgba(0,0,0,0.35)] backdrop-blur-sm sm:text-[0.7rem]">
                        <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-[#9ec4f8] shadow-[0_0_0_3px_rgba(158, 196, 248,0.25)]" aria-hidden="true"></span>
                        <span id="ctc-hero-subtitle">{{ $subtitle }}</span>
                    </span>
                </div>
            @endif
        </div>
    </div>

    {{-- Bottom: description left, CTAs + accent right --}}
    <div class="absolute inset-x-0 bottom-0 z-[3] pb-8 sm:pb-10 {{ $carouselDots ? 'pb-20 sm:pb-24' : '' }}">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-6 sm:gap-8 md:flex-row md:items-end md:justify-between">
                <div class="hidden max-w-[42rem] md:block md:max-w-[44%]">
                    @if($description)
                        <div data-ctc-hero-desc-card class="rounded-xl px-1 py-1 sm:px-0">
                            <p id="ctc-hero-description" class="whitespace-nowrap text-[1.08rem] font-medium leading-[1.35] text-white/95 drop-shadow-[0_14px_40px_rgba(0,0,0,0.45)] sm:text-[1.2rem] sm:leading-[1.32]">
                                {{ $description }}
                            </p>
                        </div>
                    @endif
                </div>

                <div class="flex w-full flex-wrap items-center justify-start gap-1.5 sm:gap-2 md:gap-3 md:justify-end">
                    <div id="ctc-hero-ctas" class="flex min-w-0 w-full flex-1 flex-row items-stretch justify-center gap-1.5 sm:w-auto sm:flex-initial sm:gap-2 md:gap-3">
                        @if($primaryBtn)
                            <a href="{{ $primaryBtn['url'] ?? '#' }}"
                               data-cta="1"
                               class="ctc-hero-cta-book relative inline-flex min-h-[2rem] min-w-0 flex-1 basis-0 items-center justify-center rounded-md bg-transparent px-1 py-1 text-[0.52rem] font-semibold uppercase leading-tight tracking-[0.07em] text-[#fecaca] shadow-none transition-[outline,outline-offset] duration-200 sm:min-h-[2.375rem] sm:flex-none sm:basis-auto sm:rounded-lg sm:px-3.5 sm:py-2 sm:text-[0.625rem] sm:tracking-[0.14em] md:px-4 md:text-[0.6875rem]
                                      focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b33127] focus-visible:ring-offset-2 focus-visible:ring-offset-transparent">
                                <span class="relative z-[1] inline-flex min-w-0 items-center justify-center gap-0.5 sm:gap-1">
                                    <x-icon-calendar class="h-2.5 w-2.5 shrink-0 sm:h-3 sm:w-3" />
                                    <span>{{ $primaryBtn['label'] ?? 'Book appointment' }}</span>
                                </span>
                            </a>
                        @endif
                        @if($secondaryBtn)
                            <a href="{{ $secondaryBtn['url'] ?? '#' }}"
                               data-cta="2"
                               class="inline-flex min-h-[2rem] min-w-0 flex-1 basis-0 items-center justify-center rounded-md border-2 border-[#9ec4f8] bg-transparent px-1 py-1 text-[0.52rem] font-semibold uppercase leading-tight tracking-[0.07em] text-[#9ec4f8] shadow-none transition hover:bg-[#9ec4f8]/15 hover:border-[#c5ddfb] sm:min-h-[2.375rem] sm:flex-none sm:basis-auto sm:rounded-lg sm:px-3.5 sm:py-2 sm:text-[0.625rem] sm:tracking-[0.14em] md:px-4 md:text-[0.6875rem]
                                      focus:outline-none focus-visible:ring-2 focus-visible:ring-[#9ec4f8] focus-visible:ring-offset-2 focus-visible:ring-offset-transparent">
                                {{ $secondaryBtn['label'] ?? 'Refer a Patient' }}
                            </a>
                        @endif
                    </div>
                    <span class="hidden text-[#9ec4f8] drop-shadow-sm sm:inline-flex" aria-hidden="true">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l1.8 5.5h5.8l-4.7 3.4 1.8 5.5L12 13l-4.7 3.4 1.8-5.5L4.8 7.5h5.8L12 2z" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>

        {{-- Mobile: in-flow below CTAs (avoids overlap). md+: centered over bottom band like before. --}}
        <div
            class="pointer-events-none z-[21] mt-5 flex w-full justify-center px-4 sm:mt-6 md:absolute md:bottom-0 md:left-0 md:right-0 md:mt-0 md:justify-center {{ $carouselDots ? 'md:pb-[4.25rem] lg:pb-[4.75rem]' : 'md:pb-8 lg:pb-10' }}"
        >
            <button
                type="button"
                data-ctc-hero-scroll-indicator
                data-ctc-hero-scroll-to="{{ $scrollIndicatorTarget }}"
                class="pointer-events-auto flex flex-col items-center gap-2 border-0 bg-transparent p-1 text-white shadow-none backdrop-blur-none transition hover:opacity-90 focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--color-ctc-gold)] focus-visible:ring-offset-2 focus-visible:ring-offset-transparent motion-reduce:transition-none"
                aria-label="Scroll down to next section"
            >
                <span class="relative text-white drop-shadow-[0_2px_12px_rgba(0,0,0,0.45)]" aria-hidden="true">
                    <svg class="h-11 w-7 sm:h-12 sm:w-[1.85rem]" viewBox="0 0 32 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect
                            x="5"
                            y="3"
                            width="22"
                            height="36"
                            rx="11"
                            ry="11"
                            stroke="currentColor"
                            stroke-width="2"
                        />
                        <circle
                            class="ctc-hero-scroll-indicator__chev"
                            cx="16"
                            cy="14"
                            r="2.75"
                            fill="currentColor"
                            fill-opacity="0.9"
                        />
                    </svg>
                </span>
                <span class="text-[9px] font-semibold uppercase tracking-[0.28em] text-white/95 drop-shadow-[0_2px_10px_rgba(0,0,0,0.4)] sm:text-[10px] sm:tracking-[0.32em]">Scroll down</span>
            </button>
        </div>
    </div>

    @if($carouselDots)
        <div data-ctc-hero-dots class="absolute bottom-6 left-0 right-0 z-20 flex justify-center gap-2 px-4 sm:bottom-8" role="tablist" aria-label="Hero slides">
            @foreach($slides->values() as $index => $slide)
                <button
                    type="button"
                    data-ctc-hero-dot
                    class="ctc-hero-dot h-2.5 w-2.5 rounded-full border border-white/40 bg-white/25 transition-all duration-300 hover:bg-white/50 focus:outline-none focus-visible:ring-2 focus-visible:ring-ctc-accent {{ $index === 0 ? 'ctc-hero-dot--active w-8 bg-white/90 border-white/70' : '' }}"
                    aria-label="Show slide {{ $index + 1 }}"
                    aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                ></button>
            @endforeach
        </div>
        <script type="application/json" id="ctc-hero-carousel-data">{!! json_encode($slidesPayload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    @endif
</section>
