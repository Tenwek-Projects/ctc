@extends('layouts.app')

@section('title', 'Publications')

@section('content')
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

    <section class="py-14 lg:py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <div class="max-w-3xl">
                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-accent">Research output</p>
                    <h2 class="mt-3 text-2xl sm:text-3xl font-headline font-extrabold tracking-tight text-ctc-blue">
                        Publications from Tenwek Hospital &amp; the CTC
                    </h2>
                    <p class="mt-4 text-gray-600 leading-relaxed">
                        Scientific publications with authors affiliated to AGC Tenwek Hospital, Tenwek Hospital, or Tenwek Mission Hospital.
                        For corrections or additions, contact
                        <a href="mailto:research.manager@tenwekhosp.org" class="font-semibold text-ctc-secondary hover:underline">research.manager@tenwekhosp.org</a>.
                    </p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <span class="inline-flex items-center rounded-full border border-ctc-blue/15 bg-white px-4 py-2 text-xs font-bold uppercase tracking-[0.16em] text-ctc-blue shadow-sm">
                            {{ number_format($totalCount) }} publications
                        </span>
                        @if($years->isNotEmpty())
                            <span class="inline-flex items-center rounded-full border border-ctc-secondary/25 bg-ctc-secondary/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.16em] text-ctc-secondary-dark">
                                {{ $years->last() }}–{{ $years->first() }}
                            </span>
                        @endif
                    </div>
                </div>

                <form
                    method="get"
                    action="{{ route('research.publications') }}"
                    class="mt-10 rounded-2xl border border-gray-200 bg-white p-4 sm:p-6 shadow-sm"
                >
                    <div class="grid gap-4 lg:grid-cols-12 lg:items-end">
                        <div class="lg:col-span-5">
                            <label for="pub-search" class="block text-xs font-bold uppercase tracking-[0.16em] text-gray-500 mb-2">Search</label>
                            <input
                                id="pub-search"
                                type="search"
                                name="q"
                                value="{{ $filters['search'] }}"
                                placeholder="Title, author, journal, specialty…"
                                class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-ctc-blue focus:ring-2 focus:ring-ctc-blue/20"
                            >
                        </div>
                        <div class="lg:col-span-2">
                            <label for="pub-year" class="block text-xs font-bold uppercase tracking-[0.16em] text-gray-500 mb-2">Year</label>
                            <select id="pub-year" name="year" class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:border-ctc-blue focus:ring-2 focus:ring-ctc-blue/20">
                                <option value="">All years</option>
                                @foreach($years as $y)
                                    <option value="{{ $y }}" @selected($filters['year'] === (string) $y)>{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="lg:col-span-3">
                            <label for="pub-specialty" class="block text-xs font-bold uppercase tracking-[0.16em] text-gray-500 mb-2">Specialty</label>
                            <select id="pub-specialty" name="specialty" class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:border-ctc-blue focus:ring-2 focus:ring-ctc-blue/20">
                                <option value="">All specialties</option>
                                @foreach($specialties as $specialtyOption)
                                    <option value="{{ $specialtyOption }}" @selected($filters['specialty'] === $specialtyOption)>{{ $specialtyOption }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="lg:col-span-2">
                            <label for="pub-type" class="block text-xs font-bold uppercase tracking-[0.16em] text-gray-500 mb-2">Type</label>
                            <select id="pub-type" name="type" class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm focus:border-ctc-blue focus:ring-2 focus:ring-ctc-blue/20">
                                <option value="">All types</option>
                                @foreach($types as $typeOption)
                                    <option value="{{ $typeOption }}" @selected($filters['type'] === $typeOption)>{{ $typeOption }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                        <p class="text-sm text-gray-600">
                            @if($publications->total() > 0)
                                Showing {{ $publications->firstItem() }}–{{ $publications->lastItem() }} of {{ number_format($publications->total()) }}
                                @if($hasFilters) matching @else total @endif publications
                            @else
                                No publications match your filters
                            @endif
                        </p>
                        <div class="flex flex-wrap gap-2">
                            @if($hasFilters)
                                <a href="{{ route('research.publications') }}"
                                   class="inline-flex items-center rounded-xl border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                                    Clear filters
                                </a>
                            @endif
                            <button type="submit"
                                    class="inline-flex items-center rounded-xl bg-ctc-blue px-4 py-2 text-sm font-semibold text-white hover:bg-ctc-blue-dark">
                                Apply filters
                            </button>
                        </div>
                    </div>

                    @if($hasFilters)
                        <div class="mt-4 flex flex-wrap gap-2">
                            @if($filters['search'] !== '')
                                <span class="inline-flex items-center rounded-full bg-ctc-grey-light px-3 py-1 text-xs font-medium text-gray-700">
                                    Search: “{{ Str::limit($filters['search'], 40) }}”
                                </span>
                            @endif
                            @if($filters['year'] !== '')
                                <span class="inline-flex items-center rounded-full bg-ctc-grey-light px-3 py-1 text-xs font-medium text-gray-700">Year: {{ $filters['year'] }}</span>
                            @endif
                            @if($filters['specialty'] !== '')
                                <span class="inline-flex items-center rounded-full bg-ctc-grey-light px-3 py-1 text-xs font-medium text-gray-700">{{ $filters['specialty'] }}</span>
                            @endif
                            @if($filters['type'] !== '')
                                <span class="inline-flex items-center rounded-full bg-ctc-grey-light px-3 py-1 text-xs font-medium text-gray-700">{{ $filters['type'] }}</span>
                            @endif
                        </div>
                    @endif
                </form>

                <div class="mt-8 space-y-4">
                    @forelse($publications as $publication)
                        <x-research-publication-card :publication="$publication" />
                    @empty
                        <div class="rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 px-6 py-16 text-center">
                            <p class="text-lg font-semibold text-gray-700">No publications found</p>
                            <p class="mt-2 text-sm text-gray-600">Try different search terms or clear your filters.</p>
                            @if($hasFilters)
                                <a href="{{ route('research.publications') }}" class="mt-4 inline-flex text-sm font-semibold text-ctc-blue hover:underline">
                                    View all publications
                                </a>
                            @endif
                        </div>
                    @endforelse
                </div>

                @if($publications->hasPages())
                    <div class="mt-10 flex justify-center rounded-2xl border border-gray-200 bg-ctc-grey-light/60 p-4">
                        {{ $publications->onEachSide(1)->links() }}
                    </div>
                @endif

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
