@extends('layouts.app')

@section('title', 'Publications')

@section('content')
    @php
        $publicationPayload = $publications->map(fn ($item) => [
            'id' => $item->id,
            'year' => $item->year,
            'title' => $item->title,
            'authors' => $item->authors,
            'tenwek_authors' => $item->tenwek_authors,
            'journal' => $item->journal,
            'type' => $item->publication_type,
            'specialty' => $item->specialty,
            'doi' => $item->doi,
            'pmid' => $item->pmid,
            'url' => $item->publisherUrl(),
            'citation' => $item->full_citation,
        ])->values();
    @endphp

    @include('components.page-banner', [
        'title' => 'Publications',
        'subtitle' => config('ctc.name'),
        'bannerKey' => 'research_publications',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Training & Research', 'url' => route('training-research')],
            ['label' => 'Publications', 'url' => route('research.publications')],
        ],
    ])

    <section
        class="py-14 lg:py-20"
        x-data="{
            items: {{ \Illuminate\Support\Js::from($publicationPayload) }},
            query: '',
            year: '',
            specialty: '',
            type: '',
            get filtered() {
                const q = this.query.trim().toLowerCase();
                return this.items.filter(item => {
                    if (this.year && String(item.year) !== String(this.year)) return false;
                    if (this.specialty && item.specialty !== this.specialty) return false;
                    if (this.type && item.type !== this.type) return false;
                    if (!q) return true;
                    const haystack = [item.title, item.authors, item.tenwek_authors, item.journal, item.specialty, item.citation]
                        .filter(Boolean).join(' ').toLowerCase();
                    return haystack.includes(q);
                });
            },
            get grouped() {
                const groups = {};
                for (const item of this.filtered) {
                    const key = item.year || 'Unknown';
                    if (!groups[key]) groups[key] = [];
                    groups[key].push(item);
                }
                return Object.entries(groups).sort((a, b) => Number(b[0]) - Number(a[0]));
            },
            clearFilters() {
                this.query = '';
                this.year = '';
                this.specialty = '';
                this.type = '';
            }
        }"
    >
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <div class="max-w-3xl">
                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-accent">Research output</p>
                    <h2 class="mt-3 text-2xl sm:text-3xl font-headline font-extrabold tracking-tight text-ctc-blue">
                        Publications from Tenwek Hospital &amp; the CTC
                    </h2>
                    <p class="mt-4 text-gray-600 leading-relaxed">
                        This list includes scientific publications with authors affiliated to AGC Tenwek Hospital, Tenwek Hospital, or Tenwek Mission Hospital.
                        It may not be exhaustive. For corrections or additions, contact
                        <a href="mailto:research.manager@tenwekhosp.org" class="font-semibold text-ctc-secondary hover:underline">research.manager@tenwekhosp.org</a>.
                    </p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <span class="inline-flex items-center rounded-full border border-ctc-blue/15 bg-white px-4 py-2 text-xs font-bold uppercase tracking-[0.16em] text-ctc-blue shadow-sm">
                            {{ $publications->count() }} publications
                        </span>
                        @if($years->isNotEmpty())
                            <span class="inline-flex items-center rounded-full border border-ctc-secondary/25 bg-ctc-secondary/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.16em] text-ctc-secondary-dark">
                                {{ $years->last() }}–{{ $years->first() }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="mt-10 rounded-2xl border border-gray-200 bg-white p-4 sm:p-6 shadow-sm">
                    <div class="grid gap-4 lg:grid-cols-12 lg:items-end">
                        <div class="lg:col-span-5">
                            <label for="pub-search" class="block text-xs font-bold uppercase tracking-[0.16em] text-gray-500 mb-2">Search</label>
                            <input
                                id="pub-search"
                                type="search"
                                x-model="query"
                                placeholder="Title, author, journal, specialty…"
                                class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-ctc-blue focus:ring-2 focus:ring-ctc-blue/20"
                            >
                        </div>
                        <div class="lg:col-span-2">
                            <label for="pub-year" class="block text-xs font-bold uppercase tracking-[0.16em] text-gray-500 mb-2">Year</label>
                            <select id="pub-year" x-model="year" class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:border-ctc-blue focus:ring-2 focus:ring-ctc-blue/20">
                                <option value="">All years</option>
                                @foreach($years as $y)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="lg:col-span-3">
                            <label for="pub-specialty" class="block text-xs font-bold uppercase tracking-[0.16em] text-gray-500 mb-2">Specialty</label>
                            <select id="pub-specialty" x-model="specialty" class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:border-ctc-blue focus:ring-2 focus:ring-ctc-blue/20">
                                <option value="">All specialties</option>
                                @foreach($specialties as $specialtyOption)
                                    <option value="{{ $specialtyOption }}">{{ $specialtyOption }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="lg:col-span-2">
                            <label for="pub-type" class="block text-xs font-bold uppercase tracking-[0.16em] text-gray-500 mb-2">Type</label>
                            <select id="pub-type" x-model="type" class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:border-ctc-blue focus:ring-2 focus:ring-ctc-blue/20">
                                <option value="">All types</option>
                                @foreach($types as $typeOption)
                                    <option value="{{ $typeOption }}">{{ $typeOption }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 flex flex-wrap items-center justify-between gap-3 text-sm text-gray-600">
                        <p><span x-text="filtered.length"></span> result(s)</p>
                        <button type="button" @click="clearFilters()" class="text-ctc-secondary font-semibold hover:underline">Clear filters</button>
                    </div>
                </div>

                <div class="mt-10 space-y-10">
                    <template x-for="[groupYear, groupItems] in grouped" :key="groupYear">
                        <section>
                            <div class="mb-4 flex items-center gap-3">
                                <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full bg-ctc-blue px-3 text-xs font-extrabold text-white" x-text="groupYear"></span>
                                <p class="text-sm font-semibold text-gray-500">
                                    <span x-text="groupItems.length"></span>
                                    <span x-text="groupItems.length === 1 ? ' publication' : ' publications'"></span>
                                </p>
                            </div>
                            <div class="space-y-4">
                                <template x-for="item in groupItems" :key="item.id">
                                    <article class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 shadow-sm hover:shadow-md transition-shadow">
                                        <div class="flex flex-wrap items-start justify-between gap-3">
                                            <h3 class="text-base sm:text-lg font-semibold text-gray-900 leading-snug">
                                                <a
                                                    x-show="item.url"
                                                    :href="item.url"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="text-ctc-blue hover:text-ctc-secondary hover:underline"
                                                    x-text="item.title"
                                                ></a>
                                                <span x-show="!item.url" x-text="item.title"></span>
                                            </h3>
                                            <span
                                                x-show="item.type"
                                                class="shrink-0 rounded-full bg-ctc-grey-light px-3 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-ctc-blue"
                                                x-text="item.type"
                                            ></span>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-700" x-show="item.authors" x-text="item.authors"></p>
                                        <p class="mt-1 text-xs text-gray-500" x-show="item.tenwek_authors">
                                            <span class="font-semibold text-gray-600">Tenwek authors:</span>
                                            <span x-text="item.tenwek_authors"></span>
                                        </p>
                                        <p class="mt-2 text-sm text-gray-600 italic" x-show="item.journal" x-text="item.journal"></p>
                                        <div class="mt-3 flex flex-wrap gap-2">
                                            <span
                                                x-show="item.specialty"
                                                class="inline-flex rounded-full border border-ctc-secondary/20 bg-ctc-secondary/10 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.12em] text-ctc-secondary-dark"
                                                x-text="item.specialty"
                                            ></span>
                                            <a
                                                x-show="item.doi"
                                                :href="item.doi.startsWith('http') ? item.doi : ('https://doi.org/' + item.doi)"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex rounded-full border border-gray-200 px-2.5 py-1 text-[10px] font-semibold text-gray-600 hover:border-ctc-blue hover:text-ctc-blue"
                                            >
                                                DOI
                                            </a>
                                            <a
                                                x-show="item.pmid"
                                                :href="'https://pubmed.ncbi.nlm.nih.gov/' + item.pmid.replace(/\D/g, '') + '/'"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex rounded-full border border-gray-200 px-2.5 py-1 text-[10px] font-semibold text-gray-600 hover:border-ctc-blue hover:text-ctc-blue"
                                            >
                                                PubMed
                                            </a>
                                        </div>
                                    </article>
                                </template>
                            </div>
                        </section>
                    </template>

                    <div x-show="filtered.length === 0" x-cloak class="rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 px-6 py-16 text-center">
                        <p class="text-lg font-semibold text-gray-700">No publications match your filters</p>
                        <p class="mt-2 text-sm text-gray-600">Try clearing search or choosing a different year or specialty.</p>
                    </div>
                </div>

                <div class="mt-14 grid gap-6 lg:grid-cols-2">
                    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm p-6">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">For collaborators</p>
                        <p class="mt-3 text-sm text-gray-700 leading-relaxed">
                            We welcome outcomes research collaborations that improve care delivery, surgical access, and training models for Africa.
                        </p>
                        <a href="{{ route('contact') }}" class="mt-4 inline-flex items-center px-5 py-3 rounded-lg font-semibold bg-ctc-blue text-white hover:bg-ctc-blue-dark transition-colors">
                            Contact us
                        </a>
                    </div>
                    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm p-6">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">Explore</p>
                        <div class="mt-4 space-y-3 text-sm">
                            <a href="{{ route('research') }}" class="block font-semibold text-ctc-blue hover:underline">Research overview</a>
                            <a href="{{ route('training') }}" class="block font-semibold text-ctc-blue hover:underline">Training programmes</a>
                            <a href="{{ route('training-research') }}" class="block font-semibold text-ctc-blue hover:underline">Training &amp; Research hub</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
