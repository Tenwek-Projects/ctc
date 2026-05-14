@props([
    'title',
    'subtitle' => null,
    'magentaAccent' => false,
])

<div class="mb-10 lg:mb-12">
    @if($magentaAccent)
        <p class="mb-3 flex items-center gap-2" aria-hidden="true">
            <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-ctc-magenta shadow-[0_0_0_3px_rgba(184,50,128,0.2)]"></span>
            <span class="h-px w-10 max-w-[2.5rem] bg-gradient-to-r from-ctc-ruby/75 via-ctc-magenta/45 to-transparent"></span>
        </p>
    @endif
    <h2 class="font-headline text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-ctc-blue" data-ctc-split="lines">{{ $title }}</h2>
    @if($subtitle)
        <p class="mt-3 text-[0.95rem] leading-relaxed text-gray-600 max-w-2xl" data-ctc-reveal="fade-up" data-ctc-reveal-delay="0.08">{{ $subtitle }}</p>
    @endif
</div>
