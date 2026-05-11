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
                    preload="auto"
                    poster="{{ $carouselFallbackImage }}"
                    class="absolute inset-0 w-full h-full object-cover min-w-full min-h-full scale-105"
                >
                    <source src="{{ $videoUrl }}" type="video/mp4">
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

    {{-- Dark overlay to ensure readability (matches reference) --}}
    <div
        aria-hidden="true"
        data-ctc-hero-overlay
        class="absolute inset-0 z-[1] bg-[linear-gradient(180deg,rgba(0,0,0,0.30),rgba(0,0,0,0.55))]"
    ></div>

    {{-- Center content --}}
    <div class="absolute inset-0 z-[2] flex items-center justify-center px-4">
        <div class="text-center [perspective:1400px]" data-ctc-hero-headline>
            <h1 id="ctc-hero-title" class="font-sans font-extrabold tracking-tight leading-[1.05] text-white drop-shadow-[0_18px_45px_rgba(0,0,0,0.50)]" style="font-size:clamp(2.2rem,5.4vw,4.25rem);">
                {{ $title }}
            </h1>
            @if($subtitle)
                <div class="mt-3 flex justify-center" data-ctc-hero-subtitle-wrap>
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-[0.7rem] font-semibold uppercase tracking-[0.22em] text-white/90 backdrop-blur-md">
                        <span class="h-2 w-2 shrink-0 rounded-full bg-[var(--color-ctc-gold)] shadow-[0_0_0_4px_rgba(228,195,115,0.20)]" aria-hidden="true"></span>
                        <span id="ctc-hero-subtitle">{{ $subtitle }}</span>
                    </span>
                </div>
            @endif
        </div>
    </div>

    {{-- Bottom layout --}}
    <div class="absolute inset-x-0 bottom-0 z-[3] pb-8 sm:pb-10">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-6 sm:gap-8 md:flex-row md:items-center md:justify-between">
                <div class="max-w-[42rem] md:max-w-[40%]">
                    @if($description)
                        <div data-ctc-hero-desc-card class="rounded-2xl border border-white/10 bg-white/8 backdrop-blur-md px-5 py-4 shadow-[0_22px_60px_rgba(0,0,0,0.30)]">
                            <p id="ctc-hero-description" class="text-white/88 font-medium leading-[1.75] text-[0.95rem] sm:text-[1rem] drop-shadow-[0_18px_45px_rgba(0,0,0,0.35)]">
                                {{ $description }}
                            </p>
                            <div class="mt-3 h-px w-16 bg-[linear-gradient(90deg,rgba(228,195,115,0.75),rgba(13,148,136,0.55),rgba(255,255,255,0))]" aria-hidden="true"></div>
                        </div>
                    @endif
                </div>

                <div id="ctc-hero-ctas" class="flex flex-wrap items-center gap-3 sm:gap-4 md:justify-end">
                    @if($primaryBtn)
                        <a href="{{ $primaryBtn['url'] ?? '#' }}"
                           data-cta="1"
                           class="inline-flex items-center justify-center rounded-2xl px-7 py-3.5 text-xs sm:text-sm font-semibold uppercase tracking-[0.18em]
                                  bg-[#156874] text-white border-2 border-[#e4c373]
                                  shadow-[0_22px_60px_rgba(0,0,0,0.35)] hover:bg-[#1a7a88] hover:border-[#e4c373] transition
                                  focus:outline-none focus-visible:ring-2 focus-visible:ring-[var(--color-ctc-gold)] focus-visible:ring-offset-2 focus-visible:ring-offset-black/40">
                            {{ $primaryBtn['label'] ?? 'Book Appointment' }}
                        </a>
                    @endif
                    @if($secondaryBtn)
                        <a href="{{ $secondaryBtn['url'] ?? '#' }}"
                           data-cta="2"
                           class="inline-flex items-center justify-center rounded-2xl px-7 py-3.5 text-xs sm:text-sm font-semibold uppercase tracking-[0.18em]
                                  bg-white/10 text-white border border-white/20 backdrop-blur-md shadow-[0_22px_60px_rgba(0,0,0,0.28)]
                                  hover:bg-white/16 hover:border-white/30 transition
                                  focus:outline-none focus-visible:ring-2 focus-visible:ring-white/70 focus-visible:ring-offset-2 focus-visible:ring-offset-black/40">
                            {{ $secondaryBtn['label'] ?? 'Refer a Patient' }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($useCarousel && $slides->count() > 0)
        <div data-ctc-hero-dots class="absolute bottom-10 left-0 right-0 z-20 flex justify-center gap-2 px-4" role="tablist" aria-label="Hero slides">
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
