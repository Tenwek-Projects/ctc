@extends('layouts.news-playful')

@section('title', 'Events')

@section('news_playful_main')
    <header class="mb-8 lg:mb-10">
        <span class="inline-block -rotate-1 rounded-2xl bg-gradient-to-r from-ctc-accent/30 to-ctc-secondary/25 px-4 py-2 text-[11px] font-extrabold uppercase tracking-[0.22em] text-ctc-blue shadow-sm">
            CTC Events
        </span>
        <h1 class="mt-5 font-headline text-3xl font-extrabold tracking-tight text-ctc-blue sm:text-4xl lg:text-[2.5rem] lg:leading-[1.1]">
            Events
        </h1>
        <p class="mt-4 max-w-2xl text-lg leading-relaxed text-gray-600">
            Symposia, training activities, conferences, and outreach moments from the Cardiothoracic Centre.
        </p>
    </header>

    <div class="grid gap-5 sm:grid-cols-2">
        @forelse($events as $event)
            <article class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                <a href="{{ route('events.show', $event->slug) }}" class="block aspect-[16/10] bg-ctc-grey-light">
                    <img src="{{ $event->featured_image_url ?: 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1600&q=60' }}"
                         alt="{{ $event->title }}"
                         class="h-full w-full object-cover transition duration-300 hover:scale-[1.02]"
                         loading="lazy">
                </a>
                <div class="p-5">
                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-ctc-secondary">
                        {{ optional($event->event_date ?? $event->published_at ?? $event->created_at)->format('F j, Y') }}
                    </p>
                    <h2 class="mt-2 text-xl font-headline font-extrabold text-ctc-blue leading-tight">
                        <a href="{{ route('events.show', $event->slug) }}" class="hover:underline">{{ $event->title }}</a>
                    </h2>
                    @if($event->excerpt)
                        <div class="mt-3 prose prose-sm max-w-none text-gray-600 prose-p:my-1">
                            {!! \Illuminate\Support\Str::of($event->excerpt)->stripTags()->limit(180) !!}
                        </div>
                    @endif
                </div>
            </article>
        @empty
            <div class="col-span-full rounded-3xl border-2 border-dashed border-ctc-secondary/40 bg-ctc-grey-light/50 px-6 py-16 text-center">
                <p class="text-lg font-semibold text-gray-700">No events yet</p>
                <p class="mt-2 text-gray-600">Upcoming events will appear here.</p>
            </div>
        @endforelse
    </div>

    @if($events->hasPages())
        <div class="mt-10 flex justify-center rounded-2xl bg-ctc-grey-light/60 p-4">
            {{ $events->links() }}
        </div>
    @endif
@endsection

