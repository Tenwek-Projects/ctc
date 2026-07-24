@extends('layouts.app')

@section('title', 'Cardiothoracic Surgery Fellowship')

@php
    $metaDescription = $metaDescription ?? 'Cardiothoracic Surgery Fellowship at AGC Tenwek Cardiothoracic Centre through PAACS in collaboration with COSECSA.';
@endphp

@section('content')
    @include('components.page-banner', [
        'title' => 'Cardiothoracic Surgery Fellowship',
        'subtitle' => 'PAACS · COSECSA',
        'bannerKey' => 'training_fellowship_rotations',
    ])

    <section class="py-16 lg:py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto grid lg:grid-cols-12 gap-10 lg:gap-14 items-start">
                <div class="lg:col-span-8">
                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-ruby">Course 1</p>
                    <h2 class="mt-3 text-2xl sm:text-3xl lg:text-4xl font-headline font-extrabold tracking-tight text-ctc-blue">
                        Cardiothoracic Surgery Fellowship
                    </h2>

                    <ul class="mt-6 space-y-4 text-gray-600 leading-relaxed">
                        <li class="flex items-start gap-3">
                            <span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-ctc-ruby shadow-[0_0_0_4px_rgba(179,49,39,0.18)]" aria-hidden="true"></span>
                            <span>
                                AGC Tenwek Cardiothoracic Centre is proud to offer a Cardiothoracic Surgery Fellowship through the Pan-African Academy of Christian Surgeons (PAACS) in collaboration with the College of Surgeons of East, Central and Southern Africa (COSECSA).
                            </span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-ctc-ruby shadow-[0_0_0_4px_rgba(179,49,39,0.18)]" aria-hidden="true"></span>
                            <span>
                                The fellowship provides comprehensive training in adult and pediatric cardiothoracic surgery, combining rigorous academic learning with high-volume clinical and surgical experience under the guidance of experienced consultant surgeons.
                            </span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-ctc-ruby shadow-[0_0_0_4px_rgba(179,49,39,0.18)]" aria-hidden="true"></span>
                            <span>
                                The program equips fellows with the knowledge, technical expertise, professional leadership, and compassionate approach needed to provide world-class cardiothoracic care in Africa and beyond.
                            </span>
                        </li>
                    </ul>

                    <div class="mt-10 flex flex-wrap gap-3">
                        <a href="{{ route('contact') }}"
                           class="inline-flex items-center justify-center rounded-xl bg-ctc-blue px-6 py-3.5 text-[11px] font-bold uppercase tracking-[0.18em] text-white hover:bg-ctc-blue-dark transition-colors">
                            Enquire about fellowship
                        </a>
                        <a href="{{ route('training') }}"
                           class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-6 py-3.5 text-[11px] font-bold uppercase tracking-[0.18em] text-ctc-blue hover:bg-ctc-grey-light transition-colors">
                            Back to Training
                        </a>
                    </div>
                </div>

                <aside class="lg:col-span-4">
                    <div class="lg:sticky lg:top-24 space-y-5">
                        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                            <div class="border-b border-gray-100 bg-ctc-blue px-5 py-5 sm:px-6">
                                <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-ruby">Also explore</p>
                                <h3 class="mt-2 text-lg font-headline font-extrabold tracking-tight text-white">
                                    Continue your journey
                                </h3>
                                <p class="mt-1.5 text-sm text-white/70 leading-relaxed">
                                    Related programmes, people, and research connected to fellowship training.
                                </p>
                            </div>

                            <nav class="divide-y divide-gray-100" aria-label="Related pathways">
                                <a href="{{ route('training.perfusion') }}"
                                   class="group flex items-start gap-4 px-5 py-4 sm:px-6 hover:bg-ctc-grey-light/70 transition-colors">
                                    <span class="mt-0.5 inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-ctc-ruby/10 text-ctc-ruby ring-1 ring-ctc-ruby/20" aria-hidden="true">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                        </svg>
                                    </span>
                                    <span class="min-w-0 flex-1">
                                        <span class="flex items-center justify-between gap-2">
                                            <span class="text-sm font-semibold text-gray-900 group-hover:text-ctc-blue transition-colors">Cardiovascular Perfusion</span>
                                            <svg class="h-4 w-4 shrink-0 text-gray-300 group-hover:text-ctc-ruby transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </span>
                                        <span class="mt-1 block text-xs text-gray-500 leading-relaxed">Course 2 — specialized perfusion training for open-heart surgery support.</span>
                                    </span>
                                </a>

                                <a href="{{ route('specialists') }}"
                                   class="group flex items-start gap-4 px-5 py-4 sm:px-6 hover:bg-ctc-grey-light/70 transition-colors">
                                    <span class="mt-0.5 inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-ctc-blue/10 text-ctc-blue ring-1 ring-ctc-blue/15" aria-hidden="true">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0" />
                                        </svg>
                                    </span>
                                    <span class="min-w-0 flex-1">
                                        <span class="flex items-center justify-between gap-2">
                                            <span class="text-sm font-semibold text-gray-900 group-hover:text-ctc-blue transition-colors">Our Specialists</span>
                                            <svg class="h-4 w-4 shrink-0 text-gray-300 group-hover:text-ctc-ruby transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </span>
                                        <span class="mt-1 block text-xs text-gray-500 leading-relaxed">Meet the consultant faculty and multidisciplinary care team.</span>
                                    </span>
                                </a>

                                <a href="{{ route('research') }}"
                                   class="group flex items-start gap-4 px-5 py-4 sm:px-6 hover:bg-ctc-grey-light/70 transition-colors">
                                    <span class="mt-0.5 inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-ctc-secondary/15 text-ctc-secondary ring-1 ring-ctc-secondary/25" aria-hidden="true">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                        </svg>
                                    </span>
                                    <span class="min-w-0 flex-1">
                                        <span class="flex items-center justify-between gap-2">
                                            <span class="text-sm font-semibold text-gray-900 group-hover:text-ctc-blue transition-colors">Research</span>
                                            <svg class="h-4 w-4 shrink-0 text-gray-300 group-hover:text-ctc-ruby transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </span>
                                        <span class="mt-1 block text-xs text-gray-500 leading-relaxed">Outcomes research, publications, and academic collaboration.</span>
                                    </span>
                                </a>

                                <a href="{{ route('training') }}"
                                   class="group flex items-start gap-4 px-5 py-4 sm:px-6 hover:bg-ctc-grey-light/70 transition-colors">
                                    <span class="mt-0.5 inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-ctc-blue ring-1 ring-gray-200" aria-hidden="true">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.44 60.44 0 00-.491 6.347A48.62 48.62 0 0112 20.904a48.62 48.62 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.906 59.906 0 0112 3.493a59.903 59.903 0 0110.399 5.84c-.908.076-1.783.28-2.658.813m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342" />
                                        </svg>
                                    </span>
                                    <span class="min-w-0 flex-1">
                                        <span class="flex items-center justify-between gap-2">
                                            <span class="text-sm font-semibold text-gray-900 group-hover:text-ctc-blue transition-colors">All training programmes</span>
                                            <svg class="h-4 w-4 shrink-0 text-gray-300 group-hover:text-ctc-ruby transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </span>
                                        <span class="mt-1 block text-xs text-gray-500 leading-relaxed">Return to the Education &amp; Training overview.</span>
                                    </span>
                                </a>
                            </nav>
                        </div>

                        <div class="rounded-2xl border border-ctc-ruby/20 bg-ctc-ruby/[0.04] p-5 sm:p-6">
                            <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-ruby">Next step</p>
                            <h3 class="mt-2 text-base font-semibold text-gray-900">Questions about eligibility?</h3>
                            <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                                Our team can guide you on requirements, timelines, and how to begin.
                            </p>
                            <div class="mt-4 space-y-2">
                                <a href="{{ route('college.apply.landing') }}"
                                   class="inline-flex w-full items-center justify-center rounded-xl bg-ctc-ruby px-5 py-3 text-[11px] font-bold uppercase tracking-[0.18em] text-white hover:bg-ctc-ruby/90 transition-colors">
                                    Apply online
                                </a>
                                <a href="{{ route('contact') }}"
                                   class="inline-flex w-full items-center justify-center rounded-xl border border-gray-200 bg-white px-5 py-3 text-[11px] font-bold uppercase tracking-[0.18em] text-ctc-blue hover:bg-ctc-grey-light transition-colors">
                                    Enquire now
                                </a>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <x-training-learning-excellence />

    <x-cta-section
        title="Apply to train"
        badgeLeft="Fellowship"
        badgeRight="PAACS"
        headline="Interested in the Cardiothoracic Surgery Fellowship?"
        description="Contact our team to learn about eligibility, timelines, and how to begin your application."
        buttonLabel="Contact us"
        :buttonUrl="route('contact')"
        secondaryLabel="All training programmes"
        :secondaryUrl="route('training')"
        :image="asset('hero.jpg')"
        imageAlt="Fellowship training at AGC Tenwek Cardiothoracic Centre"
        :points="[
            ['title' => 'PAACS & COSECSA', 'text' => 'Accredited fellowship through leading regional surgical bodies.'],
            ['title' => 'High-volume practice', 'text' => 'Adult and paediatric cardiothoracic surgical experience.'],
            ['title' => 'Consultant mentorship', 'text' => 'Learn under experienced surgeons and multidisciplinary teams.'],
        ]"
    />
@endsection
