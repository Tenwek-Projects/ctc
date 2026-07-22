@props([
    'title',
    'description' => null,
    'buttonLabel' => 'Learn more',
    'buttonUrl' => null,
    'badgeLeft' => null,
    'badgeRight' => null,
    'image' => null,
    'imageAlt' => '',
    'points' => [],
    'secondaryLabel' => null,
    'secondaryUrl' => null,
    'headline' => null,
])

@php
    $words = preg_split('/\s+/', trim((string) $title), 2, PREG_SPLIT_NO_EMPTY) ?: [];
    $left = $badgeLeft ?: ($words[0] ?? 'Support');
    $right = $badgeRight ?: ($words[1] ?? 'Us');
    $hasImage = filled($image);
    $points = is_array($points) ? $points : [];
    $displayHeadline = $headline ?: $title;
@endphp

<section class="ctc-cta-section relative overflow-hidden border-y border-gray-200 bg-ctc-grey-light py-14 sm:py-16 lg:py-20" data-ctc-reveal="fade-in">
    <div class="container relative mx-auto px-4 sm:px-6 lg:px-8">
        @if($hasImage)
            <div class="grid overflow-hidden border border-gray-200 bg-white shadow-sm lg:grid-cols-12 lg:items-stretch">
                <div class="relative min-h-[16rem] sm:min-h-[20rem] lg:col-span-5 lg:min-h-[28rem]">
                    <img
                        src="{{ $image }}"
                        alt="{{ $imageAlt }}"
                        class="absolute inset-0 h-full w-full object-cover"
                        loading="lazy"
                    >
                </div>

                <div class="flex flex-col justify-between gap-8 p-6 sm:p-8 lg:col-span-7 lg:p-10 xl:p-12">
                    <div>
                        <h2 class="sr-only">{{ $title }}</h2>

                        <div class="inline-flex items-stretch overflow-hidden shadow-sm" aria-hidden="true">
                            <span class="inline-flex items-center bg-ctc-ruby px-4 py-2.5 text-[0.7rem] font-extrabold uppercase tracking-[0.22em] text-white sm:px-5 sm:text-xs">
                                {{ $left }}
                            </span>
                            <span class="inline-flex items-center border border-l-0 border-gray-300 bg-white px-4 py-2.5 text-[0.7rem] font-extrabold uppercase tracking-[0.22em] text-ctc-blue sm:px-5 sm:text-xs">
                                {{ $right }}
                            </span>
                        </div>

                        <p class="mt-5 font-headline text-2xl font-extrabold tracking-tight text-ctc-blue sm:text-3xl lg:text-[2rem] lg:leading-tight">
                            {{ $displayHeadline }}
                        </p>

                        @if($description)
                            <p class="mt-4 max-w-2xl text-base leading-relaxed text-gray-600 sm:text-lg">
                                {{ $description }}
                            </p>
                        @endif

                        @if(count($points) > 0)
                            <ul class="mt-8 grid gap-3 sm:grid-cols-2">
                                @foreach($points as $point)
                                    <li class="flex gap-3 border border-gray-200 bg-ctc-grey-light/70 p-4">
                                        <span class="mt-1 h-2 w-2 shrink-0 rounded-full bg-ctc-ruby" aria-hidden="true"></span>
                                        <span>
                                            <span class="block text-sm font-semibold text-ctc-blue">{{ $point['title'] ?? '' }}</span>
                                            @if(!empty($point['text']))
                                                <span class="mt-1 block text-sm leading-relaxed text-gray-600">{{ $point['text'] }}</span>
                                            @endif
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="flex flex-col gap-3 border-t border-gray-200 pt-6 sm:flex-row sm:flex-wrap sm:items-center">
                        @if($buttonUrl)
                            <a href="{{ $buttonUrl }}"
                               class="ctc-magnetic ctc-btn-shine inline-flex items-center justify-center gap-2 border-2 border-ctc-ruby bg-ctc-ruby px-7 py-3.5 font-headline text-[0.62rem] font-bold uppercase tracking-[0.18em] text-white shadow-sm transition hover:bg-ctc-ruby/90 focus:outline-none focus-visible:ring-2 focus-visible:ring-ctc-ruby focus-visible:ring-offset-2">
                                {{ $buttonLabel }}
                            </a>
                        @endif
                        @if($secondaryUrl && $secondaryLabel)
                            <a href="{{ $secondaryUrl }}"
                               class="inline-flex items-center justify-center gap-2 border border-gray-300 bg-white px-6 py-3.5 font-headline text-[0.62rem] font-bold uppercase tracking-[0.18em] text-ctc-blue transition hover:border-ctc-ruby/40 hover:text-ctc-ruby focus:outline-none focus-visible:ring-2 focus-visible:ring-ctc-ruby focus-visible:ring-offset-2">
                                {{ $secondaryLabel }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="mx-auto max-w-3xl text-center">
                <h2 class="sr-only">{{ $title }}</h2>

                <div class="inline-flex items-stretch overflow-hidden shadow-sm" aria-hidden="true">
                    <span class="inline-flex items-center bg-ctc-ruby px-4 py-2.5 text-[0.7rem] font-extrabold uppercase tracking-[0.22em] text-white sm:px-5 sm:text-xs">
                        {{ $left }}
                    </span>
                    <span class="inline-flex items-center border border-l-0 border-gray-300 bg-white px-4 py-2.5 text-[0.7rem] font-extrabold uppercase tracking-[0.22em] text-ctc-blue sm:px-5 sm:text-xs">
                        {{ $right }}
                    </span>
                </div>

                @if($description)
                    <p class="mx-auto mt-7 max-w-2xl text-base leading-relaxed text-gray-600 sm:text-lg">
                        {{ $description }}
                    </p>
                @endif

                @if($buttonUrl)
                    <div class="mt-8">
                        <a href="{{ $buttonUrl }}"
                           class="ctc-magnetic ctc-btn-shine inline-flex items-center justify-center gap-2 border-2 border-ctc-ruby bg-ctc-ruby px-7 py-3.5 font-headline text-[0.62rem] font-bold uppercase tracking-[0.18em] text-white shadow-sm transition hover:bg-ctc-ruby/90 focus:outline-none focus-visible:ring-2 focus-visible:ring-ctc-ruby focus-visible:ring-offset-2">
                            {{ $buttonLabel }}
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</section>
