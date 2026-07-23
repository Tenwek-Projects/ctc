@extends('layouts.app')

@section('title', 'Cardiovascular Perfusion Training Program')

@php
    $metaDescription = $metaDescription ?? 'Cardiovascular Perfusion Training Program at AGC Tenwek Cardiothoracic Centre: classroom, simulation, and clinical experience for open-heart surgery support.';
@endphp

@push('head')
    <meta name="description" content="{{ $metaDescription }}">
@endpush

@section('content')
    @include('components.page-banner', [
        'title' => 'Cardiovascular Perfusion Training',
        'subtitle' => 'Perfusion School',
        'bannerKey' => 'training_perfusion',
    ])

    <section class="py-16 lg:py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto grid lg:grid-cols-12 gap-10 lg:gap-14 items-start">
                <div class="lg:col-span-8">
                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-accent">Course 2</p>
                    <h2 class="mt-3 text-2xl sm:text-3xl lg:text-4xl font-headline font-extrabold tracking-tight text-ctc-blue">
                        Cardiovascular Perfusion Training Program
                    </h2>

                    <ul class="mt-6 space-y-4 text-gray-600 leading-relaxed">
                        <li class="flex items-start gap-3">
                            <span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-ctc-accent shadow-[0_0_0_4px_rgba(158, 196, 248,0.18)]" aria-hidden="true"></span>
                            <span>
                                AGC Tenwek Cardiothoracic Centre is proud to offer a specialized Cardiovascular Perfusion Training Program, designed to prepare perfusionists for the critical role they play during open-heart surgery and other advanced cardiac procedures.
                            </span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-ctc-accent shadow-[0_0_0_4px_rgba(158, 196, 248,0.18)]" aria-hidden="true"></span>
                            <span>
                                The program combines classroom instruction, simulation-based learning, and extensive clinical experience, enabling trainees to develop the technical competence and clinical judgment required to safely operate heart-lung machines and support complex cardiothoracic procedures.
                            </span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-ctc-accent shadow-[0_0_0_4px_rgba(158, 196, 248,0.18)]" aria-hidden="true"></span>
                            <span>
                                Graduates are equipped to contribute effectively to multidisciplinary cardiac surgical teams while upholding the highest standards of patient safety and clinical excellence.
                            </span>
                        </li>
                    </ul>

                    <div class="mt-10 flex flex-wrap gap-3">
                        <a href="{{ route('college.apply.landing') }}"
                           class="inline-flex items-center justify-center rounded-xl bg-ctc-blue px-6 py-3.5 text-[11px] font-bold uppercase tracking-[0.18em] text-white hover:bg-ctc-blue-dark transition-colors">
                            Apply online
                        </a>
                        <a href="{{ route('training') }}"
                           class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-6 py-3.5 text-[11px] font-bold uppercase tracking-[0.18em] text-ctc-blue hover:bg-ctc-grey-light transition-colors">
                            Back to Training
                        </a>
                    </div>
                </div>

                <aside class="lg:col-span-4 space-y-4">
                    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm p-6">
                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-secondary">Also explore</p>
                        <h3 class="mt-3 text-lg font-semibold text-gray-900">Related pathways</h3>
                        <div class="mt-4 space-y-3">
                            <a href="{{ route('training.fellowship-rotations') }}" class="block rounded-xl border border-gray-100 px-4 py-3 hover:border-ctc-blue/25 hover:bg-ctc-grey-light/60 transition-colors">
                                <p class="text-sm font-semibold text-gray-900">Surgery Fellowship</p>
                                <p class="mt-1 text-xs text-gray-600">PAACS fellowship with COSECSA collaboration.</p>
                            </a>
                            <a href="{{ route('college.apply.landing') }}" class="block rounded-xl border border-gray-100 px-4 py-3 hover:border-ctc-blue/25 hover:bg-ctc-grey-light/60 transition-colors">
                                <p class="text-sm font-semibold text-gray-900">Apply online</p>
                                <p class="mt-1 text-xs text-gray-600">Start or resume your Perfusion School application.</p>
                            </a>
                            <a href="{{ route('specialists') }}" class="block rounded-xl border border-gray-100 px-4 py-3 hover:border-ctc-blue/25 hover:bg-ctc-grey-light/60 transition-colors">
                                <p class="text-sm font-semibold text-gray-900">Specialists</p>
                                <p class="mt-1 text-xs text-gray-600">Meet the faculty and care team.</p>
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <x-training-learning-excellence />

    <x-cta-section
        title="Apply to train"
        badgeLeft="Perfusion"
        badgeRight="School"
        headline="Ready to begin perfusion training?"
        description="Apply online for the Cardiovascular Perfusion Training Program, or contact us with questions about the intake."
        buttonLabel="Apply online"
        :buttonUrl="route('college.apply.landing')"
        secondaryLabel="All training programmes"
        :secondaryUrl="route('training')"
        :image="asset('hero.jpg')"
        imageAlt="Perfusion training at AGC Tenwek Cardiothoracic Centre"
        :points="[
            ['title' => 'Clinical immersion', 'text' => 'Extensive experience supporting complex cardiothoracic procedures.'],
            ['title' => 'Simulation & skills', 'text' => 'Classroom instruction with simulation-based learning.'],
            ['title' => 'Patient safety focus', 'text' => 'Graduate ready to uphold excellence on the surgical team.'],
        ]"
    />
@endsection
