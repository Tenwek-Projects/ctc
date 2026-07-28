@extends('layouts.app')

@section('title', 'History')

@section('content')
    @include('components.page-banner', [
        'bannerKey' => 'history',
        'title' => 'History',
        'subtitle' => config('ctc.name'),
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'History', 'url' => route('history')],
        ],
    ])

    <section class="py-16 lg:py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-12 items-start">
                <div class="lg:col-span-5">
                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-accent">A history of excellence</p>
                    <h2 class="mt-3 text-2xl sm:text-3xl font-headline font-extrabold tracking-tight text-ctc-blue">
                        Milestones that shaped the Cardiothoracic Centre
                    </h2>
                    <p class="mt-4 text-gray-600 leading-relaxed">
                        Explore key moments in the growth of the CTC, from early vision and facility development to training and regional impact.
                    </p>
                    <div class="mt-8 rounded-2xl border border-gray-200 bg-ctc-grey-light p-6">
                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-secondary">Want to refer a patient?</p>
                        <p class="mt-3 text-sm text-gray-600">We’ll guide you on records, next steps, and appointment planning.</p>
                        <a href="{{ route('patient-information') }}" class="mt-5 inline-flex items-center rounded-xl bg-ctc-blue px-5 py-3 text-[11px] font-bold uppercase tracking-[0.18em] text-white hover:bg-ctc-blue-dark transition-colors">
                            Patient information
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-7">
                    <div class="rounded-2xl bg-white border border-gray-200 shadow-sm p-6 sm:p-8">
                        <div class="relative" data-ctc-timeline>
                            <span class="absolute left-[0.65rem] top-3 bottom-3 w-px rounded-full bg-gray-200" aria-hidden="true"></span>
                            <span
                                class="absolute left-[0.65rem] top-3 bottom-3 w-px origin-top rounded-full bg-gradient-to-b from-ctc-accent via-ctc-secondary to-ctc-accent/30"
                                data-ctc-timeline-progress
                                aria-hidden="true"
                            ></span>
                            <ol class="relative m-0 list-none space-y-8" data-ctc-stagger="0.12">
                            @forelse($milestones as $m)
                                <li class="relative">
                                    <span class="absolute left-[0.65rem] top-1.5 z-[1] h-4 w-4 -translate-x-1/2 rounded-full bg-ctc-accent shadow-[0_0_0_6px_rgba(179,49,39,0.12)]"></span>
                                    <div class="pl-10 sm:pl-11 flex flex-wrap items-baseline gap-3">
                                        @if($m->year)
                                            <span class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-secondary">{{ $m->year }}</span>
                                        @endif
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $m->title }}</h3>
                                    </div>
                                    @if($m->description)
                                        <div class="mt-2 w-full pl-10 sm:pl-11 prose prose-sm max-w-none text-gray-600 prose-p:my-1 prose-headings:font-headline prose-headings:text-ctc-blue prose-a:text-ctc-secondary">
                                            {!! $m->description !!}
                                        </div>
                                    @endif
                                </li>
                            @empty
                                <li class="pl-10 text-gray-600">Milestones will appear here once added in the admin panel.</li>
                            @endforelse
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-14 lg:mt-16">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-secondary">History gallery</p>
                        <h3 class="mt-2 text-2xl sm:text-3xl font-headline font-extrabold tracking-tight text-ctc-blue">
                            Moments from the CTC journey
                        </h3>
                    </div>
                    @if($galleryItems->isNotEmpty())
                        <p class="text-sm text-gray-600">Snapshots of milestones, teams, and growth over time.</p>
                    @endif
                </div>

                @if($galleryItems->isNotEmpty())
                    <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3" data-ctc-stagger="0.08">
                        @foreach($galleryItems as $item)
                            <article class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                                <div class="aspect-[4/3] overflow-hidden bg-gray-100">
                                    <img
                                        src="{{ $item->imageUrl() }}"
                                        alt="{{ $item->title }}"
                                        class="h-full w-full object-cover transition-transform duration-500 hover:scale-[1.03]"
                                        loading="lazy"
                                        decoding="async"
                                    >
                                </div>
                                <div class="p-5">
                                    <h4 class="text-base font-semibold text-ctc-blue">{{ $item->title }}</h4>
                                    @if($item->caption)
                                        <div class="mt-2 prose prose-sm max-w-none text-gray-600 prose-p:my-1 prose-a:text-ctc-secondary prose-strong:text-ctc-blue">
                                            {!! \App\Support\TrixHtmlSanitizer::normalizeBlocksForDisplay($item->caption) !!}
                                        </div>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="mt-8 rounded-2xl border border-dashed border-gray-300 bg-ctc-grey-light px-6 py-8 text-sm text-gray-600">
                        History gallery images will appear here once added in the admin panel.
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

