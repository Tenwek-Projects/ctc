@props([
    'name',
    'description' => null,
    'url' => null,
    'detailUrl' => null,
    'id' => null,
    'magentaLine' => false,
    'excerptLimit' => 220,
])

@php
    $url = $url ?? '#';
    $detailUrl = $detailUrl ?? null;
    $limit = max(60, (int) $excerptLimit);
    $descriptionPlain = $description ? \Illuminate\Support\Str::limit(trim(strip_tags($description)), $limit) : null;
    $primaryHref = ($detailUrl && $detailUrl !== '#') ? $detailUrl : (($url && $url !== '#') ? $url : null);
    $tag = $primaryHref ? 'a' : 'div';
@endphp

<{{ $tag }}
    @if($id) id="{{ $id }}" @endif
    @if($primaryHref) href="{{ $primaryHref }}" @endif
    {{ $attributes->class([
        'ctc-card-tilt group relative flex h-full min-h-[200px] flex-col overflow-hidden rounded-none',
        'border border-gray-200/90 bg-white pl-6 pr-5 py-6 shadow-sm',
        'transition-[border-color,box-shadow,transform,background-color] duration-500 ease-out',
        'hover:-translate-y-0.5 hover:border-ctc-ruby/35 hover:bg-[#fffaf9] hover:shadow-[0_18px_40px_-28px_rgba(179,49,39,0.45)]',
        'focus:outline-none focus-visible:ring-2 focus-visible:ring-ctc-ruby/50 focus-visible:ring-offset-2',
        'scroll-mt-24',
    ]) }}
>
    {{-- Ruby edge: restrained brand accent --}}
    <span
        @class([
            'pointer-events-none absolute inset-y-0 left-0 w-1 transition-colors duration-500',
            'bg-ctc-ruby' => $magentaLine,
            'bg-ctc-ruby/80 group-hover:bg-ctc-ruby' => ! $magentaLine,
        ])
        aria-hidden="true"
    ></span>

    <span
        @class([
            'mb-4 block h-[2px] origin-left transition-all duration-500 ease-out',
            'w-14 bg-ctc-ruby' => $magentaLine,
            'w-10 bg-ctc-ruby/85 group-hover:w-16 group-hover:bg-ctc-ruby' => ! $magentaLine,
        ])
        aria-hidden="true"
    ></span>

    <h3 class="font-headline text-lg font-bold tracking-tight text-ctc-blue transition-colors duration-300 group-hover:text-ctc-ruby">
        {{ $name }}
    </h3>

    @if($descriptionPlain)
        <p class="mt-2.5 flex-1 text-sm leading-relaxed text-gray-600">
            {{ $descriptionPlain }}
        </p>
    @endif

    @if($primaryHref)
        <span class="mt-auto inline-flex items-center gap-2 pt-5 text-[11px] font-bold uppercase tracking-[0.18em] text-ctc-ruby transition-all duration-300 group-hover:gap-3">
            Learn more
            <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
        </span>
    @endif
</{{ $tag }}>
