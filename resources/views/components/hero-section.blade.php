@props([
    'title',
    'subtitle' => null,
    'description' => null,
    'buttons' => [],
    'mode' => 'video', // 'video' | 'carousel'
    'video' => null,
    'slides' => [],
    'scrollIndicatorTarget' => '#home-stats',
])

@php
    $mode = in_array($mode, ['video', 'carousel'], true) ? $mode : 'video';
    $slides = $slides instanceof \Illuminate\Support\Collection ? $slides : collect($slides);
    $useCarousel = $mode === 'carousel';
    $carouselFallbackImage = config('ctc.page_banner_image');

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
            class="h-12 w-12 rounded-full border-2 border-white/20 border-t-[#e4c373] animate-spin motion-reduce:animate-none"
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
                    poster="{{ $carouselFallbackImage }}"
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

    {{-- Upper-right: faint Africa + network lines from hub (Kenya / Bomet region) --}}
    <div
        class="pointer-events-none absolute right-[-2%] top-[5%] z-[3] w-[min(78vw,300px)] sm:right-[1%] sm:top-[7%] sm:w-[min(72vw,340px)] md:w-[min(56vw,380px)]"
        data-ctc-hero-arcs
        aria-hidden="true"
    >
        <svg viewBox="0 0 320 340" class="h-auto w-full overflow-visible" fill="none" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="ctc-hero-map-line-a" x1="0%" y1="100%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#62a3a1" stop-opacity="0.85" />
                    <stop offset="100%" stop-color="#62a3a1" stop-opacity="0.15" />
                </linearGradient>
                <linearGradient id="ctc-hero-map-line-b" x1="0%" y1="100%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#e4c373" stop-opacity="0.9" />
                    <stop offset="100%" stop-color="#e4c373" stop-opacity="0.2" />
                </linearGradient>
                <filter id="ctc-hero-map-glow" x="-35%" y="-35%" width="170%" height="170%">
                    <feGaussianBlur stdDeviation="2.2" result="blur" />
                    <feMerge>
                        <feMergeNode in="blur" />
                        <feMergeNode in="SourceGraphic" />
                    </feMerge>
                </filter>
            </defs>
            {{-- Stylized faint continent outline (stroke only) --}}
            <g opacity="0.38" stroke="rgba(255,255,255,0.55)" stroke-width="0.55" stroke-dasharray="1.8 3.2" stroke-linecap="round">
                <path
                    d="M118 42 L142 38 L168 48 L192 68 L210 96 L218 128 L214 162 L198 198 L172 232 L142 258 L108 268 L78 258 L54 232 L40 198 L36 162 L44 128 L62 96 L86 68 Z"
                />
                <path d="M232 198 L248 196 L254 214 L248 236 L232 242 L222 228 L224 208 Z" />
            </g>
            {{-- Hub (bright focal point) --}}
            <circle cx="198" cy="158" r="5" fill="#62a3a1" fill-opacity="0.55" filter="url(#ctc-hero-map-glow)" />
            <circle cx="198" cy="158" r="2.8" fill="#e4c373" fill-opacity="0.9" />
            {{-- Emanating curves + end nodes --}}
            <g filter="url(#ctc-hero-map-glow)" stroke-linecap="round" fill="none">
                <path d="M198 158 C165 118 98 92 48 78" stroke="url(#ctc-hero-map-line-a)" stroke-width="1.15" />
                <circle cx="48" cy="78" r="3.5" fill="#62a3a1" fill-opacity="0.5" stroke="none" />
                <path d="M198 158 C175 98 155 58 162 28" stroke="url(#ctc-hero-map-line-b)" stroke-width="1" />
                <circle cx="162" cy="28" r="3" fill="#e4c373" fill-opacity="0.55" stroke="none" />
                <path d="M198 158 C228 105 268 72 298 88" stroke="url(#ctc-hero-map-line-a)" stroke-width="1" />
                <circle cx="298" cy="88" r="3.2" fill="#62a3a1" fill-opacity="0.45" stroke="none" />
                <path d="M198 158 C235 145 275 155 292 188" stroke="url(#ctc-hero-map-line-b)" stroke-width="0.95" />
                <circle cx="292" cy="188" r="2.8" fill="#e4c373" fill-opacity="0.5" stroke="none" />
                <path d="M198 158 C210 195 205 242 188 278" stroke="url(#ctc-hero-map-line-a)" stroke-width="0.9" />
                <circle cx="188" cy="278" r="3" fill="#62a3a1" fill-opacity="0.45" stroke="none" />
                <path d="M198 158 C155 175 95 188 42 205" stroke="url(#ctc-hero-map-line-b)" stroke-width="0.95" />
                <circle cx="42" cy="205" r="3" fill="#e4c373" fill-opacity="0.45" stroke="none" />
                <path d="M198 158 C168 198 128 228 88 248" stroke="url(#ctc-hero-map-line-a)" stroke-width="0.85" />
                <circle cx="88" cy="248" r="2.6" fill="#62a3a1" fill-opacity="0.4" stroke="none" />
            </g>
        </svg>
    </div>

    {{-- Center: emblem, title, badge --}}
    <div class="absolute inset-0 z-[3] flex items-center justify-center px-4 pb-24 sm:pb-28">
        <div class="text-center [perspective:1400px]" data-ctc-hero-headline>
            <div class="mb-4 flex justify-center sm:mb-5" data-ctc-hero-emblem aria-hidden="true">
                {{-- Stylized human heart: great vessels, atria, ventricles, anterior interventricular groove --}}
                <svg
                    class="h-[3.25rem] w-[2.85rem] drop-shadow-[0_6px_20px_rgba(228,195,115,0.35)] sm:h-[4rem] sm:w-[3.5rem]"
                    viewBox="0 0 72 92"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <g stroke="#e4c373" stroke-width="1.05" stroke-linecap="round" stroke-linejoin="round">
                        <!-- Aortic arch & ascending aorta -->
                        <path d="M36 30V22c0-3 2.2-5.6 5-6.2a6 6 0 0 1 6.2 2.2l2.4 3.2" />
                        <path d="M41.5 16.5c2.8-4.2 7.8-6.2 12.2-4.8 3.6 1 6.4 4.4 6.8 8.2" />
                        <!-- Pulmonary trunk & branches -->
                        <path d="M32.5 29.5 28 18.5c-0.8-2.2 0.6-4.6 2.8-5.2h1.2" />
                        <path d="M27 20.5c-3-1.2-6.2 0.2-8 2.8" />
                        <!-- Venous return (SVC region) -->
                        <path d="M46.5 30.5 50.5 22" />
                        <path d="M49 26.5l4.2-5.8" />
                        <!-- Right atrium / auricle -->
                        <path d="M30.5 32.5c-9 1.2-16.2 7.8-18.8 16.8-1.8 6.6-0.4 13.8 3.6 19.8" />
                        <!-- Left ventricle (bulk, anterior view) -->
                        <path d="M41 33.5c10.2 2.4 17.8 11 19.6 21 2 10.6-2.8 21.8-12.2 29.8" />
                        <!-- Apex -->
                        <path d="M16.2 68.5c5.4 9.6 14.8 17.2 19.8 20.5 5-3.3 14.4-10.9 19.8-20.5" />
                        <!-- Anterior interventricular groove -->
                        <path d="M38.5 36.5c-1.2 6.6-2.2 13.6-2.8 20.8-0.4 5.6-0.2 11.2 0.6 16.8" />
                        <!-- Right ventricle surface detail -->
                        <path d="M22.5 44c2.2 5.6 5.6 10.8 9.8 15.2" opacity="0.85" />
                        <!-- Left ventricle surface detail -->
                        <path d="M52.5 48c-1.8 6-5.2 11.6-9.6 16.2" opacity="0.85" />
                        <!-- Coronary sulcus -->
                        <path d="M24 38.5c6-2.8 13.2-3.8 20-2.8 12 1 23.2 4.2 32.8 9.2" opacity="0.75" />
                    </g>
                </svg>
            </div>
            <h1 id="ctc-hero-title" class="font-sans font-extrabold tracking-tight leading-[1.05] text-white drop-shadow-[0_18px_45px_rgba(0,0,0,0.50)]" style="font-size:clamp(2.2rem,5.4vw,4.25rem);">
                @foreach ($titleWords as $word)
                    <span class="block" data-ctc-hero-title-word>{{ $word }}</span>
                @endforeach
            </h1>
            @if($subtitle)
                <div class="mt-4 flex justify-center sm:mt-5" data-ctc-hero-subtitle-wrap>
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-black/45 px-5 py-2.5 text-[0.65rem] font-semibold uppercase tracking-[0.26em] text-white shadow-[0_12px_40px_rgba(0,0,0,0.35)] backdrop-blur-sm sm:text-[0.7rem]">
                        <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-[#e4c373] shadow-[0_0_0_3px_rgba(228,195,115,0.25)]" aria-hidden="true"></span>
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
                            <p id="ctc-hero-description" class="text-[0.95rem] font-medium leading-[1.75] text-white/95 drop-shadow-[0_14px_40px_rgba(0,0,0,0.45)] sm:text-[1rem]">
                                {{ $description }}
                            </p>
                        </div>
                    @endif
                </div>

                <div class="flex w-full flex-wrap items-center justify-start gap-2 sm:gap-3 md:gap-4 md:justify-end">
                    <div id="ctc-hero-ctas" class="flex min-w-0 w-full flex-1 flex-row items-stretch justify-center gap-2 sm:w-auto sm:flex-initial sm:gap-3 md:gap-4">
                        @if($primaryBtn)
                            <a href="{{ $primaryBtn['url'] ?? '#' }}"
                               data-cta="1"
                               class="inline-flex min-h-[2.5rem] min-w-0 flex-1 basis-0 items-center justify-center rounded-lg border border-white/90 bg-black/35 px-2 py-2 text-[0.62rem] font-semibold uppercase leading-tight tracking-[0.08em] text-white shadow-[0_18px_50px_rgba(0,0,0,0.35)] backdrop-blur-md transition hover:bg-black/45 hover:border-white sm:min-h-[3rem] sm:flex-none sm:basis-auto sm:rounded-xl sm:px-6 sm:py-3.5 sm:text-xs sm:tracking-[0.18em] md:px-7 md:text-sm
                                      focus:outline-none focus-visible:ring-2 focus-visible:ring-white/80 focus-visible:ring-offset-2 focus-visible:ring-offset-black/50">
                                {{ $primaryBtn['label'] ?? 'Book appointment' }}
                            </a>
                        @endif
                        @if($secondaryBtn)
                            <a href="{{ $secondaryBtn['url'] ?? '#' }}"
                               data-cta="2"
                               class="inline-flex min-h-[2.5rem] min-w-0 flex-1 basis-0 items-center justify-center rounded-lg border border-[#e4c373]/90 bg-[#e4c373] px-2 py-2 text-[0.62rem] font-semibold uppercase leading-tight tracking-[0.08em] text-ctc-blue shadow-[0_18px_50px_rgba(0,0,0,0.28)] transition hover:bg-[#ebd088] hover:border-[#ebd088] sm:min-h-[3rem] sm:flex-none sm:basis-auto sm:rounded-xl sm:px-6 sm:py-3.5 sm:text-xs sm:tracking-[0.18em] md:px-7 md:text-sm
                                      focus:outline-none focus-visible:ring-2 focus-visible:ring-[#e4c373] focus-visible:ring-offset-2 focus-visible:ring-offset-black/40">
                                {{ $secondaryBtn['label'] ?? 'Refer a Patient' }}
                            </a>
                        @endif
                    </div>
                    <span class="hidden text-[#e4c373] drop-shadow-sm sm:inline-flex" aria-hidden="true">
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
