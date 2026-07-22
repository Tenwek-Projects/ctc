@extends('layouts.app')

@section('title', 'Training & Research')

@php($metaDescription = 'Training and research at Tenwek CTC: fellowship and rotations, clinical outcomes research, publications, and opportunities for collaboration.')

@section('content')
    @include('components.page-banner', [
        'title' => 'Training & Research',
        'subtitle' => config('ctc.name'),
        'bannerKey' => 'training_research',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Training & Research', 'url' => route('training-research')],
        ],
    ])

    <section class="relative border-b border-gray-200/80 bg-gradient-to-b from-ctc-grey-light/90 to-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-12">
            <div class="max-w-3xl">
                <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-secondary">Capacity &amp; evidence</p>
                <p class="mt-3 text-lg sm:text-xl text-gray-700 leading-relaxed">
                    The CTC grows skilled cardiothoracic teams and contributes to outcomes-focused research—often alongside
                    @if($collegeWebsiteUrl)
                        <a href="{{ $collegeWebsiteUrl }}" target="_blank" rel="noopener noreferrer" class="font-semibold text-ctc-blue underline decoration-ctc-secondary/40 underline-offset-2 hover:text-ctc-secondary">{{ $collegeWebsiteLabel }}</a>
                    @else
                        <span class="font-semibold text-ctc-blue">{{ $collegeWebsiteLabel }}</span>
                    @endif
                    and partners across Kenya and beyond.
                </p>
            </div>
        </div>
    </section>

    <section class="py-14 lg:py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-12 lg:gap-12">
                <div class="lg:col-span-8">
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-3 xl:gap-6">
                        {{-- Training --}}
                        <article class="relative flex flex-col rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-shadow hover:shadow-md sm:col-span-2 xl:col-span-1">
                            <div class="absolute inset-x-0 top-0 h-1 rounded-t-2xl bg-ctc-accent" aria-hidden="true"></div>
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-ctc-accent/15 text-ctc-blue ring-1 ring-ctc-accent/25" aria-hidden="true">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0040.51 0m0 0a4.5 4.5 0 10-9 0 4.5 4.5 0 009 0zm12 0a4.5 4.5 0 10-9 0 4.5 4.5 0 009 0zM4.26 20.147a60.438 60.438 0 0040.51 0m75.557-.647a48.32 48.32 0 00-3.478-.397m-12 .162c-1.18-.096-2.35-.147-3.523-.147m-12 .162a48.32 48.32 0 00-3.478-.397m15.54.674a48.32 48.32 0 00-3.478-.397m0 0a48.32 48.32 0 013.478-.397m-3.478 0l-.355-1.867M4.26 20.147l.355-1.867m0 0a48.32 48.32 0 013.478-.397m-3.478 0l.355-1.867"/></svg>
                            </div>
                            <h2 class="mt-4 font-headline text-xl font-extrabold tracking-tight text-ctc-blue">Training</h2>
                            <p class="mt-3 flex-1 text-sm text-gray-600 leading-relaxed">
                                Fellowship, rotations, and visiting programmes that build the next generation of cardiothoracic specialists for Africa.
                            </p>
                            <div class="mt-6 flex flex-col gap-2 sm:flex-row sm:flex-wrap">
                                <a href="{{ route('training') }}" class="inline-flex items-center justify-center rounded-xl bg-ctc-blue px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-ctc-blue-dark">
                                    Explore training
                                </a>
                                @if($collegeWebsiteUrl)
                                    <a href="{{ $collegeWebsiteUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-ctc-blue transition hover:border-ctc-secondary/40 hover:bg-ctc-grey-light/50">
                                        {{ $collegeWebsiteLabel }}
                                        <svg class="ml-1.5 h-4 w-4 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                @endif
                            </div>
                        </article>

                        {{-- Research --}}
                        <article class="relative flex flex-col rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-shadow hover:shadow-md sm:col-span-2 xl:col-span-1">
                            <div class="absolute inset-x-0 top-0 h-1 rounded-t-2xl bg-ctc-secondary" aria-hidden="true"></div>
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-ctc-secondary/12 text-ctc-blue ring-1 ring-ctc-secondary/25" aria-hidden="true">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23.693L5 15.3m14.8 0l.402-.402M5 15.3l-.402.402M19.8 15.3a2.25 2.25 0 01-2.016 0"/></svg>
                            </div>
                            <h2 class="mt-4 font-headline text-xl font-extrabold tracking-tight text-ctc-blue">Research</h2>
                            <p class="mt-3 flex-1 text-sm text-gray-600 leading-relaxed">
                                Outcomes in resource-limited settings, congenital and valve disease, and surgical training effectiveness—with local and global partners.
                            </p>
                            <div class="mt-6 flex flex-col gap-2 sm:flex-row sm:flex-wrap">
                                <a href="{{ route('research') }}" class="inline-flex items-center justify-center rounded-xl bg-ctc-blue px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-ctc-blue-dark">
                                    Research overview
                                </a>
                                <a href="{{ route('research.publications') }}" class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-ctc-blue transition hover:border-ctc-secondary/40 hover:bg-ctc-grey-light/50">
                                    Publications
                                </a>
                            </div>
                        </article>

                        {{-- College spotlight (when URL set, emphasise; otherwise short copy) --}}
                        <article class="relative flex flex-col rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-shadow hover:shadow-md sm:col-span-2 xl:col-span-1">
                            <div class="absolute inset-x-0 top-0 h-1 rounded-t-2xl bg-ctc-magenta/90" aria-hidden="true"></div>
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-ctc-magenta/10 text-ctc-blue ring-1 ring-ctc-magenta/20" aria-hidden="true">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M12 9.75c2.883 0 5.647.508 8.207 1.407M12 9.75c-2.883 0-5.647.508-8.208 1.407"/></svg>
                            </div>
                            <h2 class="mt-4 font-headline text-xl font-extrabold tracking-tight text-ctc-blue">{{ $collegeWebsiteLabel }}</h2>
                            <p class="mt-3 flex-1 text-sm text-gray-600 leading-relaxed">
                                Academic programmes and institutional resources that complement hands-on training at the hospital.
                            </p>
                            @if($collegeWebsiteUrl)
                                <div class="mt-6">
                                    <a href="{{ $collegeWebsiteUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-ctc-blue px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-ctc-blue-dark">
                                        Visit {{ $collegeWebsiteLabel }}
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </div>
                            @else
                                <p class="mt-6 text-sm text-gray-600 leading-relaxed">
                                    For college programme details and admissions, please
                                    <a href="{{ route('contact') }}" class="font-semibold text-ctc-blue hover:underline">contact us</a>
                                    and we’ll point you to the right resources.
                                </p>
                            @endif
                        </article>
                    </div>
                </div>

                <aside class="lg:col-span-4">
                    <div class="space-y-4 lg:sticky lg:top-24">
                        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                            <div class="border-b border-gray-100 bg-ctc-grey-light/50 px-5 py-4">
                                <p class="text-xs font-bold uppercase tracking-[0.18em] text-gray-500">Explore</p>
                                <p class="mt-1 text-sm text-gray-600">Related pages and next steps.</p>
                            </div>
                            <ul class="divide-y divide-gray-100">
                                <li>
                                    <a href="{{ route('training.fellowship-rotations') }}" class="flex items-center justify-between gap-3 px-5 py-4 transition hover:bg-ctc-grey-light/60">
                                        <span class="text-sm font-semibold text-ctc-blue">Surgery Fellowship</span>
                                        <svg class="h-4 w-4 shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('training.perfusion') }}" class="flex items-center justify-between gap-3 px-5 py-4 transition hover:bg-ctc-grey-light/60">
                                        <span class="text-sm font-semibold text-ctc-blue">Perfusion Training</span>
                                        <svg class="h-4 w-4 shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('research') }}" class="flex items-center justify-between gap-3 px-5 py-4 transition hover:bg-ctc-grey-light/60">
                                        <span class="text-sm font-semibold text-ctc-blue">Research hub</span>
                                        <svg class="h-4 w-4 shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('about') }}" class="flex items-center justify-between gap-3 px-5 py-4 transition hover:bg-ctc-grey-light/60">
                                        <span class="text-sm font-semibold text-ctc-blue">About the CTC</span>
                                        <svg class="h-4 w-4 shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('contact') }}" class="flex items-center justify-between gap-3 px-5 py-4 transition hover:bg-ctc-grey-light/60">
                                        <span class="text-sm font-semibold text-ctc-blue">Contact</span>
                                        <svg class="h-4 w-4 shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="rounded-2xl border border-ctc-secondary/25 bg-gradient-to-br from-ctc-secondary/10 to-white p-5 shadow-sm">
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-ctc-secondary">Partners &amp; enquiries</p>
                            <p class="mt-2 text-sm text-gray-700 leading-relaxed">
                                For fellowships, research collaboration, or academic partnerships, reach out and we’ll route your message to the right team.
                            </p>
                            <a href="{{ route('contact') }}" class="mt-4 inline-flex w-full items-center justify-center rounded-xl bg-ctc-blue px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-ctc-blue-dark">
                                Contact us
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <x-cta-section
        title="Interested in training or collaboration?"
        description="Reach out for fellowship, rotation, research, and partnership inquiries."
        buttonLabel="Contact us"
        :buttonUrl="route('contact')"
    />
@endsection
