@extends('layouts.app')

@push('body_class')
    ctc-news-playful
@endpush

@php
    $newsSidebarContext = (request()->routeIs('news.show') || request()->routeIs('events.show')) ? 'show' : 'index';
@endphp

@section('content')
    <div class="ctc-news-playful-root relative flex min-h-0 flex-1 flex-col">
        <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
            <div class="ctc-news-playful-blob ctc-news-playful-blob--a"></div>
            <div class="ctc-news-playful-blob ctc-news-playful-blob--b"></div>
            <div class="ctc-news-playful-dots"></div>
        </div>

        <div class="ctc-news-playful-split relative z-[1] flex min-h-0 flex-1 flex-col gap-5 px-4 py-3 sm:px-6 lg:flex-row lg:gap-6 lg:px-8 lg:py-4">
            {{-- Main column: own scroll (desktop) --}}
            <div
                class="ctc-news-scroll-panel ctc-news-playful-main min-h-0 flex-1 rounded-3xl border border-ctc-blue/10 bg-white/80 shadow-[0_20px_60px_rgba(18,18,74,0.08)] backdrop-blur-md lg:min-h-0"
                data-lenis-prevent
            >
                <div class="p-5 sm:p-7 lg:p-8">
                    @yield('news_playful_main')
                </div>
            </div>

            {{-- Sidebar: independent scroll --}}
            <aside
                class="ctc-news-scroll-panel ctc-news-playful-sidebar mt-2 min-h-0 w-full shrink-0 rounded-3xl border border-ctc-secondary/25 bg-gradient-to-b from-white/95 to-ctc-grey-light/90 shadow-[0_24px_70px_rgba(18,18,74,0.1)] backdrop-blur-md lg:mt-0 lg:w-[min(100%,22rem)] xl:w-[min(100%,24rem)]"
                data-lenis-prevent
                aria-label="News sidebar"
            >
                <div class="p-5 sm:p-6">
                    @include('partials.news-playful-sidebar', [
                        'recent' => $recent ?? collect(),
                        'context' => $newsSidebarContext,
                        'article' => isset($article) ? $article : null,
                    ])
                </div>
            </aside>
        </div>
    </div>
@endsection
