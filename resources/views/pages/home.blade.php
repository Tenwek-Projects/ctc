@extends('layouts.app')

@section('title', 'Home')

@php($metaDescription = 'Tenwek Hospital Cardiothoracic Centre (CTC) is a beacon of hope for patients with heart disease across Sub‑Saharan Africa: life‑saving surgery, training, and research.')

@section('hero')
    @include('components.hero-section', [
        'title' => $heroTitle ?? 'Cardiothoracic Centre',
        'subtitle' => $heroSubtitle ?? 'Tenwek Hospital',
        'description' => $heroDescription ?? 'A beacon of hope and healing for patients with heart disease across Sub‑Saharan Africa. We provide life‑saving open‑heart and thoracic care, and train African healthcare professionals to expand access to treatment.',
        'mode' => $heroMode ?? 'video',
        'video' => $heroVideoUrl ?? null,
        'slides' => $heroSlides ?? collect(),
        'buttons' => [
            ['label' => 'Book appointment', 'url' => route('book-appointment'), 'primary' => true],
            ['label' => 'Refer a Patient', 'url' => route('patient-information'), 'primary' => false],
        ],
    ])
@endsection

@section('content')
    {{-- Stats: below nav, light background --}}
    <section class="scroll-mt-20 py-16 bg-ctc-grey-light" id="home-stats">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 max-w-5xl mx-auto" data-ctc-stagger="0.07">
                @foreach($stats as $stat)
                    <div @class([
                        'text-center p-6 lg:p-8 rounded-xl bg-white border border-gray-200 shadow-sm',
                        'border-t-2 border-t-ctc-magenta' => $loop->first,
                    ])>
                        <p class="ctc-stat-value text-3xl sm:text-4xl lg:text-5xl font-bold text-ctc-blue">{{ $stat['value'] }}</p>
                        <p class="mt-2 text-sm font-medium text-gray-600">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-10 max-w-5xl mx-auto grid gap-6 lg:grid-cols-12 items-stretch" data-ctc-stagger="0.1">
                <div class="lg:col-span-7 h-full rounded-2xl bg-white border border-gray-200 shadow-sm p-6 sm:p-8 flex flex-col">
                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-magenta">A History of Excellence</p>
                    <h2 class="mt-3 text-2xl sm:text-3xl font-headline font-extrabold tracking-tight text-ctc-blue">
                        Built to expand access to advanced cardiac care in Africa
                    </h2>
                    <p class="mt-4 text-gray-600 leading-relaxed">
                        The Cardiothoracic Centre at Tenwek Hospital was established through the vision of the Hospital’s Board and Management
                        to construct a specialised facility dedicated to cardiothoracic care, addressing the pressing need for advanced cardiac treatment
                        in Kenya and across the continent.
                    </p>
                </div>
                <div class="lg:col-span-5 h-full flex flex-col gap-4">
                    <div class="h-full rounded-2xl border border-gray-200 bg-white shadow-sm p-6">
                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-secondary">Visiting hours</p>
                        <dl class="mt-4 space-y-2 text-gray-700">
                            <div class="flex items-center justify-between gap-4"><dt class="text-sm">Morning</dt><dd class="text-sm font-semibold text-ctc-blue">6:00 – 6:45 am</dd></div>
                            <div class="flex items-center justify-between gap-4"><dt class="text-sm">Lunch</dt><dd class="text-sm font-semibold text-ctc-blue">1:00 – 2:00 pm</dd></div>
                            <div class="flex items-center justify-between gap-4"><dt class="text-sm">Evening</dt><dd class="text-sm font-semibold text-ctc-blue">4:00 – 5:00 pm</dd></div>
                        </dl>
                    </div>
                    <div class="h-full rounded-2xl border border-gray-200 bg-white shadow-sm p-6">
                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-secondary">Talk to us</p>
                        <p class="mt-3 text-sm text-gray-600">
                            <a class="font-semibold text-ctc-blue hover:text-ctc-ruby hover:underline transition-colors" href="tel:+254728091900">+254 728 091 900</a>
                            <span class="text-gray-400">•</span>
                            <a class="font-semibold text-ctc-blue hover:text-ctc-ruby hover:underline transition-colors" href="mailto:customer.experience@tenwekhosp.org">customer.experience@tenwekhosp.org</a>
                        </p>
                        <p class="mt-2 text-sm text-gray-600">
                            Visit: <span class="font-medium text-gray-800">Bomet County, Kenya</span> • <span class="font-medium text-gray-800">P.O Box 39-20400 Bomet</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Services preview --}}
    <section class="py-16 lg:py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <x-section-title title="Our Services" subtitle="Comprehensive cardiothoracic care for adults and children." :magentaAccent="true" />
            <div class="grid gap-8 lg:grid-cols-12 items-stretch">
                @if(!empty($servicesImageUrl))
                    <div class="lg:col-span-4 lg:order-2">
                        <div class="h-full overflow-hidden rounded-[1.25rem] border border-gray-200 bg-white shadow-sm">
                            <div class="relative h-full bg-ctc-grey-light">
                                <img src="{{ $servicesImageUrl }}" alt="Our services" class="h-full w-full object-cover">

                                <div class="absolute inset-x-0 bottom-0 p-4 sm:p-5">
                                    <a href="{{ route('services') }}"
                                       class="group inline-flex w-full items-center justify-center gap-2 rounded-xl px-5 py-3.5 font-headline font-bold uppercase text-[0.62rem] tracking-[0.18em] text-white shadow-[0_18px_45px_rgba(0,0,0,0.35)] transition-all
                                              bg-[linear-gradient(135deg,rgba(26,26,104,0.95),rgba(98,163,161,0.92))]
                                              hover:brightness-105">
                                        <span class="inline-flex items-center gap-2">
                                            <span>View all services</span>
                                            <span class="flex items-center gap-1" aria-hidden="true">
                                                <span class="h-2 w-2 rounded-full bg-ctc-accent shadow-[0_0_0_4px_rgba(228,195,115,0.22)]"></span>
                                                <span class="h-1.5 w-1.5 rounded-full bg-ctc-magenta opacity-95"></span>
                                            </span>
                                        </span>
                                        <svg class="w-4 h-4 opacity-90 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="{{ !empty($servicesImageUrl) ? 'lg:col-span-8' : 'lg:col-span-12' }}">
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 auto-rows-fr h-full" data-ctc-stagger="0.08">
                        @foreach($services as $service)
                            <x-service-card
                                :name="$service->name"
                                :description="$service->description"
                                :url="route('services') . '#' . $service->slug"
                                :detailUrl="route('services.show', $service)"
                                :magentaLine="$loop->first"
                            />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Team preview --}}
    <section class="py-16 lg:py-20 bg-ctc-grey-light">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <x-section-title title="Our Team" subtitle="Dedicated surgeons and specialists committed to excellence." />
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6" data-ctc-stagger="0.09">
                @foreach($team as $member)
                    <x-team-card
                        :name="$member->name"
                        :title="$member->title"
                        :specialization="$member->specialization"
                        :bio="$member->bio"
                        :photo="$member->photo"
                        :url="route('specialists.show', $member)"
                    />
                @endforeach
            </div>
        </div>
    </section>

    {{-- Impact: content over grayscale Africa map background (right), rays from Bomet --}}
    <section class="relative overflow-hidden bg-white py-16 lg:py-20">
        <p class="sr-only">Decorative background: map of Africa with paths from Bomet, Kenya suggesting regional and global reach.</p>
        <div class="pointer-events-none absolute inset-0 z-0 select-none" aria-hidden="true">
            <div class="absolute inset-0 bg-gradient-to-r from-white via-white/92 to-white/55 lg:via-white/78 lg:to-transparent"></div>
            <div class="ctc-impact-map-bg absolute top-1/2 right-0 h-[min(118vw,620px)] w-[min(118vw,720px)] max-w-[200%] -translate-y-1/2 translate-x-[4%] sm:h-[min(95vw,580px)] sm:w-[min(95vw,680px)] sm:translate-x-[6%] lg:h-[min(72vw,640px)] lg:w-[min(72vw,760px)] lg:-translate-y-[48%] lg:translate-x-[2%]">
                <x-home-impact-africa-map class="h-full w-full max-w-none" />
            </div>
        </div>

        <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8">
            <x-section-title title="Our Impact in Africa" subtitle="The CTC is a regional leader in cardiothoracic surgery and training." />

            <div class="mt-8 max-w-3xl prose prose-lg text-gray-600">
                <p>
                    The Cardiothoracic Centre is a leading centre for life‑saving open‑heart surgical procedures in the region.
                    Beyond direct care, we serve as a training hub for African healthcare workers in prevention and management of heart disease,
                    equipping professionals through accredited programmes and partnerships.
                </p>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-3 auto-rows-fr lg:mt-12" data-ctc-stagger="0.1">
                <div class="h-full rounded-2xl bg-white border border-gray-200 shadow-sm p-6 flex flex-col">
                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-accent">Job creation</p>
                    <p class="mt-3 text-gray-700 text-sm leading-relaxed">With over <span class="font-semibold text-ctc-blue">300</span> tax‑paying Kenyan staff members, the centre contributes significantly as a regional employer.</p>
                </div>
                <div class="h-full rounded-2xl bg-white border border-gray-200 shadow-sm p-6 flex flex-col">
                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-magenta">Training hub</p>
                    <p class="mt-3 text-gray-700 text-sm leading-relaxed">Advanced training attracts healthcare professionals and strengthens sustainable cardiothoracic care across Africa.</p>
                </div>
                <div class="h-full rounded-2xl bg-white border border-gray-200 shadow-sm p-6 flex flex-col">
                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-accent">Medical tourism</p>
                    <p class="mt-3 text-gray-700 text-sm leading-relaxed">High‑quality cardiac care at a fraction of international costs draws patients from Kenya and beyond.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Support --}}
    <x-cta-section
        title="Support the CTC"
        description="Your donation helps us provide surgery to those who cannot afford it and train more surgeons for Africa."
        buttonLabel="Ways to give"
        :buttonUrl="route('support')"
    />

    {{-- Latest news --}}
    <section class="py-16 lg:py-20 bg-ctc-grey-light">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <x-section-title title="Latest News" subtitle="Updates, events, and announcements from the CTC." />
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6" data-ctc-stagger="0.08">
                @foreach($news as $article)
                    <x-news-card
                        :title="$article->title"
                        :excerpt="$article->excerpt"
                        :type="$article->type"
                        :date="$article->published_at"
                        :image="$article->featured_image"
                        :url="route('news.show', $article->slug)"
                    />
                @endforeach
            </div>
            <div class="mt-10 text-center">
                <a href="{{ route('news') }}" class="inline-flex items-center px-6 py-3 rounded-lg font-medium bg-ctc-blue text-white ring-1 ring-ctc-magenta/25 ring-offset-2 ring-offset-ctc-grey-light hover:bg-ctc-blue-dark hover:ring-ctc-magenta/45 transition-all">
                    View all news
                </a>
            </div>
        </div>
    </section>
@endsection
