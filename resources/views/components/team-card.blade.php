@props([
    'name',
    'title',
    'credentials' => null,
    'groupLabel' => null,
    'specialization' => null,
    'bio' => null,
    'photo' => null,
    'url' => null,
    'priority' => false,
])

@php
    $bioPlain = $bio ? \Illuminate\Support\Str::limit(trim(strip_tags($bio)), 220) : null;
    $photoUrl = \App\Support\PublicAssetUrl::toUrl($photo);
    $showSpecialization = filled($specialization)
        && strcasecmp(trim((string) $specialization), trim((string) $title)) !== 0;
    $priority = (bool) $priority;
@endphp

<article
    class="ctc-card-tilt group rounded-2xl bg-white border border-gray-200 overflow-hidden shadow-sm hover:shadow-xl transition-[box-shadow] duration-500"
    @if($photoUrl) x-data="{ photoOpen: false }" @endif
>
    <div class="aspect-[4/3] bg-ctc-grey-light flex items-center justify-center relative overflow-hidden">
        @if($photoUrl)
            <button
                type="button"
                class="relative block h-full w-full cursor-zoom-in focus:outline-none focus-visible:ring-2 focus-visible:ring-ctc-blue focus-visible:ring-inset"
                @click="photoOpen = true"
                aria-label="View full photo of {{ $name }}"
            >
                <img
                    src="{{ $photoUrl }}"
                    alt="{{ $name }}"
                    width="800"
                    height="600"
                    class="h-full w-full object-cover object-top grayscale-[0.35] transition-[filter,transform] duration-700 ease-out origin-top group-hover:scale-[1.03] group-hover:grayscale-0"
                    @if($priority)
                        loading="eager"
                        fetchpriority="high"
                        decoding="async"
                    @else
                        loading="lazy"
                        decoding="async"
                        fetchpriority="low"
                    @endif
                >
                <span class="pointer-events-none absolute bottom-3 right-3 inline-flex items-center gap-1.5 rounded-lg bg-black/55 px-2.5 py-1.5 text-[10px] font-semibold uppercase tracking-[0.16em] text-white opacity-0 transition group-hover:opacity-100">
                    View full
                </span>
            </button>

            <div
                x-show="photoOpen"
                x-cloak
                x-transition.opacity
                class="fixed inset-0 z-[80] flex items-center justify-center bg-black/80 p-4 sm:p-8"
                role="dialog"
                aria-modal="true"
                aria-label="Full photo of {{ $name }}"
                @keydown.escape.window="photoOpen = false"
                @click.self="photoOpen = false"
            >
                <button
                    type="button"
                    class="absolute right-4 top-4 inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/15 text-white hover:bg-white/25 focus:outline-none focus-visible:ring-2 focus-visible:ring-white"
                    @click="photoOpen = false"
                    aria-label="Close full photo"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <img
                    x-show="photoOpen"
                    x-bind:src="photoOpen ? '{{ $photoUrl }}' : ''"
                    alt="{{ $name }}"
                    class="max-h-[90vh] max-w-full object-contain shadow-2xl"
                    loading="lazy"
                    decoding="async"
                    @click.stop
                >
            </div>
        @else
            <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none" aria-hidden="true"></div>
    </div>

    @if($url)
        <a href="{{ $url }}" class="block p-5 focus:outline-none focus-visible:ring-2 focus-visible:ring-ctc-blue focus-visible:ring-inset">
            <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-ruby/90">{{ $groupLabel ?: 'Specialist' }}</p>
            <h3 class="mt-2 text-lg font-semibold text-gray-900">{{ $name }}</h3>
            @if($credentials)
                <p class="mt-0.5 text-sm text-gray-500">{{ $credentials }}</p>
            @endif
            <p class="text-ctc-blue font-medium text-sm mt-1">{{ $title }}</p>
            @if($showSpecialization)
                <p class="text-gray-500 text-sm mt-1">{{ $specialization }}</p>
            @endif
            @if($bioPlain)
                <p class="mt-3 text-gray-600 text-sm leading-relaxed line-clamp-3">{{ $bioPlain }}</p>
            @endif

            <div class="mt-5 inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.18em] text-ctc-blue/70 group-hover:text-ctc-blue transition-colors">
                <span>View profile</span>
                <svg class="w-4 h-4 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </div>
        </a>
    @else
        <div class="p-5">
            <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-ruby/90">{{ $groupLabel ?: 'Specialist' }}</p>
            <h3 class="mt-2 text-lg font-semibold text-gray-900">{{ $name }}</h3>
            @if($credentials)
                <p class="mt-0.5 text-sm text-gray-500">{{ $credentials }}</p>
            @endif
            <p class="text-ctc-blue font-medium text-sm mt-1">{{ $title }}</p>
            @if($showSpecialization)
                <p class="text-gray-500 text-sm mt-1">{{ $specialization }}</p>
            @endif
            @if($bioPlain)
                <p class="mt-3 text-gray-600 text-sm leading-relaxed line-clamp-3">{{ $bioPlain }}</p>
            @endif
        </div>
    @endif
</article>
