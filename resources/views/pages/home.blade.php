@extends('layouts.app')

@section('title', 'Home')

@php
    $metaDescription = 'Tenwek Hospital Cardiothoracic Centre (CTC) is a beacon of hope for patients with heart disease across Sub-Saharan Africa: life-saving surgery, training, and research.';
@endphp

@section('hero')
    @include('components.hero-section', [
        'title' => $heroTitle ?? 'AGC Tenwek Cardiothoracic Centre',
        'subtitle' => null,
        'description' => 'Healing Hearts ~ Transforming Lives',
        'mode' => $heroMode ?? 'image',
        'video' => $heroVideoUrl ?? null,
        'image' => $heroImageUrl ?? asset('hero.jpg'),
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
                        At AGC Tenwek Cardiothoracic Centre, we are dedicated to
                        delivering compassionate, high-quality healthcare to our
                        community and beyond. As a leading Cardiothoracic
                        Centre, we offer a wide range of specialized medical and
                        Surgical services, state-of-the-art facilities, and a team of
                        skilled professionals committed to excellence.
                    </p>
                    <p class="mt-4 text-gray-600 leading-relaxed">
                        Guided by our core values, we handle every patient with
                        dignity, respect, and personalized attention. Our mission is
                        not only to heal but also to bring hope and holistic wellness
                        to those we serve.
                    </p>
                    <p class="mt-4 text-gray-600 leading-relaxed">
                        We are more than a Cardiothoracic Centre, we are a
                        beacon of care, a hub of healing, and a trusted partner on
                        your journey to better health.
                    </p>
                </div>
                <div class="lg:col-span-5 h-full flex flex-col gap-4">
                    <div class="h-full rounded-2xl border border-gray-200 bg-white shadow-sm p-6">
                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-secondary">Visiting hours</p>
                        <dl class="mt-4 space-y-2 text-gray-700">
                            <div class="flex items-center justify-between gap-4"><dt class="text-sm">Morning</dt><dd class="text-sm font-semibold text-ctc-blue">6:00 – 7:00 am</dd></div>
                            <div class="flex items-center justify-between gap-4"><dt class="text-sm">Lunch</dt><dd class="text-sm font-semibold text-ctc-blue">1:00 – 2:00 pm</dd></div>
                            <div class="flex items-center justify-between gap-4"><dt class="text-sm">Evening</dt><dd class="text-sm font-semibold text-ctc-blue">4:00 – 5:00 pm</dd></div>
                        </dl>
                    </div>
                    <div class="h-full rounded-2xl border border-gray-200 bg-white shadow-sm p-6">
                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-secondary">Talk to us</p>
                        <ul class="mt-4 space-y-2.5">
                            <li>
                                <a href="tel:+254723000036"
                                   class="group flex items-center gap-3 rounded-xl border border-transparent px-2.5 py-2.5 -mx-2.5 transition-colors hover:border-ctc-secondary/25 hover:bg-ctc-grey-light/70 focus:outline-none focus-visible:ring-2 focus-visible:ring-ctc-blue focus-visible:ring-offset-2">
                                    <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-ctc-secondary/12 text-ctc-blue ring-1 ring-ctc-secondary/20" aria-hidden="true">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                        </svg>
                                    </span>
                                    <span class="min-w-0">
                                        <span class="block text-[11px] font-semibold uppercase tracking-[0.14em] text-gray-400">Phone</span>
                                        <span class="mt-0.5 block text-sm font-semibold text-ctc-blue transition-colors group-hover:text-ctc-ruby">0723 000036</span>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="mailto:ctc.info@tenwekhosp.org"
                                   class="group flex items-center gap-3 rounded-xl border border-transparent px-2.5 py-2.5 -mx-2.5 transition-colors hover:border-ctc-secondary/25 hover:bg-ctc-grey-light/70 focus:outline-none focus-visible:ring-2 focus-visible:ring-ctc-blue focus-visible:ring-offset-2">
                                    <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-ctc-secondary/12 text-ctc-blue ring-1 ring-ctc-secondary/20" aria-hidden="true">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                        </svg>
                                    </span>
                                    <span class="min-w-0">
                                        <span class="block text-[11px] font-semibold uppercase tracking-[0.14em] text-gray-400">Email</span>
                                        <span class="mt-0.5 block break-all text-sm font-semibold text-ctc-blue transition-colors group-hover:text-ctc-ruby">ctc.info@tenwekhosp.org</span>
                                    </span>
                                </a>
                            </li>
                            <li class="flex items-start gap-3 px-2.5 py-2.5 -mx-2.5">
                                <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-ctc-secondary/12 text-ctc-blue ring-1 ring-ctc-secondary/20" aria-hidden="true">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                </span>
                                <span class="min-w-0 pt-0.5">
                                    <span class="block text-[11px] font-semibold uppercase tracking-[0.14em] text-gray-400">Visit</span>
                                    <span class="mt-0.5 block text-sm font-semibold text-ctc-blue">Bomet County, Kenya</span>
                                    <span class="mt-0.5 block text-xs text-gray-500">P.O Box 39-20400 Bomet</span>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Services preview --}}
    <section class="py-16 lg:py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <x-section-title title="Our Services" subtitle="Comprehensive cardiothoracic care for adults and children." :magentaAccent="true" />
            <div class="grid gap-8 lg:grid-cols-12 lg:gap-10 items-stretch">
                @if(!empty($servicesImageUrl))
                    <div class="lg:col-span-4 lg:order-2">
                        <div class="h-full min-h-[22rem] overflow-hidden rounded-[1.25rem] border border-gray-200 bg-white shadow-sm">
                            <div class="relative h-full bg-ctc-grey-light">
                                <img src="{{ $servicesImageUrl }}" alt="Our services" class="h-full w-full object-cover">

                                <div class="absolute inset-x-0 bottom-0 p-4 sm:p-5">
                                    <a href="{{ route('services') }}"
                                       class="group inline-flex w-full items-center justify-center gap-2 rounded-none px-5 py-3.5 font-headline font-bold uppercase text-[0.62rem] tracking-[0.18em] text-white shadow-[0_18px_45px_rgba(0,0,0,0.35)] transition-all
                                              bg-[linear-gradient(135deg,rgba(26,26,104,0.95),rgba(98,163,161,0.92))]
                                              hover:brightness-105">
                                        <span class="inline-flex items-center gap-2">
                                            <span>View all services</span>
                                            <span class="h-2 w-2 rounded-full bg-ctc-ruby shadow-[0_0_0_4px_rgba(179,49,39,0.22)]" aria-hidden="true"></span>
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
                    <div class="h-full border border-gray-200 bg-white" data-ctc-stagger="0.05">
                        <ul class="grid sm:grid-cols-2 sm:divide-x sm:divide-gray-100">
                            @foreach($services as $service)
                                @php
                                    $excerpt = $service->description
                                        ? \Illuminate\Support\Str::limit(trim(strip_tags($service->description)), 78)
                                        : null;
                                    $href = route('services.show', $service);
                                @endphp
                                <li class="border-b border-gray-100">
                                    <a href="{{ $href }}"
                                       class="group relative flex h-full items-start gap-3.5 px-4 py-4 sm:gap-4 sm:px-5 sm:py-5 transition-colors duration-300 hover:bg-[#fffaf9] focus:outline-none focus-visible:bg-[#fffaf9] focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-ctc-ruby/40">
                                        <span class="pointer-events-none absolute inset-y-0 left-0 w-0 bg-ctc-ruby transition-all duration-300 group-hover:w-1" aria-hidden="true"></span>

                                        <span class="mt-0.5 inline-flex h-8 w-8 shrink-0 items-center justify-center border border-ctc-ruby/25 bg-ctc-ruby/10 font-headline text-[0.7rem] font-bold tabular-nums tracking-wide text-ctc-ruby transition-colors duration-300 group-hover:border-ctc-ruby/50 group-hover:bg-ctc-ruby group-hover:text-white">
                                            {{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                        </span>

                                        <span class="min-w-0 flex-1">
                                            <span class="flex items-start justify-between gap-3">
                                                <span class="font-headline text-[0.95rem] font-bold leading-snug tracking-tight text-ctc-blue transition-colors duration-300 group-hover:text-ctc-ruby sm:text-[1rem]">
                                                    {{ $service->name }}
                                                </span>
                                                <svg class="mt-0.5 h-4 w-4 shrink-0 text-ctc-ruby/45 transition-all duration-300 group-hover:translate-x-0.5 group-hover:text-ctc-ruby" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                                </svg>
                                            </span>
                                            @if($excerpt)
                                                <span class="mt-1.5 block text-sm leading-relaxed text-gray-600">
                                                    {{ $excerpt }}
                                                </span>
                                            @endif
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Team preview --}}
    <section class="py-16 lg:py-20 bg-ctc-grey-light">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-10 lg:mb-12 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div class="min-w-0 max-w-2xl">
                    <h2 class="font-headline text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-ctc-blue" data-ctc-split="lines">Our Team</h2>
                    <p class="mt-3 text-[0.95rem] leading-relaxed text-gray-600" data-ctc-reveal="fade-up" data-ctc-reveal-delay="0.08">
                        A multidisciplinary care team committed to excellence in heart and chest care.
                    </p>
                </div>
                <a href="{{ route('specialists') }}"
                   class="inline-flex shrink-0 items-center gap-2 self-start sm:mt-1 px-5 py-2.5 rounded-none text-sm font-medium bg-ctc-blue text-white ring-1 ring-ctc-magenta/25 ring-offset-2 ring-offset-ctc-grey-light hover:bg-ctc-blue-dark hover:ring-ctc-magenta/45 transition-all">
                    View more
                    <svg class="h-4 w-4 opacity-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6" data-ctc-stagger="0.09">
                @foreach($team as $member)
                    <x-team-card
                        :name="$member->name"
                        :credentials="$member->credentials"
                        :title="$member->title"
                        :groupLabel="$member->team_group_label"
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
                <article class="group relative flex h-full flex-col overflow-hidden border border-gray-200 bg-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="absolute inset-x-0 top-0 h-1 bg-ctc-accent" aria-hidden="true"></div>
                    <div class="flex flex-1 flex-col p-6 pt-7 sm:p-7">
                        <div class="flex items-start justify-between gap-4">
                            <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-accent">Job creation</p>
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center bg-ctc-accent/15 text-ctc-blue ring-1 ring-ctc-accent/25" aria-hidden="true">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                </svg>
                            </span>
                        </div>
                        <div class="mt-5 border-b border-gray-100 pb-5">
                            <p class="font-headline text-3xl font-extrabold tracking-tight text-ctc-blue sm:text-[2rem]">300+</p>
                            <p class="mt-1 text-xs font-semibold uppercase tracking-[0.16em] text-gray-400">Kenyan staff</p>
                        </div>
                        <h3 class="mt-5 font-headline text-lg font-extrabold tracking-tight text-ctc-blue">A major regional employer</h3>
                        <p class="mt-3 flex-1 text-sm leading-relaxed text-gray-600">
                            With over 300 tax-paying Kenyan staff members, the centre contributes significantly to local livelihoods and the regional economy.
                        </p>
                        <div class="mt-6 flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.16em] text-gray-400 transition group-hover:text-ctc-ruby">
                            <span>Regional impact</span>
                            <span class="h-px flex-1 bg-gray-200 transition group-hover:bg-ctc-ruby/30" aria-hidden="true"></span>
                        </div>
                    </div>
                </article>

                <article class="group relative flex h-full flex-col overflow-hidden border border-gray-200 bg-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="absolute inset-x-0 top-0 h-1 bg-ctc-magenta" aria-hidden="true"></div>
                    <div class="flex flex-1 flex-col p-6 pt-7 sm:p-7">
                        <div class="flex items-start justify-between gap-4">
                            <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-magenta">Training hub</p>
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center bg-ctc-magenta/10 text-ctc-magenta ring-1 ring-ctc-magenta/20" aria-hidden="true">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.908.14-1.783.414-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                                </svg>
                            </span>
                        </div>
                        <div class="mt-5 border-b border-gray-100 pb-5">
                            <p class="font-headline text-3xl font-extrabold tracking-tight text-ctc-blue sm:text-[2rem]">Africa</p>
                            <p class="mt-1 text-xs font-semibold uppercase tracking-[0.16em] text-gray-400">wide reach</p>
                        </div>
                        <h3 class="mt-5 font-headline text-lg font-extrabold tracking-tight text-ctc-blue">Building clinical capacity</h3>
                        <p class="mt-3 flex-1 text-sm leading-relaxed text-gray-600">
                            Advanced training attracts healthcare professionals and strengthens sustainable cardiothoracic care across the continent.
                        </p>
                        <div class="mt-6 flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.16em] text-gray-400 transition group-hover:text-ctc-ruby">
                            <span>Regional impact</span>
                            <span class="h-px flex-1 bg-gray-200 transition group-hover:bg-ctc-ruby/30" aria-hidden="true"></span>
                        </div>
                    </div>
                </article>

                <article class="group relative flex h-full flex-col overflow-hidden border border-gray-200 bg-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="absolute inset-x-0 top-0 h-1 bg-ctc-secondary" aria-hidden="true"></div>
                    <div class="flex flex-1 flex-col p-6 pt-7 sm:p-7">
                        <div class="flex items-start justify-between gap-4">
                            <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-secondary">Medical tourism</p>
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center bg-ctc-secondary/12 text-ctc-blue ring-1 ring-ctc-secondary/25" aria-hidden="true">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                </svg>
                            </span>
                        </div>
                        <div class="mt-5 border-b border-gray-100 pb-5">
                            <p class="font-headline text-3xl font-extrabold tracking-tight text-ctc-blue sm:text-[2rem]">Cross-border</p>
                            <p class="mt-1 text-xs font-semibold uppercase tracking-[0.16em] text-gray-400">patient care</p>
                        </div>
                        <h3 class="mt-5 font-headline text-lg font-extrabold tracking-tight text-ctc-blue">Trusted beyond Kenya</h3>
                        <p class="mt-3 flex-1 text-sm leading-relaxed text-gray-600">
                            High-quality cardiac care at a fraction of international costs draws patients from Kenya and neighbouring countries.
                        </p>
                        <div class="mt-6 flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.16em] text-gray-400 transition group-hover:text-ctc-ruby">
                            <span>Regional impact</span>
                            <span class="h-px flex-1 bg-gray-200 transition group-hover:bg-ctc-ruby/30" aria-hidden="true"></span>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    {{-- CTA Support --}}
    <x-cta-section
        title="Support the CTC"
        badgeLeft="Support"
        badgeRight="the CTC"
        headline="Help expand life-saving heart care across Africa"
        description="Your donation helps us provide surgery to those who cannot afford it and train more surgeons for Africa."
        buttonLabel="Ways to give"
        :buttonUrl="route('support')"
        secondaryLabel="Contact us"
        :secondaryUrl="route('contact')"
        :image="$supportCtaImageUrl"
        imageAlt="Supporting care at AGC Tenwek Cardiothoracic Centre"
        :points="[
            ['title' => 'Sponsor a surgery', 'text' => 'Fund life-saving procedures for patients who cannot pay.'],
            ['title' => 'Equip the Centre', 'text' => 'Help supply instruments, monitors, and critical tools.'],
            ['title' => 'Train clinicians', 'text' => 'Strengthen capacity building for heart care across Africa.'],
            ['title' => 'Partner with us', 'text' => 'Join hospitals, universities, and NGOs in the mission.'],
        ]"
    />

    {{-- Latest news --}}
    <section class="py-16 lg:py-20 bg-ctc-grey-light">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-10 lg:mb-12 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div class="min-w-0 max-w-2xl">
                    <h2 class="font-headline text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-ctc-blue" data-ctc-split="lines">Latest News</h2>
                    <p class="mt-3 text-[0.95rem] leading-relaxed text-gray-600" data-ctc-reveal="fade-up" data-ctc-reveal-delay="0.08">
                        Updates, events, and announcements from the CTC.
                    </p>
                </div>
                <a href="{{ route('news') }}"
                   class="inline-flex shrink-0 items-center gap-2 self-start sm:mt-1 px-5 py-2.5 rounded-none text-sm font-medium bg-ctc-blue text-white ring-1 ring-ctc-magenta/25 ring-offset-2 ring-offset-ctc-grey-light hover:bg-ctc-blue-dark hover:ring-ctc-magenta/45 transition-all">
                    View all news
                    <svg class="h-4 w-4 opacity-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>
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
        </div>
    </section>
@endsection
