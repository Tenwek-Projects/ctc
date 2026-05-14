@props([
    'title',
    'description' => null,
    'buttonLabel' => 'Learn more',
    'buttonUrl' => null,
])

<section class="ctc-cta-section relative py-16 lg:py-20 text-white overflow-hidden" data-ctc-reveal="fade-in">
    {{-- Elegant 3-color treatment: blue base, teal glow, gold accent --}}
    <div class="absolute inset-0 bg-ctc-blue" aria-hidden="true"></div>
    <div class="ctc-cta-section__glow absolute inset-0 opacity-[0.95]" aria-hidden="true"
         style="background:
            radial-gradient(900px 380px at 18% 18%, rgba(98,163,161,0.35), transparent 60%),
            radial-gradient(820px 360px at 84% 30%, rgba(228,195,115,0.34), transparent 62%),
            radial-gradient(700px 340px at 50% 92%, rgba(98,163,161,0.22), transparent 60%);">
    </div>
    <div class="absolute inset-0 opacity-[0.18]" aria-hidden="true"
         style="background: repeating-linear-gradient(135deg, rgba(255,255,255,0.10) 0, rgba(255,255,255,0.10) 1px, transparent 1px, transparent 10px);">
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="max-w-4xl mx-auto text-center rounded-3xl border border-white/10 bg-white/5 shadow-[0_30px_80px_rgba(18,18,74,0.35)] backdrop-blur-xl px-6 sm:px-10 py-10 sm:py-12">
        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-ruby/95">Support</p>
        <h2 class="mt-3 text-3xl sm:text-4xl font-extrabold font-headline tracking-tight mb-4">{{ $title }}</h2>
        @if($description)
            <p class="text-[1.05rem] sm:text-xl text-white/80 max-w-2xl mx-auto mb-8 leading-relaxed">{{ $description }}</p>
        @endif
        @if($buttonUrl)
            <a href="{{ $buttonUrl }}"
               class="ctc-magnetic ctc-btn-shine inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-xl font-headline font-bold uppercase text-[0.62rem] tracking-[0.18em]
                      bg-white text-ctc-blue hover:bg-white/95 shadow-[0_18px_45px_rgba(0,0,0,0.25)] transition-transform duration-300 will-change-transform">
                {{ $buttonLabel }}
            </a>
        @endif
        </div>
    </div>
</section>
