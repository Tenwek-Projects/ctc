@php
    $recent = $recent ?? collect();
    $context = $context ?? 'index';
    $article = $article ?? null;
@endphp

<div class="space-y-6">
    @if($context === 'show' && $article)
        <div class="rounded-2xl border border-ctc-accent/50 bg-gradient-to-br from-ctc-accent/15 to-white p-4 shadow-sm">
            <p class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-ctc-secondary">Reading now</p>
            <p class="mt-2 line-clamp-4 text-sm font-bold leading-snug text-ctc-blue">{{ $article->title }}</p>
        </div>
    @endif

    {{-- Playful masthead --}}
    <div class="relative">
        <a href="{{ route('news') }}" class="group flex items-start gap-3 rounded-2xl border border-ctc-accent/30 bg-gradient-to-br from-ctc-accent/15 via-white to-ctc-secondary/10 p-4 transition-transform duration-300 hover:-rotate-1 hover:shadow-md">
            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-ctc-blue text-lg font-black text-white shadow-inner">N</span>
            <div class="min-w-0">
                <p class="font-headline text-[0.65rem] font-extrabold uppercase tracking-[0.2em] text-ctc-secondary">Newsroom</p>
                <p class="mt-1 font-headline text-base font-extrabold leading-tight text-ctc-blue group-hover:text-ctc-blue-dark">
                    Stories from the CTC
                </p>
            </div>
        </a>
    </div>

    <nav class="rounded-2xl border border-gray-200/80 bg-white/90 p-2 shadow-sm" aria-label="News shortcuts">
        <ul class="space-y-1">
            <li>
                <a href="{{ route('news') }}" class="flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-semibold text-ctc-blue transition-colors hover:bg-ctc-grey-light {{ request()->routeIs('news') && !request()->routeIs('news.show') ? 'bg-ctc-grey-light ring-1 ring-ctc-secondary/30' : '' }}">
                    <span class="text-base" aria-hidden="true">📰</span>
                    All news
                </a>
            </li>
            <li>
                <a href="{{ route('events') }}" class="flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-semibold text-ctc-blue transition-colors hover:bg-ctc-grey-light {{ request()->routeIs('events') || request()->routeIs('events.show') ? 'bg-ctc-grey-light ring-1 ring-ctc-secondary/30' : '' }}">
                    <span class="text-base" aria-hidden="true">📅</span>
                    Events
                </a>
            </li>
            <li>
                <a href="{{ route('gallery') }}" class="flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-semibold text-ctc-blue transition-colors hover:bg-ctc-grey-light {{ request()->routeIs('gallery') ? 'bg-ctc-grey-light ring-1 ring-ctc-secondary/30' : '' }}">
                    <span class="text-base" aria-hidden="true">🖼️</span>
                    Gallery
                </a>
            </li>
            <li>
                <a href="{{ route('contact') }}" class="flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-semibold text-gray-700 transition-colors hover:bg-ctc-grey-light hover:text-ctc-blue">
                    <span class="text-base leading-none" aria-hidden="true">📞</span>
                    Contact the team
                </a>
            </li>
            <li>
                <a href="{{ route('services') }}" class="flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-semibold text-gray-700 transition-colors hover:bg-ctc-grey-light hover:text-ctc-blue">
                    <span class="text-base leading-none" aria-hidden="true">🩺</span>
                    Clinical services
                </a>
            </li>
            <li>
                <a href="{{ route('support') }}" class="flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-semibold text-gray-700 transition-colors hover:bg-ctc-grey-light hover:text-ctc-blue">
                    <span class="text-base leading-none" aria-hidden="true">🤝</span>
                    Support the CTC
                </a>
            </li>
        </ul>
    </nav>

    <div class="rounded-2xl border border-ctc-blue/15 bg-white p-5 shadow-sm">
        <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-ctc-accent">Need help?</p>
        <h3 class="mt-2 font-headline text-lg font-extrabold text-ctc-blue">We’re here for you</h3>
        <p class="mt-2 text-sm leading-relaxed text-gray-600">Appointments, referrals, and media enquiries.</p>
        <a href="{{ route('contact') }}" class="mt-4 inline-flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-ctc-blue to-ctc-secondary px-4 py-3 text-[11px] font-bold uppercase tracking-[0.18em] text-white shadow-lg transition hover:brightness-105">
            Contact us
        </a>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white/95 p-5 shadow-sm">
        <div class="flex items-center justify-between gap-2">
            <h3 class="text-sm font-extrabold uppercase tracking-widest text-gray-500">Recent updates</h3>
            <span class="rounded-full bg-ctc-accent/20 px-2 py-0.5 text-[10px] font-bold text-ctc-blue">{{ $recent->count() }}</span>
        </div>
        <ul class="mt-4 space-y-3">
            @forelse($recent as $r)
                <li>
                    <a
                        href="{{ route('news.show', $r->slug) }}"
                        class="group block rounded-xl border border-transparent px-3 py-2.5 transition-all duration-200 hover:border-ctc-accent/40 hover:bg-ctc-grey-light/80"
                    >
                        <span class="line-clamp-2 text-sm font-semibold text-gray-900 group-hover:text-ctc-blue">{{ $r->title }}</span>
                        <span class="mt-1 flex flex-wrap items-center gap-2 text-[11px] text-gray-500">
                            <span class="rounded-md bg-ctc-blue/5 px-1.5 py-0.5 font-semibold uppercase tracking-wide text-ctc-blue/90">{{ $r->type }}</span>
                            <span>{{ optional($r->published_at ?? $r->created_at)->format('M j, Y') }}</span>
                        </span>
                    </a>
                </li>
            @empty
                <li class="text-sm text-gray-600">No posts yet. Check back soon.</li>
            @endforelse
        </ul>
        @if($context === 'show')
            <a href="{{ route('news') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-bold text-ctc-secondary hover:underline">
                ← All news
            </a>
        @endif
    </div>

    <div class="rounded-2xl border border-dashed border-ctc-secondary/40 bg-ctc-secondary/5 p-4">
        <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-ctc-secondary">Explore</p>
        <div class="mt-3 flex flex-wrap gap-2">
            <a href="{{ route('training') }}" class="rounded-full bg-white px-3 py-1.5 text-xs font-semibold text-ctc-blue shadow-sm ring-1 ring-gray-200 transition hover:ring-ctc-accent/50">Training</a>
            <a href="{{ route('research') }}" class="rounded-full bg-white px-3 py-1.5 text-xs font-semibold text-ctc-blue shadow-sm ring-1 ring-gray-200 transition hover:ring-ctc-accent/50">Research</a>
            <a href="{{ route('international-patients') }}" class="rounded-full bg-white px-3 py-1.5 text-xs font-semibold text-ctc-blue shadow-sm ring-1 ring-gray-200 transition hover:ring-ctc-accent/50">International</a>
        </div>
    </div>

    <div class="flex flex-wrap gap-x-4 gap-y-2 border-t border-gray-200/80 pt-4 text-[11px] font-semibold text-gray-500">
        @if(Route::has('privacy-policy'))
            <a href="{{ route('privacy-policy') }}" class="hover:text-ctc-blue">Privacy</a>
        @endif
        @if(Route::has('terms-of-service'))
            <a href="{{ route('terms-of-service') }}" class="hover:text-ctc-blue">Terms</a>
        @endif
        <span class="text-gray-400">{{ config('ctc.name') }}</span>
    </div>
</div>
