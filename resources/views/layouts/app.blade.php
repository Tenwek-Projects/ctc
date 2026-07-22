<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $seo = $seo ?? null;
    @endphp

    <meta name="description" content="{{ $seo['description'] ?? ($metaDescription ?? config('ctc.tagline')) }}">
    @if(!empty($seo['keywords']))
        <meta name="keywords" content="{{ $seo['keywords'] }}">
    @endif
    <meta name="robots" content="{{ $seo['robots'] ?? 'index,follow' }}">
    <meta name="author" content="{{ $seo['meta']['author'] ?? config('ctc.hospital') }}">
    <meta http-equiv="content-language" content="{{ $seo['meta']['language'] ?? str_replace('_','-',app()->getLocale()) }}">
    <meta name="geo.region" content="{{ $seo['meta']['geo_region'] ?? 'KE' }}">
    <meta name="geo.placename" content="{{ $seo['meta']['geo_placename'] ?? 'Bomet, Kenya' }}">

    <link rel="canonical" href="{{ $seo['canonical'] ?? request()->url() }}">

    @stack('head')

    @php
        $yieldedTitle = trim($__env->yieldContent('title'));
        $documentTitle = \App\Support\Seo\Seo::documentTitle(
            $yieldedTitle !== '' ? $yieldedTitle : null,
            $seo['page_segment'] ?? ($seo['title'] ?? null),
            request()->route()?->getName()
        );
    @endphp
    <title>{{ $documentTitle }}</title>

    {{-- Open Graph --}}
    <meta property="og:type" content="{{ $seo['og']['type'] ?? 'website' }}">
    <meta property="og:site_name" content="{{ $seo['og']['site_name'] ?? config('ctc.name') }}">
    <meta property="og:locale" content="{{ $seo['og']['locale'] ?? str_replace('_','-',app()->getLocale()) }}">
    <meta property="og:url" content="{{ $seo['og']['url'] ?? request()->url() }}">
    <meta property="og:title" content="{{ $documentTitle }}">
    <meta property="og:description" content="{{ $seo['og']['description'] ?? ($seo['description'] ?? config('ctc.tagline')) }}">
    <meta property="og:image" content="{{ $seo['og']['image'] ?? url('/ctc.jpg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    {{-- Twitter/X --}}
    <meta name="twitter:card" content="{{ $seo['twitter']['card'] ?? 'summary_large_image' }}">
    <meta name="twitter:title" content="{{ $documentTitle }}">
    <meta name="twitter:description" content="{{ $seo['twitter']['description'] ?? ($seo['description'] ?? config('ctc.tagline')) }}">
    <meta name="twitter:image" content="{{ $seo['twitter']['image'] ?? url('/ctc.jpg') }}">

    {{-- Favicons --}}
    <link rel="icon" href="{{ asset('flagship.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('flagship.png') }}">
    <meta name="theme-color" content="#12124A">

    {{-- Performance hints --}}
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- JSON-LD --}}
    @if(!empty($seo['schema']) && is_array($seo['schema']))
        @foreach($seo['schema'] as $block)
            <script type="application/ld+json">{!! json_encode($block, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
        @endforeach
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    class="min-h-screen bg-white text-gray-800 antialiased {{ request()->routeIs('home') ? 'ctc-home' : '' }} @stack('body_class')"
    data-ctc-site="public"
    x-data="{ mobileMenuOpen: false }"
>
    <div id="ctc-site-header" class="ctc-site-header" role="banner">
        @include('components.top-header')
    </div>

    @yield('hero')
    <div id="ctc-navbar-sentinel" aria-hidden="true"></div>
    @include('components.navbar')
    <div id="ctc-navbar-spacer" aria-hidden="true" style="height: 0;"></div>

    <main id="ctc-main" class="min-h-screen">
        @yield('content')
    </main>

    @include('components.scroll-to-top')
    @include('components.footer')
    @stack('scripts')
</body>
</html>
