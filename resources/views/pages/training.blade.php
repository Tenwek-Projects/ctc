@extends('layouts.app')

@section('title', 'Training')

@php
    $programs = $programs ?? collect();
@endphp

@section('content')
    @include('components.page-banner', [
        'title' => 'Training',
        'subtitle' => 'Training Hands, Shaping Hearts',
        'bannerKey' => 'training',
    ])

    <section class="py-16 lg:py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <div class="grid lg:grid-cols-12 gap-10 lg:gap-14 items-start">
                    <div class="lg:col-span-7">
                        <div class="max-w-2xl">
                            <p class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-900">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                                Regional training hub
                            </p>
                            <h2 class="mt-4 text-3xl sm:text-4xl font-semibold tracking-tight text-gray-900">
                                Training Hands, Shaping Hearts —
                                <span class="block text-ctc-blue">Equipping Tomorrow’s Healers Today</span>
                            </h2>
                            <p class="mt-4 text-base sm:text-lg text-gray-600 leading-relaxed">
                                In addition to patient care, the CTC serves as a regional training hub, equipping healthcare professionals with the
                                expertise needed to address the increasing prevalence of heart diseases.
                            </p>
                            <p class="mt-3 text-base sm:text-lg text-gray-600 leading-relaxed">
                                CTC offers advanced accredited Medical Education and Fellowship training programs for Cardiothoracic Surgery and
                                Cardiovascular Perfusion.
                            </p>
                            <div class="mt-6 flex flex-wrap gap-3">
                                <a href="{{ route('college.apply.landing') }}"
                                   class="inline-flex items-center justify-center px-6 py-3 rounded-lg font-semibold bg-ctc-blue text-white hover:bg-ctc-blue-dark transition-colors">
                                    Apply online
                                </a>
                                <a href="{{ route('contact') }}"
                                   class="inline-flex items-center justify-center px-6 py-3 rounded-lg font-semibold border border-gray-300 bg-white text-gray-800 hover:border-ctc-blue/40 hover:text-ctc-blue transition-colors">
                                    Enquire about training
                                </a>
                            </div>
                        </div>

                        <div class="mt-8 grid sm:grid-cols-2 gap-4">
                            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm p-6">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">Cardiothoracic Surgery</p>
                                <p class="mt-2 text-sm text-gray-700">Advanced accredited medical education and fellowship training for tomorrow’s surgical leaders.</p>
                                <div class="mt-4 h-1 w-12 rounded-full bg-[var(--color-ctc-gold)]"></div>
                            </div>
                            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm p-6">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">Cardiovascular Perfusion</p>
                                <p class="mt-2 text-sm text-gray-700">Accredited training that builds the perfusion expertise essential to safe cardiac surgery.</p>
                                <div class="mt-4 h-1 w-12 rounded-full bg-ctc-blue"></div>
                                <a href="{{ route('college.apply.landing') }}"
                                   class="mt-5 inline-flex items-center text-sm font-semibold text-ctc-blue hover:underline">
                                    Apply online
                                    <span aria-hidden="true" class="ml-1">→</span>
                                </a>
                            </div>
                        </div>

                        <div class="mt-10">
                            <div class="flex items-end justify-between gap-6">
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900">Training pathways</h3>
                                    <p class="mt-1 text-sm text-gray-600">Explore opportunities designed for different stages of training.</p>
                                </div>
                                <a href="{{ route('training-research') }}"
                                   class="hidden sm:inline-flex items-center text-sm font-semibold text-ctc-blue hover:underline">
                                    See Training & Research overview
                                </a>
                            </div>

                            <div class="mt-5 grid md:grid-cols-2 gap-4">
                                @if($programs->isNotEmpty())
                                    @foreach($programs as $program)
                                        <div class="group rounded-2xl border border-gray-200 bg-white shadow-sm p-6 hover:border-ctc-blue/30 hover:shadow-md transition-all">
                                            <div class="flex items-start justify-between gap-4">
                                                <div class="min-w-0">
                                                    <h4 class="text-lg font-semibold text-gray-900">{{ $program->title }}</h4>
                                                    @if(!empty($program->duration))
                                                        <p class="mt-1 text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">
                                                            Duration: {{ $program->duration }}
                                                        </p>
                                                    @endif
                                                </div>
                                                <span class="shrink-0 inline-flex items-center justify-center h-9 w-9 rounded-xl bg-gray-50 border border-gray-200 text-gray-500 group-hover:text-ctc-blue group-hover:border-ctc-blue/20 transition-colors">
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h6m0 0v6m0-6L10 14" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 7H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <p class="mt-3 text-sm text-gray-600 leading-relaxed">
                                                {{ str($program->description ?? '')->stripTags()->limit(220) }}
                                            </p>
                                            <div class="mt-5 flex flex-wrap gap-3">
                                                <a href="{{ route('contact') }}"
                                                   class="inline-flex items-center px-4 py-2 rounded-lg bg-ctc-blue text-white text-sm font-semibold hover:bg-ctc-blue-dark transition-colors">
                                                    Apply / enquire
                                                </a>
                                                <a href="{{ route('specialists') }}"
                                                   class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-200 bg-white text-sm font-semibold text-gray-800 hover:border-emerald-200 hover:bg-emerald-50 transition-colors">
                                                    Meet our specialists
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="md:col-span-2 rounded-2xl border border-gray-200 bg-white shadow-sm p-6">
                                        <p class="text-sm text-gray-600">
                                            Training opportunities will be listed here once published from the admin dashboard.
                                        </p>
                                        <div class="mt-4">
                                            <a href="{{ route('contact') }}"
                                               class="inline-flex items-center px-5 py-3 rounded-lg font-semibold bg-ctc-blue text-white hover:bg-ctc-blue-dark transition-colors">
                                                Contact us about training
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <aside class="lg:col-span-5 space-y-4">
                        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                            <div class="p-6">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">Explore</p>
                                <h3 class="mt-2 text-lg font-semibold text-gray-900">Continue your journey</h3>
                                <p class="mt-2 text-sm text-gray-600">Discover related sections designed to support applicants, partners, and referring clinicians.</p>
                            </div>
                            <div class="border-t border-gray-200 divide-y divide-gray-200">
                                <a href="{{ route('research') }}" class="block px-6 py-4 hover:bg-gray-50 transition-colors">
                                    <p class="text-sm font-semibold text-gray-900">Research</p>
                                    <p class="mt-1 text-xs text-gray-600">Publications, outcomes, and collaboration opportunities.</p>
                                </a>
                                <a href="{{ route('services') }}" class="block px-6 py-4 hover:bg-gray-50 transition-colors">
                                    <p class="text-sm font-semibold text-gray-900">Services</p>
                                    <p class="mt-1 text-xs text-gray-600">Clinical areas where trainees gain exposure.</p>
                                </a>
                                <a href="{{ route('specialists') }}" class="block px-6 py-4 hover:bg-gray-50 transition-colors">
                                    <p class="text-sm font-semibold text-gray-900">Specialists</p>
                                    <p class="mt-1 text-xs text-gray-600">Meet the faculty and multidisciplinary team.</p>
                                </a>
                                <a href="{{ route('support') }}" class="block px-6 py-4 hover:bg-gray-50 transition-colors">
                                    <p class="text-sm font-semibold text-gray-900">Support</p>
                                    <p class="mt-1 text-xs text-gray-600">Help train the next generation of surgeons.</p>
                                </a>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-amber-200 bg-amber-50 shadow-sm p-6">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-900">Fast track</p>
                            <h3 class="mt-2 text-lg font-semibold text-gray-900">Ready to apply or visit?</h3>
                            <p class="mt-2 text-sm text-gray-700">Send your inquiry and we’ll guide you to the right program and requirements.</p>
                            <div class="mt-4 flex flex-wrap gap-3">
                                <a href="{{ route('contact') }}"
                                   class="inline-flex items-center px-5 py-3 rounded-lg font-semibold bg-ctc-blue text-white hover:bg-ctc-blue-dark transition-colors">
                                    Contact us
                                </a>
                                <a href="{{ route('training-research') }}"
                                   class="inline-flex items-center px-5 py-3 rounded-lg font-semibold border border-amber-200 bg-white/60 text-amber-900 hover:bg-white transition-colors">
                                    Training & Research
                                </a>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>

    <x-cta-section
        title="Train with us"
        badgeLeft="Train"
        badgeRight="with us"
        headline="Ready to grow as a cardiothoracic clinician?"
        description="Join accredited Medical Education and Fellowship pathways at a regional hub shaping heart care across Africa."
        buttonLabel="Make an enquiry"
        :buttonUrl="route('contact')"
        secondaryLabel="Apply to Perfusion School"
        :secondaryUrl="route('college.apply.landing')"
        :image="asset('hero.jpg')"
        imageAlt="Training at AGC Tenwek Cardiothoracic Centre"
        :points="[
            ['title' => 'Cardiothoracic Surgery', 'text' => 'Fellowship and medical education grounded in high-volume clinical care.'],
            ['title' => 'Cardiovascular Perfusion', 'text' => 'Accredited training for the specialists who power safe cardiac surgery.'],
            ['title' => 'Mentored practice', 'text' => 'Learn beside a multidisciplinary team in a mission-driven centre.'],
            ['title' => 'Regional impact', 'text' => 'Build skills that strengthen heart care where it is needed most.'],
        ]"
    />
@endsection
