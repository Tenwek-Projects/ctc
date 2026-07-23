@extends('layouts.app')

@section('title', $pageTitle)

@php
    $canonicalUrl = $activeServiceCategory
        ? route('services.category', ['serviceCategory' => $activeServiceCategory], true)
        : route('services', [], true);
@endphp

@push('head')
    <link rel="canonical" href="{{ $canonicalUrl }}">
    @if($activeServiceCategory && $categoryPage)
        @php
            $jsonLd = [
                '@context' => 'https://schema.org',
                '@type' => 'MedicalWebPage',
                'name' => \App\Support\Seo\Seo::brandTitle($pageTitle),
                'description' => $metaDescription,
                'url' => $canonicalUrl,
                'isPartOf' => [
                    '@type' => 'MedicalOrganization',
                    'name' => config('ctc.name'),
                    'parentOrganization' => [
                        '@type' => 'Hospital',
                        'name' => config('ctc.hospital'),
                        'address' => config('ctc.contact.address'),
                    ],
                ],
            ];
        @endphp
        <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @endif
@endpush

@section('content')
    @include('components.page-banner', [
        'title' => $categoryPage?->intro_heading ?? ($categoryLabel ?? 'Our Services'),
        'subtitle' => $categoryPage?->intro_subheading ?? ($categoryLabel
            ? 'Clinical care: AGC Tenwek Cardiothoracic Centre'
            : 'AGC Tenwek Cardiothoracic Centre'),
        'bannerKey' => $pageBannerKey ?? 'services',
    ])

    <section class="py-10 lg:py-12 scroll-mt-24" id="services-overview">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            @if($categoryLabel)
                <div class="max-w-4xl mb-6 rounded-2xl border border-ctc-blue/15 bg-ctc-blue/[0.04] px-4 py-3 sm:px-5 sm:py-4">
                    <p class="text-sm text-gray-700 leading-relaxed">
                        You are viewing <strong class="text-ctc-blue">{{ $categoryLabel }}</strong>.
                        <a href="{{ route('services') }}" class="font-semibold text-ctc-blue hover:underline">See all service areas</a>
                    </p>
                </div>
            @endif

            @if($categoryPage)
                @if($categoryPage->intro_kicker)
                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-ruby max-w-4xl">{{ $categoryPage->intro_kicker }}</p>
                @endif

                <article class="mt-6 w-full">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 xl:gap-12 items-start">

                        <!-- LEFT CONTENT -->
                        <div class="lg:col-span-7">
                            <div class="ctc-service-category-prose prose prose-slate max-w-none
                                        prose-headings:font-headline prose-headings:text-ctc-blue
                                        prose-p:text-gray-700
                                        prose-a:text-ctc-secondary prose-a:font-semibold
                                        prose-ul:text-gray-700 prose-li:marker:text-ctc-secondary">

                                {!! $categoryPage->body_html !!}

                            </div>
                        </div>

                        <!-- RIGHT IMAGE -->
                        <div class="lg:col-span-5">
                            @if($categoryPage->featuredImageUrl())

                                <figure class="rounded-2xl overflow-hidden border border-gray-200 shadow-md bg-ctc-grey-light">

                                    <div class="aspect-[4/3] lg:aspect-[3/4] w-full overflow-hidden" data-ctc-parallax="0.1">
                                        <img
                                            src="{{ $categoryPage->featuredImageUrl() }}"
                                            alt="{{ $categoryPage->intro_heading }}"
                                            class="h-full w-full object-cover scale-105"
                                            loading="lazy"
                                            decoding="async"
                                            width="800"
                                            height="600"
                                        >
                                    </div>

                                </figure>

                            @else

                                <x-service-category-hero-placeholder
                                    layout="column"
                                    :label="'Main image: ' . e($categoryPage->intro_heading)"
                                />

                            @endif
                        </div>

                    </div>
                </article>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 xl:gap-12 items-stretch">
                    <div class="lg:col-span-7">
                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-ruby">Clinical care</p>
                        <h2 class="mt-3 text-2xl sm:text-3xl font-headline font-extrabold tracking-tight text-ctc-blue">
                            Compassionate care, every step of the way
                        </h2>
                        <ul class="mt-6 space-y-4 text-gray-600 leading-relaxed">
                            <li class="flex items-start gap-3">
                                <span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-ctc-ruby shadow-[0_0_0_4px_rgba(179,49,39,0.18)]" aria-hidden="true"></span>
                                <span>
                                    At AGC Tenwek Cardiothoracic Centre, every service is delivered with one purpose: to provide safe, evidence-based, and compassionate care that restores health and transforms lives. From your first consultation to your final follow-up visit, we are committed to walking alongside you and your family with excellence, integrity, and hope.
                                </span>
                            </li>
                        </ul>

                        <h3 class="mt-10 text-xl sm:text-2xl font-headline font-extrabold tracking-tight text-ctc-blue">
                            Comprehensive cardiothoracic care
                        </h3>
                        <ul class="mt-6 space-y-4 text-gray-600 leading-relaxed">
                            <li class="flex items-start gap-3">
                                <span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-ctc-ruby shadow-[0_0_0_4px_rgba(179,49,39,0.18)]" aria-hidden="true"></span>
                                <span>
                                    At AGC Tenwek Cardiothoracic Centre, we provide comprehensive, specialized care for patients with heart, chest, and vascular conditions. Our multidisciplinary team combines clinical expertise, advanced technology, and compassionate, Christ-centered care to deliver exceptional outcomes for patients of all ages.
                                </span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-ctc-ruby shadow-[0_0_0_4px_rgba(179,49,39,0.18)]" aria-hidden="true"></span>
                                <span>
                                    Whether you require preventive heart care, advanced diagnostics, minimally invasive procedures, or complex surgery, we are committed to providing personalized treatment tailored to your unique needs.
                                </span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-ctc-ruby shadow-[0_0_0_4px_rgba(179,49,39,0.18)]" aria-hidden="true"></span>
                                <span>
                                    Our integrated approach ensures that every patient receives seamless care from diagnosis and treatment to recovery and long-term follow-up — all under one roof.
                                </span>
                            </li>
                        </ul>
                    </div>

                    <div class="lg:col-span-5">
                        <figure class="h-full min-h-[16rem] overflow-hidden rounded-2xl border border-gray-200 shadow-md bg-ctc-grey-light">
                            <div class="h-full w-full overflow-hidden" data-ctc-parallax="0.1">
                                <img
                                    src="{{ $servicesImageUrl }}"
                                    alt="Clinical care at AGC Tenwek Cardiothoracic Centre"
                                    class="h-full w-full object-cover object-center"
                                    loading="lazy"
                                    decoding="async"
                                    width="1200"
                                    height="750"
                                >
                            </div>
                        </figure>
                    </div>
                </div>
            @endif

            <div class="mt-10 sticky top-16 z-10">
                <div class="rounded-2xl border border-gray-200 bg-white/90 backdrop-blur-md shadow-sm px-3 py-3">
                    <nav class="flex flex-wrap gap-2" aria-label="Service categories" data-ctc-services-nav>
                        @php
                            $pill = 'px-4 py-2 rounded-xl text-[11px] font-bold uppercase tracking-[0.18em] transition-colors border';
                            $pillIdle = 'text-ctc-blue bg-ctc-grey-light hover:bg-white border-transparent hover:border-gray-200';
                            $pillOn = 'text-ctc-blue bg-white border-ctc-blue/35 shadow-sm';
                        @endphp
                        <a href="{{ route('services') }}#services-overview"
                           data-ctc-spy="services-overview"
                           class="{{ $pill }} {{ $activeServiceCategory === null ? $pillOn : $pillIdle }} ctc-services-pill">
                            All
                        </a>
                        <a href="{{ route('services.category', ['serviceCategory' => 'cardiac-surgery']) }}"
                           data-ctc-spy="cardiac_surgery"
                           class="{{ $pill }} {{ $activeServiceCategory === 'cardiac-surgery' ? $pillOn : $pillIdle }} ctc-services-pill">
                            Cardiac
                        </a>
                        <a href="{{ route('services.category', ['serviceCategory' => 'thoracic-surgery']) }}"
                           data-ctc-spy="thoracic_surgery"
                           class="{{ $pill }} {{ $activeServiceCategory === 'thoracic-surgery' ? $pillOn : $pillIdle }} ctc-services-pill">
                            Thoracic
                        </a>
                        <a href="{{ route('services.category', ['serviceCategory' => 'diagnostics']) }}"
                           data-ctc-spy="diagnostics"
                           class="{{ $pill }} {{ $activeServiceCategory === 'diagnostics' ? $pillOn : $pillIdle }} ctc-services-pill">
                            Diagnostics
                        </a>
                        <span class="ml-auto hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-xl text-[11px] font-bold uppercase tracking-[0.18em] text-white
                                     bg-[linear-gradient(135deg,rgba(26,26,104,0.95),rgba(98,163,161,0.92))]">
                            <span class="h-2 w-2 rounded-full bg-ctc-ruby shadow-[0_0_0_4px_rgba(179,49,39,0.22)]"></span>
                            Browse by area
                        </span>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    @if(!$activeCategory || $activeCategory === \App\Models\Service::CATEGORY_CARDIAC)
    <section class="py-16 lg:py-20 scroll-mt-24" id="cardiac_surgery">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <x-section-title title="Cardiac Surgery" subtitle="Surgical care for heart conditions in adults and children." />
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 auto-rows-fr" data-ctc-stagger="0.07">
                @foreach($cardiac as $service)
                    <x-service-card
                        :name="$service->name"
                        :description="$service->description"
                        :detailUrl="route('services.show', $service)"
                        :id="$service->slug"
                    />
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if(!$activeCategory || $activeCategory === \App\Models\Service::CATEGORY_THORACIC)
    <section class="py-16 lg:py-20 bg-ctc-grey-light scroll-mt-24" id="thoracic_surgery">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <x-section-title title="Thoracic Surgery" subtitle="Surgery for lung, chest wall, and mediastinal conditions." />
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 auto-rows-fr" data-ctc-stagger="0.07">
                @foreach($thoracic as $service)
                    <x-service-card
                        :name="$service->name"
                        :description="$service->description"
                        :detailUrl="route('services.show', $service)"
                        :id="$service->slug"
                    />
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if(!$activeCategory || $activeCategory === \App\Models\Service::CATEGORY_DIAGNOSTICS)
    <section class="py-16 lg:py-20 scroll-mt-24" id="diagnostics">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <x-section-title title="Diagnostics" subtitle="Imaging and testing for accurate diagnosis." />
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 auto-rows-fr" data-ctc-stagger="0.07">
                @foreach($diagnostics as $service)
                    <x-service-card
                        :name="$service->name"
                        :description="$service->description"
                        :detailUrl="route('services.show', $service)"
                        :id="$service->slug"
                    />
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endsection
