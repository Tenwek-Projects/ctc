@extends('layouts.news-playful')

@section('title', $pageTitle)

@section('news_playful_main')
    <article>
        <header class="mb-8">
            <a href="{{ route('events') }}" class="group inline-flex items-center gap-2 text-sm font-bold text-ctc-secondary transition hover:text-ctc-blue">
                <span class="inline-block transition-transform group-hover:-translate-x-1" aria-hidden="true">←</span>
                Back to all events
            </a>
            <div class="mt-6 flex flex-wrap items-center gap-3">
                <span class="inline-flex items-center rounded-full bg-ctc-accent/20 px-4 py-1.5 text-xs font-extrabold uppercase tracking-wide text-ctc-blue ring-1 ring-ctc-accent/30">
                    Event
                </span>
                <time class="text-sm font-medium text-gray-500" datetime="{{ optional($event->event_date ?? $event->published_at)->toIso8601String() }}">
                    {{ optional($event->event_date ?? $event->published_at ?? $event->created_at)->format('F j, Y') }}
                </time>
            </div>
            <h1 class="mt-4 font-headline text-3xl font-extrabold tracking-tight text-ctc-blue sm:text-4xl lg:text-[2.35rem] lg:leading-[1.12]">
                {{ $event->title }}
            </h1>
            @if($event->excerpt)
                <div class="ctc-service-prose prose prose-slate prose-lg mt-5 max-w-none prose-p:text-gray-700 prose-p:leading-relaxed prose-a:text-ctc-secondary prose-strong:text-ctc-blue">
                    {!! $event->excerpt !!}
                </div>
            @endif
        </header>

        <div class="overflow-hidden rounded-3xl border border-ctc-blue/10 bg-ctc-grey-light shadow-inner">
            <div class="aspect-video sm:aspect-[21/9]">
                <img
                    src="{{ $event->featured_image_url ?: 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1600&q=60' }}"
                    alt="{{ $event->title }}"
                    class="h-full w-full object-cover"
                    loading="eager"
                    fetchpriority="high"
                >
            </div>
        </div>

        <div class="ctc-service-prose prose prose-slate prose-lg mt-10 max-w-none
                    prose-headings:font-headline prose-headings:text-ctc-blue
                    prose-p:text-gray-700 prose-p:leading-relaxed
                    prose-a:text-ctc-secondary prose-a:font-semibold
                    prose-strong:text-ctc-blue
                    prose-hr:border-ctc-accent/30">
            {!! $event->body ? \App\Support\TrixHtmlSanitizer::normalizeBlocksForDisplay($event->body) : '<p>Full event details will be published here.</p>' !!}
        </div>
    </article>
@endsection

