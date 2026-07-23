@props([
    'variant' => 'light',
    'emphasizeLogo' => false,
])

@php
    $isDark = $variant === 'dark';
    $line1 = $isDark ? 'text-white' : 'text-ctc-blue';
    $line2 = $isDark ? 'text-sky-200/95' : 'text-[#2d3a8f]';
    $line3 = $isDark ? 'text-white/90' : 'text-ctc-blue';
    $divider = $isDark ? 'bg-white/55' : 'bg-ctc-blue';
    $imgClass = $isDark
        ? 'drop-shadow-[0_8px_28px_rgba(0,0,0,0.55)]'
        : 'drop-shadow-[0_2px_8px_rgba(26,26,104,0.12)]';

    // Navbar: larger *visual* logo via transform only (layout box stays h-9) so the menu bar height stays fixed.
    $imgSize = $emphasizeLogo
        ? 'h-9 w-auto shrink-0 origin-left scale-[1.28] object-contain sm:scale-[1.32] md:scale-[1.36] ' . $imgClass
        : 'h-9 w-auto shrink-0 object-contain sm:h-11 md:h-12 ' . $imgClass;

    // One flex gap controls both logo↔rule and rule↔text (identical in layout). Navbar emphasizeLogo
    // scales the bitmap with origin-left; reserve right padding so the scaled art stays inside this
    // flex item's box (otherwise it paints over the gap and touches the rule).
    $dividerSize = $emphasizeLogo
        ? 'h-9 w-[2.5px] shrink-0 origin-center scale-y-[1.18] self-center rounded-full sm:scale-y-[1.22] md:scale-y-[1.26] '
        : 'h-9 w-[2.5px] shrink-0 self-center rounded-full sm:h-11 md:h-12 ';

    $logoWrap = $emphasizeLogo
        ? 'inline-flex shrink-0 items-center pr-3 sm:pr-3.5 md:pr-4'
        : 'inline-flex shrink-0 items-center';

    $logoUrl = \App\Support\SiteImage::urlFor('logo') ?: asset('logo-ctc.png');
@endphp

<div {{ $attributes->class(['flex min-w-0 items-center gap-x-2.5 sm:gap-x-3 md:gap-x-3.5']) }}>
    <span class="{{ $logoWrap }}">
        <img
            src="{{ $logoUrl }}"
            alt=""
            width="120"
            height="120"
            decoding="async"
            class="{{ $imgSize }}"
        />
    </span>
    <span
        class="{{ $dividerSize }}{{ $divider }}"
        aria-hidden="true"
    ></span>
    <div class="min-w-0 text-left leading-tight">
        <span class="block font-extrabold tracking-tight {{ $line1 }} text-[0.7rem] sm:text-sm md:text-[0.95rem]">
            AGC TENWEK
        </span>
        <span class="mt-0.5 block font-bold uppercase tracking-wide {{ $line2 }} text-[0.58rem] sm:text-[0.65rem] md:text-xs">
            Cardiothoracic Centre
        </span>
    </div>
</div>
