@extends('layouts.app')

@section('title', $teamMember->name)

@section('content')
    @include('components.page-banner', [
        'title' => $teamMember->name,
        'subtitle' => $teamMember->team_group_label ?: 'Our Specialists',
        'bannerKey' => 'specialist_show',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Our Specialists', 'url' => route('specialists')],
            ['label' => $teamMember->name],
        ],
    ])

    <section class="relative overflow-hidden py-14 lg:py-20">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_top_left,rgba(98,163,161,0.12),transparent_55%),radial-gradient(ellipse_at_bottom_right,rgba(26,26,104,0.08),transparent_50%)]" aria-hidden="true"></div>

        <div class="container relative mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-12 lg:gap-12 items-start">
                <article class="lg:col-span-8" data-ctc-reveal="fade-up">
                    <div class="grid gap-8 sm:grid-cols-[minmax(0,14rem)_1fr] lg:grid-cols-[minmax(0,16rem)_1fr] items-start">
                        <div class="relative" @if($teamMember->photo_url) x-data="{ photoOpen: false }" @endif>
                            <div class="aspect-[4/5] overflow-hidden rounded-2xl bg-ctc-grey-light ring-1 ring-black/5 shadow-[0_24px_60px_-28px_rgba(26,26,104,0.45)]">
                                @if($teamMember->photo_url)
                                    <button
                                        type="button"
                                        class="group relative block h-full w-full cursor-zoom-in focus:outline-none focus-visible:ring-2 focus-visible:ring-ctc-blue focus-visible:ring-inset"
                                        @click="photoOpen = true"
                                        aria-label="View full photo of {{ $teamMember->name }}"
                                    >
                                        <img
                                            src="{{ $teamMember->photo_url }}"
                                            alt="{{ $teamMember->name }}"
                                            width="640"
                                            height="800"
                                            class="h-full w-full object-cover object-top transition duration-500 group-hover:scale-[1.03] group-hover:brightness-95"
                                            loading="eager"
                                            fetchpriority="high"
                                            decoding="async"
                                        >
                                        <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/55 to-transparent px-3 pb-3 pt-10 opacity-0 transition group-hover:opacity-100">
                                            <span class="inline-flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-[0.16em] text-white">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM13.5 10.5h-6m3-3v6" />
                                                </svg>
                                                View full
                                            </span>
                                        </span>
                                    </button>

                                    <div
                                        x-show="photoOpen"
                                        x-cloak
                                        x-transition.opacity
                                        class="fixed inset-0 z-[80] flex items-center justify-center bg-black/80 p-4 sm:p-8"
                                        role="dialog"
                                        aria-modal="true"
                                        aria-label="Full photo of {{ $teamMember->name }}"
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
                                            src="{{ $teamMember->photo_url }}"
                                            alt="{{ $teamMember->name }}"
                                            class="max-h-[90vh] max-w-full object-contain shadow-2xl"
                                            @click.stop
                                        >
                                    </div>
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-gray-300">
                                        <svg class="h-20 w-20" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="pointer-events-none absolute -bottom-2 -right-2 h-16 w-16 rounded-full bg-ctc-ruby/15 blur-2xl" aria-hidden="true"></div>
                        </div>

                        <div class="min-w-0 pt-1">
                            <a href="{{ route('specialists') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-ctc-secondary hover:text-ctc-blue transition-colors">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                                </svg>
                                All specialists
                            </a>

                            @if($teamMember->team_group_label)
                                <p class="mt-5 text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-ruby">
                                    {{ $teamMember->team_group_label }}
                                </p>
                            @endif

                            <h2 class="mt-2 font-headline text-2xl sm:text-3xl lg:text-[2.1rem] font-extrabold tracking-tight text-ctc-blue leading-tight">
                                {{ $teamMember->name }}
                            </h2>

                            @if($teamMember->credentials)
                                <p class="mt-2 text-sm text-gray-500">{{ $teamMember->credentials }}</p>
                            @endif

                            <p class="mt-3 text-base font-semibold text-gray-900">{{ $teamMember->title }}</p>

                            @if($teamMember->specialization && strcasecmp(trim((string) $teamMember->specialization), trim((string) $teamMember->title)) !== 0)
                                <p class="mt-1 text-sm text-gray-600">{{ $teamMember->specialization }}</p>
                            @endif

                            <div class="mt-8 border-t border-ctc-blue/10 pt-6">
                                <h3 class="font-headline text-lg font-bold text-ctc-blue">About</h3>

                                @if($teamMember->bio)
                                    <div class="mt-3 prose prose-slate max-w-none prose-headings:font-headline prose-headings:text-ctc-blue prose-p:text-gray-700 prose-p:leading-relaxed prose-p:my-4 prose-a:text-ctc-secondary prose-a:font-semibold">
                                        {!! $teamMember->bio !!}
                                    </div>
                                @else
                                    <p class="mt-3 text-gray-600 leading-relaxed">
                                        {{ $teamMember->name }} is part of the Cardiothoracic Centre team at Tenwek Hospital.
                                        A fuller biography will be published here soon. For appointments or referrals, please contact the centre.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </article>

                <aside class="lg:col-span-4" data-ctc-reveal="fade-up" data-ctc-reveal-delay="0.1">
                    <div class="sticky top-24 space-y-6">
                        <div class="rounded-2xl border border-ctc-secondary/25 bg-white/90 backdrop-blur-sm p-6 shadow-sm">
                            <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-secondary">Next step</p>
                            <h3 class="mt-3 text-lg font-bold text-gray-900">Talk to the team</h3>
                            <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                                Referrals, appointments, and international patient support.
                            </p>
                            <a href="{{ route('book-appointment') }}"
                               class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-xl px-5 py-3 text-[11px] font-bold uppercase tracking-[0.18em] text-white
                                      bg-ctc-blue hover:bg-ctc-blue-dark transition-colors">
                                Book appointment
                            </a>
                            <a href="{{ route('contact') }}"
                               class="mt-2 inline-flex w-full items-center justify-center rounded-xl border border-gray-200 bg-white px-5 py-3 text-[11px] font-bold uppercase tracking-[0.18em] text-ctc-blue hover:bg-ctc-grey-light transition-colors">
                                General enquiry
                            </a>
                        </div>

                        <div class="rounded-2xl border border-gray-200/80 bg-white/90 backdrop-blur-sm p-6 shadow-sm">
                            <h3 class="text-[11px] font-bold uppercase tracking-[0.22em] text-gray-500">Also on the team</h3>
                            <ul class="mt-4 space-y-3">
                                @forelse($related as $r)
                                    <li>
                                        <a href="{{ route('specialists.show', $r) }}" class="group flex items-center gap-3 rounded-xl p-1.5 -mx-1.5 hover:bg-ctc-grey-light/80 transition-colors">
                                            <span class="relative h-12 w-12 shrink-0 overflow-hidden rounded-xl bg-ctc-grey-light ring-1 ring-black/5">
                                                @if($r->photo_url)
                                                    <img
                                                        src="{{ $r->photo_url }}"
                                                        alt=""
                                                        class="h-full w-full object-cover object-top"
                                                        loading="lazy"
                                                        decoding="async"
                                                    >
                                                @else
                                                    <span class="flex h-full w-full items-center justify-center text-gray-300">
                                                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                                        </svg>
                                                    </span>
                                                @endif
                                            </span>
                                            <span class="min-w-0 flex-1">
                                                <span class="block text-sm font-semibold text-gray-900 group-hover:text-ctc-blue transition-colors line-clamp-1">{{ $r->name }}</span>
                                                <span class="mt-0.5 block text-xs text-gray-500 line-clamp-1">{{ $r->title }}</span>
                                            </span>
                                            <svg class="h-4 w-4 shrink-0 text-gray-300 transition group-hover:text-ctc-secondary group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                            </svg>
                                        </a>
                                    </li>
                                @empty
                                    <li class="text-sm text-gray-600">No other profiles yet.</li>
                                @endforelse
                            </ul>
                            <a href="{{ route('specialists') }}" class="mt-5 inline-flex items-center gap-1 text-sm font-semibold text-ctc-secondary hover:text-ctc-blue transition-colors">
                                View all specialists
                                <span aria-hidden="true">→</span>
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
