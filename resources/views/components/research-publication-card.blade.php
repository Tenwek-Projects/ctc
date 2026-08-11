@props(['publication'])

@php
    $url = $publication->publisherUrl();
    $doiUrl = $publication->doiUrl();
    $pubmedUrl = $publication->pubmedUrl();
    $specialtyLower = mb_strtolower((string) $publication->specialty);
    $titleLower = mb_strtolower((string) $publication->title);
    $isCardiac = str_contains($specialtyLower, 'cardiothoracic')
        || str_contains($specialtyLower, 'cardiology')
        || str_contains($specialtyLower, 'perfusion')
        || str_contains($titleLower, 'cardiac')
        || str_contains($titleLower, 'cardio')
        || str_contains($titleLower, 'heart');
    $isEndoscopy = str_contains($specialtyLower, 'endoscopy')
        || str_contains($specialtyLower, 'gastroenterology')
        || str_contains($titleLower, 'endoscop')
        || str_contains($titleLower, 'oesophag')
        || str_contains($titleLower, 'esophag');
@endphp

<article class="group relative overflow-hidden rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:border-ctc-blue/20 hover:shadow-md {{ $isCardiac || $isEndoscopy ? 'ring-1 ring-ctc-secondary/15' : '' }}">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
        <div class="shrink-0 space-y-2">
            <span class="inline-flex h-10 min-w-10 items-center justify-center rounded-xl bg-ctc-blue px-3 text-xs font-extrabold text-white shadow-sm">
                {{ $publication->year ?: '—' }}
            </span>
            @if($isCardiac)
                <span class="block rounded-lg bg-ctc-ruby/10 px-2 py-1 text-center text-[9px] font-bold uppercase tracking-[0.12em] text-ctc-ruby">Cardiac</span>
            @elseif($isEndoscopy)
                <span class="block rounded-lg bg-ctc-secondary/15 px-2 py-1 text-center text-[9px] font-bold uppercase tracking-[0.12em] text-ctc-secondary-dark">Endoscopy</span>
            @endif
        </div>

        <div class="min-w-0 flex-1">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <h3 class="text-base sm:text-lg font-semibold leading-snug text-gray-900">
                    @if($url)
                        <a href="{{ $url }}" target="_blank" rel="noopener noreferrer"
                           class="text-ctc-blue transition-colors group-hover:text-ctc-secondary hover:underline">
                            {{ $publication->title }}
                        </a>
                    @else
                        {{ $publication->title }}
                    @endif
                </h3>
                @if($publication->publication_type)
                    <span class="shrink-0 rounded-full bg-ctc-grey-light px-3 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-ctc-blue">
                        {{ $publication->publication_type }}
                    </span>
                @endif
            </div>

            @if($publication->authors)
                <p class="mt-2 text-sm text-gray-700 leading-relaxed">{{ $publication->authors }}</p>
            @endif

            @if($publication->tenwek_authors)
                <p class="mt-1.5 text-xs text-gray-600">
                    <span class="font-semibold text-gray-800">Tenwek authors:</span>
                    {{ $publication->tenwek_authors }}
                </p>
            @endif

            @if($publication->journal)
                <p class="mt-2 text-sm italic text-gray-500">{{ $publication->journal }}</p>
            @endif

            <div class="mt-4 flex flex-wrap items-center gap-2">
                @if($publication->specialty)
                    <span class="inline-flex rounded-full border border-ctc-secondary/20 bg-ctc-secondary/10 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.12em] text-ctc-secondary-dark">
                        {{ $publication->specialty }}
                    </span>
                @endif
                @if($doiUrl)
                    <a href="{{ $doiUrl }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center rounded-full border border-gray-200 px-2.5 py-1 text-[10px] font-semibold text-gray-600 transition hover:border-ctc-blue hover:text-ctc-blue">
                        DOI
                    </a>
                @endif
                @if($pubmedUrl)
                    <a href="{{ $pubmedUrl }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center rounded-full border border-gray-200 px-2.5 py-1 text-[10px] font-semibold text-gray-600 transition hover:border-ctc-blue hover:text-ctc-blue">
                        PubMed
                    </a>
                @endif
                @if($url)
                    <a href="{{ $url }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-1 rounded-full border border-ctc-blue/15 bg-ctc-blue/5 px-2.5 py-1 text-[10px] font-semibold text-ctc-blue transition hover:bg-ctc-blue hover:text-white">
                        Read
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                @endif
            </div>
        </div>
    </div>
</article>
