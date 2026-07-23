@extends('layouts.app')

@section('title', 'Our Impact')

@section('content')
    @include('components.page-banner', [
        'title' => 'Our Impact',
        'subtitle' => config('ctc.name'),
        'bannerKey' => 'impact',
    ])

    @if($featuredStory || $testimonials->isNotEmpty())
        <section class="py-14 lg:py-20 bg-white border-b border-gray-200/80">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mb-10">
                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-accent">Success stories</p>
                    <h2 class="mt-3 text-2xl sm:text-3xl font-headline font-extrabold tracking-tight text-ctc-blue">
                        Voices of hope and recovery
                    </h2>
                    <p class="mt-3 text-gray-600 leading-relaxed">
                        A featured patient journey alongside words from families, patients, and partners, updated from the admin panel.
                    </p>
                </div>

                <div class="grid gap-10 lg:grid-cols-12 lg:gap-12 items-stretch">
                    {{-- Featured story --}}
                    <div class="{{ $testimonials->isNotEmpty() ? 'lg:col-span-7' : 'lg:col-span-12' }}">
                        @if($featuredStory)
                            <div class="h-full rounded-3xl border border-gray-200 bg-white shadow-sm overflow-hidden flex flex-col">
                                @if($featuredStory->media_url)
                                    <div class="aspect-video bg-black shrink-0">
                                        <iframe
                                            src="{{ $featuredStory->media_url }}"
                                            class="h-full w-full"
                                            title="{{ $featuredStory->title }}"
                                            loading="lazy"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen
                                        ></iframe>
                                    </div>
                                @else
                                    <div class="aspect-[16/10] bg-ctc-grey-light shrink-0">
                                        <img
                                            src="{{ $featuredStory->image_url ?: config('ctc.page_banner_image') }}"
                                            alt="{{ $featuredStory->title }}"
                                            class="h-full w-full object-cover"
                                            loading="lazy"
                                        >
                                    </div>
                                @endif
                                <div class="p-6 sm:p-8 flex-1 flex flex-col">
                                    <div class="flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.18em] text-ctc-secondary">
                                        <span class="h-2 w-2 rounded-full bg-ctc-accent shadow-[0_0_0_4px_rgba(179,49,39,0.18)]"></span>
                                        Featured story
                                        @if($featuredStory->story_date)
                                            <span class="text-gray-400 font-medium normal-case tracking-normal">· {{ $featuredStory->story_date->format('F Y') }}</span>
                                        @endif
                                    </div>
                                    <h3 class="mt-3 text-xl sm:text-2xl font-headline font-extrabold text-ctc-blue">{{ $featuredStory->title }}</h3>
                                    @if($featuredStory->story)
                                        <div class="mt-4 prose prose-sm prose-slate max-w-none prose-p:text-gray-600 prose-p:leading-relaxed prose-headings:font-headline prose-headings:text-ctc-blue">
                                            {!! $featuredStory->story !!}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="h-full min-h-[280px] rounded-3xl border border-dashed border-gray-300 bg-ctc-grey-light/50 flex flex-col items-center justify-center p-8 text-center">
                                <p class="text-sm font-semibold text-ctc-blue">No featured story yet</p>
                                <p class="mt-2 text-sm text-gray-600 max-w-md">In the admin panel, open <strong>Impact Stories</strong> and enable <strong>Featured success story</strong> on one visible story.</p>
                            </div>
                        @endif
                    </div>

                    {{-- Testimonials carousel --}}
                    @if($testimonials->isNotEmpty())
                        <div class="lg:col-span-5 flex flex-col">
                            <div
                                class="flex-1 flex flex-col rounded-3xl border border-gray-200 bg-gradient-to-b from-ctc-blue to-[#12124a] text-white shadow-lg overflow-hidden"
                                x-data="{
                                    active: 0,
                                    total: {{ $testimonials->count() }},
                                    init() {
                                        if (this.total > 1) {
                                            setInterval(() => { this.active = (this.active + 1) % this.total }, 6500);
                                        }
                                    },
                                    prev() { this.active = (this.active - 1 + this.total) % this.total; },
                                    next() { this.active = (this.active + 1) % this.total; },
                                }"
                                role="region"
                                aria-roledescription="carousel"
                                aria-label="Testimonials"
                            >
                                <div class="px-6 pt-6 pb-2 flex items-center justify-between gap-3">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-white/70">Testimonials</p>
                                    <div class="flex gap-1">
                                        <button type="button" class="rounded-lg border border-white/20 p-2 text-white/90 hover:bg-white/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-ctc-accent" @click="prev()" aria-label="Previous testimonial">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                                        </button>
                                        <button type="button" class="rounded-lg border border-white/20 p-2 text-white/90 hover:bg-white/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-ctc-accent" @click="next()" aria-label="Next testimonial">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="flex-1 px-6 pb-6 flex flex-col justify-center min-h-[200px]">
                                    @foreach($testimonials as $ti => $t)
                                        <blockquote
                                            class="w-full"
                                            x-show="active === {{ $ti }}"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0 translate-x-4"
                                            x-transition:enter-end="opacity-100 translate-x-0"
                                            x-transition:leave="transition ease-in duration-200"
                                            x-transition:leave-start="opacity-100 translate-x-0"
                                            x-transition:leave-end="opacity-0 -translate-x-4"
                                            x-cloak
                                        >
                                            <span class="text-4xl font-headline text-ctc-accent/90 leading-none select-none" aria-hidden="true">“</span>
                                            <p class="mt-2 text-base sm:text-lg leading-relaxed text-white/95">{{ $t->quote }}</p>
                                            <footer class="mt-6 flex items-center gap-3">
                                                @if($t->image_url)
                                                    <img src="{{ $t->image_url }}" alt="" class="h-12 w-12 rounded-full object-cover border-2 border-white/20" loading="lazy">
                                                @endif
                                                <div>
                                                    <cite class="not-italic text-sm font-bold text-white">{{ $t->author_name }}</cite>
                                                    @if($t->author_role)
                                                        <p class="text-xs text-white/65">{{ $t->author_role }}</p>
                                                    @endif
                                                </div>
                                            </footer>
                                        </blockquote>
                                    @endforeach
                                </div>

                                @if($testimonials->count() > 1)
                                    <div class="flex justify-center gap-1.5 pb-5 px-6" role="tablist" aria-label="Testimonial slides">
                                        @foreach($testimonials as $ti => $t)
                                            <button
                                                type="button"
                                                class="h-2 rounded-full transition-all focus:outline-none focus-visible:ring-2 focus-visible:ring-ctc-accent"
                                                :class="active === {{ $ti }} ? 'w-8 bg-ctc-accent' : 'w-2 bg-white/35'"
                                                @click="active = {{ $ti }}"
                                                :aria-selected="active === {{ $ti }} ? 'true' : 'false'"
                                                aria-label="Show testimonial {{ $ti + 1 }}"
                                            ></button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    <section class="py-16 lg:py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-12 items-start">
                <div class="lg:col-span-5">
                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-accent">Impact</p>
                    <h2 class="mt-3 text-2xl sm:text-3xl font-headline font-extrabold tracking-tight text-ctc-blue">
                        A beacon of hope and healing
                    </h2>
                    <p class="mt-4 text-gray-600 leading-relaxed">
                        Every surgery has a story. Our patients come from across Kenya and the region, including children with congenital heart defects,
                        adults with valve disease or coronary disease, and those needing thoracic surgery. These stories of hope and healing drive our mission.
                    </p>

                    <div class="mt-8 rounded-2xl border border-gray-200 bg-ctc-grey-light p-6">
                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-secondary">Milestones</p>
                        <ul class="mt-4 space-y-3 text-gray-700 text-sm">
                            <li class="flex items-start gap-3"><span class="mt-0.5 h-2 w-2 rounded-full bg-ctc-accent"></span><span><span class="font-semibold text-ctc-blue">5,000+</span> open heart surgeries performed</span></li>
                            <li class="flex items-start gap-3"><span class="mt-0.5 h-2 w-2 rounded-full bg-ctc-accent"></span><span><span class="font-semibold text-ctc-blue">50+</span> surgeons trained through fellowship and visiting programs</span></li>
                            <li class="flex items-start gap-3"><span class="mt-0.5 h-2 w-2 rounded-full bg-ctc-accent"></span><span><span class="font-semibold text-ctc-blue">15+</span> countries represented by our patients</span></li>
                            <li class="flex items-start gap-3"><span class="mt-0.5 h-2 w-2 rounded-full bg-ctc-accent"></span><span><span class="font-semibold text-ctc-blue">25+</span> years of cardiothoracic service at Tenwek</span></li>
                        </ul>
                    </div>
                </div>

                <div class="lg:col-span-7">
                    <div class="rounded-3xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                        @if(!empty($feature?->media_url))
                            <div class="aspect-video bg-black">
                                <iframe
                                    src="{{ $feature->media_url }}"
                                    class="h-full w-full"
                                    title="Impact media"
                                    loading="lazy"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                ></iframe>
                            </div>
                        @else
                            <div class="aspect-video bg-ctc-grey-light">
                                <img
                                    src="{{ $feature?->image_url ?: config('ctc.page_banner_image') }}"
                                    alt="Impact at Tenwek CTC"
                                    class="h-full w-full object-cover"
                                    loading="lazy"
                                >
                            </div>
                        @endif
                        <div class="p-6">
                            <div class="flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.18em] text-ctc-blue/75">
                                <span class="h-2 w-2 rounded-full bg-ctc-accent shadow-[0_0_0_4px_rgba(179,49,39,0.18)]"></span>
                                From the centre
                            </div>
                            <p class="mt-3 text-sm text-gray-600">This media block is editable from the admin panel when you add a story image or media URL.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 lg:py-20 bg-ctc-grey-light">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between gap-6 flex-wrap">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-accent">Patient stories</p>
                    <h2 class="mt-3 text-2xl sm:text-3xl font-headline font-extrabold tracking-tight text-ctc-blue">Stories of hope</h2>
                    <p class="mt-4 text-gray-600 leading-relaxed max-w-2xl">Featured stories and moments from the CTC: patients, partners, and training impact.</p>
                </div>
            </div>

            <div class="mt-8 grid sm:grid-cols-2 lg:grid-cols-3 gap-6 auto-rows-fr">
                @forelse($stories as $s)
                    <div class="h-full rounded-2xl bg-white border border-gray-200 shadow-sm overflow-hidden">
                        <div class="aspect-video bg-ctc-grey-light">
                            <img src="{{ $s->image_url ?: config('ctc.page_banner_image') }}" alt="{{ $s->title }}" class="h-full w-full object-cover" loading="lazy">
                        </div>
                        <div class="p-6">
                            <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-secondary">
                                {{ $s->story_date?->format('M Y') ?? 'Story' }}
                            </p>
                            <h3 class="mt-2 text-lg font-semibold text-gray-900">{{ $s->title }}</h3>
                            @if($s->story)
                                <p class="mt-3 text-sm text-gray-600 leading-relaxed line-clamp-3">{{ str($s->story)->stripTags()->limit(280) }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600">No stories yet.</p>
                @endforelse
            </div>

            <div class="mt-12 grid gap-6 lg:grid-cols-12 items-start">
                <div class="lg:col-span-7 rounded-2xl bg-white border border-gray-200 shadow-sm p-6 sm:p-8">
                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-accent">Global impact</p>
                    <h3 class="mt-3 text-xl font-semibold text-ctc-blue">Training, partnerships, and sustainable care</h3>
                    <p class="mt-4 text-gray-600 leading-relaxed">
                        The CTC’s impact extends beyond our campus. Our graduates serve in hospitals across East Africa and beyond.
                        By training local surgeons and maintaining high standards of care, we contribute to a sustainable model of cardiothoracic care for Africa.
                    </p>
                </div>
                <div class="lg:col-span-5 rounded-2xl bg-white border border-gray-200 shadow-sm p-6 sm:p-8">
                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-secondary">From the news</p>
                    <h3 class="mt-3 text-xl font-semibold text-ctc-blue">Latest updates</h3>
                    <div class="mt-5 space-y-4">
                        @forelse($latestNews as $n)
                            <a href="{{ route('news.show', $n->slug) }}" class="block group">
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-ctc-blue transition-colors line-clamp-2">
                                    <span class="inline-block mr-2 align-middle h-1.5 w-1.5 rounded-full bg-ctc-accent/90"></span>{{ $n->title }}
                                </p>
                                <p class="mt-1 text-xs text-gray-500">{{ optional($n->published_at ?? $n->created_at)->format('M j, Y') }}</p>
                            </a>
                        @empty
                            <p class="text-sm text-gray-600">No news yet.</p>
                        @endforelse
                    </div>
                    <a href="{{ route('news') }}" class="mt-6 inline-flex items-center text-sm font-semibold text-ctc-secondary hover:underline">View all news →</a>
                </div>
            </div>
        </div>
    </section>
@endsection
