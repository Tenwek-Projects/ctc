@extends('layouts.app')

@section('title', $pageTitle)

@php
    $canonicalUrl = route('departments.show', $department, true);
    $specialtyName = $department->intro_heading;
@endphp

@push('head')
    <link rel="canonical" href="{{ $canonicalUrl }}">
    @php
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'MedicalWebPage',
            'name' => \App\Support\Seo\Seo::brandTitle($pageTitle),
            'description' => $metaDescription,
            'url' => $canonicalUrl,
            'about' => [
                '@type' => 'MedicalSpecialty',
                'name' => $specialtyName,
            ],
            'isPartOf' => [
                '@type' => 'MedicalOrganization',
                'name' => config('ctc.name'),
                'parentOrganization' => [
                    '@type' => 'Hospital',
                    'name' => config('ctc.hospital'),
                    'address' => config('ctc.contact.address'),
                ],
            ],
            'specialty' => $specialtyName,
        ];
        if ($department->featuredImageUrl()) {
            $jsonLd['primaryImageOfPage'] = [
                '@type' => 'ImageObject',
                'url' => $department->featuredImageUrl(),
            ];
        }
    @endphp
    <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
    @include('components.page-banner', [
        'title' => $department->intro_heading,
        'subtitle' => $department->intro_subheading ?: config('ctc.name'),
        'bannerKey' => 'department_'.$department->url_segment,
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Services', 'url' => route('services')],
            ['label' => $department->intro_heading, 'url' => $canonicalUrl],
        ],
    ])

    <section class="py-10 lg:py-14">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <article class="w-full">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 xl:gap-12 items-start">
                    <div class="lg:col-span-7">
                        @if($department->intro_kicker)
                            <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-ruby">{{ $department->intro_kicker }}</p>
                        @endif

                        <div class="mt-5 ctc-service-category-prose prose prose-slate max-w-none text-[1.05rem]
                                    prose-headings:font-headline prose-headings:text-ctc-blue
                                    prose-p:text-gray-700 prose-p:leading-relaxed
                                    prose-a:text-ctc-secondary prose-a:font-semibold
                                    prose-strong:text-ctc-blue prose-strong:font-semibold
                                    prose-ul:text-gray-700 prose-ol:text-gray-700
                                    prose-li:marker:text-ctc-secondary">
                            {!! $department->body_html !!}
                        </div>

                        <div class="mt-10 flex flex-wrap gap-3">
                            <a href="{{ route('book-appointment') }}"
                               class="inline-flex items-center justify-center gap-2 rounded-xl bg-ctc-blue px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-ctc-blue-dark">
                                Book appointment
                            </a>
                            <a href="{{ route('contact') }}"
                               class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-ctc-blue transition hover:bg-ctc-grey-light">
                                Contact us
                            </a>
                        </div>
                    </div>

                    <div class="lg:col-span-5 lg:sticky lg:top-28 space-y-5">
                        <figure class="overflow-hidden rounded-2xl border border-gray-200 shadow-md bg-ctc-grey-light">
                            <div class="aspect-[4/3] lg:aspect-[3/4] w-full overflow-hidden" data-ctc-parallax="0.1">
                                <img
                                    src="{{ $department->featuredImageUrl() ?: (\App\Support\SiteImage::urlFor('placeholder_facility') ?: config('ctc.placeholder_images.facility')) }}"
                                    alt="{{ $department->intro_heading }} at {{ config('ctc.name') }}"
                                    class="h-full w-full object-cover scale-105"
                                    loading="lazy"
                                    decoding="async"
                                    width="800"
                                    height="1000"
                                >
                            </div>
                        </figure>

                        @if($relatedServices->isNotEmpty())
                            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                                <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-ctc-blue">Related services</p>
                                <ul class="mt-3 divide-y divide-gray-100">
                                    @foreach($relatedServices as $service)
                                        <li>
                                            <a href="{{ route('services.show', $service) }}"
                                               class="group flex items-center justify-between gap-3 py-3 text-sm font-semibold text-ctc-blue hover:text-ctc-secondary">
                                                <span>{{ $service->name }}</span>
                                                <svg class="h-4 w-4 shrink-0 opacity-60 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                                </svg>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="rounded-2xl border border-ctc-blue/15 bg-ctc-blue/[0.04] p-5">
                            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-ctc-blue">Need care?</p>
                            <p class="mt-2 text-sm text-gray-700 leading-relaxed">
                                {{ $referralBlurb }}
                            </p>
                            <a href="{{ route('patient-information') }}" class="mt-3 inline-flex text-sm font-semibold text-ctc-secondary hover:underline">
                                Patient information →
                            </a>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
@endsection
