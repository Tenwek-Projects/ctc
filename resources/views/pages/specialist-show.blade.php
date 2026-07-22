@extends('layouts.app')

@section('title', $teamMember->name)

@section('content')
    @include('components.page-banner', [
        'title' => $teamMember->name,
        'subtitle' => 'Our Specialists',
        'bannerKey' => 'specialist_show',
    ])

    <section class="py-16 lg:py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-12 items-start">
                <article class="lg:col-span-8">
                    <div class="rounded-2xl bg-white border border-gray-200 shadow-sm overflow-hidden" x-data="{ photoOpen: false }">
                        <div class="aspect-video bg-ctc-grey-light">
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
                                        class="h-full w-full object-cover object-top transition duration-300 group-hover:brightness-95"
                                        loading="eager"
                                        fetchpriority="high"
                                    >
                                    <span class="pointer-events-none absolute bottom-3 right-3 inline-flex items-center gap-1.5 rounded-lg bg-black/55 px-2.5 py-1.5 text-[10px] font-semibold uppercase tracking-[0.16em] text-white opacity-0 transition group-hover:opacity-100">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM13.5 10.5h-6m3-3v6" />
                                        </svg>
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
                                    aria-label="Full photo"
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
                                <div class="h-full w-full flex items-center justify-center text-gray-400">
                                    <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-6 lg:p-8">
                            <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-accent">{{ $teamMember->team_group_label ?: 'Specialist' }}</p>
                            <h2 class="mt-3 text-2xl sm:text-3xl font-headline font-extrabold tracking-tight text-ctc-blue">{{ $teamMember->name }}</h2>
                            @if($teamMember->credentials)
                                <p class="mt-2 text-sm text-gray-500">{{ $teamMember->credentials }}</p>
                            @endif
                            <p class="mt-2 text-sm font-semibold text-gray-900">{{ $teamMember->title }}</p>
                            @if($teamMember->specialization && strcasecmp(trim((string) $teamMember->specialization), trim((string) $teamMember->title)) !== 0)
                                <p class="mt-1 text-sm text-gray-600">{{ $teamMember->specialization }}</p>
                            @endif

                            @if($teamMember->bio)
                                <div class="mt-8 prose prose-slate max-w-none prose-headings:font-headline prose-headings:text-ctc-blue prose-p:text-gray-700 prose-p:leading-relaxed prose-a:text-ctc-secondary">
                                    {!! $teamMember->bio !!}
                                </div>
                            @else
                                <p class="mt-6 text-gray-600 leading-relaxed">Profile details will be updated soon.</p>
                            @endif
                        </div>
                    </div>
                </article>

                <aside class="lg:col-span-4">
                    <div class="sticky top-24 space-y-6">
                        <div class="rounded-2xl border border-ctc-accent/25 bg-white shadow-sm p-6">
                            <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-accent">Appointments</p>
                            <h3 class="mt-3 text-lg font-bold text-gray-900">Talk to the team</h3>
                            <p class="mt-2 text-sm text-gray-600">For referrals, appointments, and international patient support.</p>
                            <a href="{{ route('book-appointment') }}"
                               class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-xl px-5 py-3 text-[11px] font-bold uppercase tracking-[0.18em] text-white
                                      bg-[linear-gradient(135deg,rgba(26,26,104,0.95),rgba(98,163,161,0.92))] hover:brightness-105 transition-all">
                                Book appointment
                                <span class="h-2 w-2 rounded-full bg-ctc-accent shadow-[0_0_0_4px_rgba(228,195,115,0.22)]"></span>
                            </a>
                            <a href="{{ route('contact') }}" class="mt-2 inline-flex w-full items-center justify-center rounded-xl border border-gray-200 bg-white px-5 py-3 text-[11px] font-bold uppercase tracking-[0.18em] text-ctc-blue hover:bg-ctc-grey-light transition-colors">
                                General enquiry
                            </a>
                        </div>

                        <div class="rounded-2xl bg-white border border-gray-200 shadow-sm p-6">
                            <h3 class="text-sm font-bold uppercase tracking-widest text-gray-500">More specialists</h3>
                            <div class="mt-4 space-y-4">
                                @forelse($related as $r)
                                    <a href="{{ route('specialists.show', $r) }}" class="block group">
                                        <p class="text-sm font-semibold text-gray-900 group-hover:text-ctc-blue transition-colors line-clamp-2">
                                            <span class="inline-block mr-2 align-middle h-1.5 w-1.5 rounded-full bg-ctc-accent/90"></span>{{ $r->name }}
                                        </p>
                                        <p class="mt-1 text-xs text-gray-500 line-clamp-1">{{ $r->title }}</p>
                                    </a>
                                @empty
                                    <p class="text-sm text-gray-600">No other profiles yet.</p>
                                @endforelse
                            </div>
                            <a href="{{ route('specialists') }}" class="mt-5 inline-flex items-center text-sm font-semibold text-ctc-secondary hover:underline">
                                View all specialists →
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection

