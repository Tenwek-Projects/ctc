@props([
    'name',
    'description' => null,
    'url' => null,
    'detailUrl' => null,
    'id' => null,
    'magentaLine' => false,
])

@php
    $url = $url ?? '#';
    $detailUrl = $detailUrl ?? null;
    $descriptionPlain = $description ? \Illuminate\Support\Str::limit(trim(strip_tags($description)), 220) : null;
@endphp

<div
   @if($id) id="{{ $id }}" @endif
   class="ctc-card-tilt group flex flex-col h-full min-h-[190px] p-6 rounded-xl bg-white border border-gray-200 shadow-sm hover:shadow-lg hover:border-ctc-blue/35 transition-[box-shadow,border-color,transform] duration-500 scroll-mt-24">
    <span @class([
        'mb-4 block h-px w-0 origin-left rounded-full transition-[width] duration-500 ease-out group-hover:w-12',
        'bg-gradient-to-r from-ctc-accent via-ctc-magenta to-ctc-secondary' => $magentaLine,
        'bg-gradient-to-r from-ctc-accent to-ctc-secondary' => ! $magentaLine,
    ]) aria-hidden="true"></span>
    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-ctc-blue transition-colors">{{ $name }}</h3>
    @if($descriptionPlain)
        <p class="mt-2 text-gray-600 text-sm leading-relaxed flex-1">{{ $descriptionPlain }}</p>
    @endif

    <div class="mt-auto pt-5 flex flex-wrap items-center gap-3">
        @php
            $primaryHref = $detailUrl ?: $url;
        @endphp
        @if($primaryHref && $primaryHref !== '#')
            <a href="{{ $primaryHref }}"
               class="inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.18em] text-ctc-blue/80 hover:text-ctc-ruby transition-colors">
                Learn more
                <svg class="w-4 h-4 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        @endif
    </div>
</div>
