@extends('layouts.app')

@section('title', 'Training')

@php
    $metaDescription = $metaDescription ?? 'Education and training at AGC Tenwek Cardiothoracic Centre: shaping the future of cardiothoracic care through fellowship and perfusion programmes.';
@endphp

@section('content')
    @include('components.page-banner', [
        'title' => 'Education & Training',
        'subtitle' => 'Shaping the Future of Cardiothoracic Care',
        'bannerKey' => 'training',
    ])

    <section class="py-16 lg:py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl">
                <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-accent">Education &amp; training</p>
                <h2 class="mt-3 text-2xl sm:text-3xl lg:text-4xl font-headline font-extrabold tracking-tight text-ctc-blue">
                    Shaping the future of cardiothoracic care
                </h2>
                <ul class="mt-6 space-y-4 text-gray-600 leading-relaxed">
                    <li class="flex items-start gap-3">
                        <span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-ctc-accent shadow-[0_0_0_4px_rgba(158, 196, 248,0.18)]" aria-hidden="true"></span>
                        <span>
                            At AGC Tenwek Cardiothoracic Centre, excellence extends beyond patient care. As a centre for education and training, we are committed to developing the next generation of cardiothoracic healthcare professionals through accredited training programs, mentorship, and hands-on clinical experience.
                        </span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-ctc-accent shadow-[0_0_0_4px_rgba(158, 196, 248,0.18)]" aria-hidden="true"></span>
                        <span>
                            By investing in education today, we are strengthening the future of specialized heart care across Kenya, Africa, and beyond.
                        </span>
                    </li>
                </ul>
            </div>

            <div class="mt-14">
                <x-section-title
                    title="Our programmes"
                    subtitle="Explore accredited pathways in cardiothoracic surgery and cardiovascular perfusion."
                />

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8" data-ctc-stagger="0.08">
                    <a href="{{ route('training.medical-education') }}"
                       class="ctc-card-tilt group flex flex-col rounded-2xl border border-gray-200 bg-white p-6 sm:p-8 shadow-sm hover:shadow-lg hover:border-ctc-blue/35 transition-[box-shadow,border-color] duration-500 md:col-span-2 lg:col-span-1">
                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-accent">Overview</p>
                        <h3 class="mt-3 text-xl sm:text-2xl font-headline font-extrabold tracking-tight text-ctc-blue group-hover:text-ctc-ruby transition-colors">
                            Medical Education
                        </h3>
                        <p class="mt-4 text-sm sm:text-base text-gray-600 leading-relaxed flex-1">
                            Excellence in training across fellowship, perfusion, anaesthesia, critical care, and visiting programmes — with Christ-centred mentorship.
                        </p>
                        <div class="mt-6 inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.18em] text-ctc-blue/80 group-hover:text-ctc-ruby transition-colors">
                            <span>Explore medical education</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </div>
                    </a>

                    <a href="{{ route('training.fellowship-rotations') }}"
                       class="ctc-card-tilt group flex flex-col rounded-2xl border border-gray-200 bg-white p-6 sm:p-8 shadow-sm hover:shadow-lg hover:border-ctc-blue/35 transition-[box-shadow,border-color] duration-500">
                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-ruby/90">Course 1</p>
                        <h3 class="mt-3 text-xl sm:text-2xl font-headline font-extrabold tracking-tight text-ctc-blue group-hover:text-ctc-ruby transition-colors">
                            Cardiothoracic Surgery Fellowship
                        </h3>
                        <p class="mt-4 text-sm sm:text-base text-gray-600 leading-relaxed flex-1">
                            Comprehensive training in adult and paediatric cardiothoracic surgery through PAACS in collaboration with COSECSA — rigorous academics with high-volume clinical experience.
                        </p>
                        <div class="mt-6 inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.18em] text-ctc-blue/80 group-hover:text-ctc-ruby transition-colors">
                            <span>View programme</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </div>
                    </a>

                    <a href="{{ route('training.perfusion') }}"
                       class="ctc-card-tilt group flex flex-col rounded-2xl border border-gray-200 bg-white p-6 sm:p-8 shadow-sm hover:shadow-lg hover:border-ctc-blue/35 transition-[box-shadow,border-color] duration-500">
                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-ruby/90">Course 2</p>
                        <h3 class="mt-3 text-xl sm:text-2xl font-headline font-extrabold tracking-tight text-ctc-blue group-hover:text-ctc-ruby transition-colors">
                            Cardiovascular Perfusion Training Program
                        </h3>
                        <p class="mt-4 text-sm sm:text-base text-gray-600 leading-relaxed flex-1">
                            Specialized training for perfusionists supporting open-heart surgery and advanced cardiac procedures — classroom, simulation, and extensive clinical practice.
                        </p>
                        <div class="mt-6 inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.18em] text-ctc-blue/80 group-hover:text-ctc-ruby transition-colors">
                            <span>View programme</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <x-cta-section
        title="Train with us"
        badgeLeft="Train"
        badgeRight="with us"
        headline="Ready to grow as a cardiothoracic clinician?"
        description="Join accredited fellowship and perfusion pathways at a regional hub shaping heart care across Africa."
        buttonLabel="Make an enquiry"
        :buttonUrl="route('contact')"
        secondaryLabel="Apply to Perfusion School"
        :secondaryUrl="route('college.apply.landing')"
        :image="asset('hero.jpg')"
        imageAlt="Training at AGC Tenwek Cardiothoracic Centre"
        :points="[
            ['title' => 'Cardiothoracic Surgery', 'text' => 'PAACS fellowship with COSECSA collaboration and high-volume mentorship.'],
            ['title' => 'Cardiovascular Perfusion', 'text' => 'Accredited training for the specialists who power safe cardiac surgery.'],
            ['title' => 'Mentored practice', 'text' => 'Learn beside a multidisciplinary team in a mission-driven centre.'],
            ['title' => 'Regional impact', 'text' => 'Build skills that strengthen heart care where it is needed most.'],
        ]"
    />
@endsection
