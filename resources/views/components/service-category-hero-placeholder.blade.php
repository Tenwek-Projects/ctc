@props([
    'label' => 'Main image for this page',
    /** full = wide stacked hero; column = right column in two-column layout */
    'layout' => 'full',
])

@php
    $isColumn = $layout === 'column';
    $figureClass = $isColumn
        ? 'not-prose m-0 w-full max-w-none'
        : 'not-prose mb-10 lg:mb-12';
    $boxClass = $isColumn
        ? 'relative aspect-[4/3] w-full rounded-2xl overflow-hidden border-2 border-dashed border-white/40 shadow-inner ring-1 ring-ctc-blue/20'
        : 'relative aspect-[16/9] max-h-[420px] rounded-2xl overflow-hidden border-2 border-dashed border-white/40 shadow-inner ring-1 ring-ctc-blue/20';
    $photoUrl = (\App\Support\SiteImage::urlFor('placeholder_care') ?: config('ctc.placeholder_images.care'));
@endphp

<figure class="{{ $figureClass }}" role="img" aria-label="{{ $label }}: default Tenwek imagery until a photo is uploaded in admin">
    <div class="{{ $boxClass }}">
        <img
            src="{{ $photoUrl }}"
            alt=""
            class="absolute inset-0 h-full w-full object-cover"
            loading="lazy"
            decoding="async"
            width="1200"
            height="800"
        >
        <div class="absolute inset-0 bg-gradient-to-t from-ctc-blue/65 via-ctc-blue/15 to-transparent pointer-events-none" aria-hidden="true"></div>
        <div class="absolute inset-0 flex flex-col items-center justify-end gap-1.5 px-4 pb-4 sm:pb-5 text-center">
            <p class="text-[10px] sm:text-xs font-bold uppercase tracking-[0.18em] text-white drop-shadow-sm">{{ $label }}</p>
            @if($isColumn)
                <p class="text-[10px] sm:text-[11px] text-white/90 leading-snug max-w-[16rem] drop-shadow">
                    Replace with your photo in <span class="font-semibold">Admin → Service area pages</span>
                </p>
            @else
                <p class="text-xs sm:text-sm text-white/90 max-w-md mx-auto leading-snug drop-shadow">
                    Default Tenwek imagery. Upload your own in <span class="font-semibold">Admin → Service area pages</span>
                </p>
            @endif
        </div>
    </div>
</figure>
