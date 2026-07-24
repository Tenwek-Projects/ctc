<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') | Admin | {{ config('ctc.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/trix.css', 'resources/js/app.js', 'resources/js/admin.js'])
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="h-screen overflow-hidden bg-admin-bg text-admin-dark antialiased" data-ctc-site="admin">
    <div
        class="flex h-screen"
        x-data="{ sidebarOpen: false, adminMenuOpen: false }"
        @resize.window="if (window.matchMedia('(min-width: 1024px)').matches) sidebarOpen = false"
    >
        {{-- Sidebar: off-canvas < lg. .is-open + CSS below avoid click-stealing when closed (no fragile data-* Alpine binding). --}}
        <aside
            data-ctc-admin-sidebar
            class="fixed inset-y-0 left-0 flex w-64 shrink-0 flex-col bg-admin-sidebar text-white transition-transform duration-200 ease-in-out lg:pointer-events-auto lg:static lg:inset-auto lg:z-auto lg:translate-x-0 -translate-x-full"
            :class="sidebarOpen ? 'is-open !translate-x-0 max-lg:z-50 max-lg:pointer-events-auto' : 'max-lg:z-0 max-lg:pointer-events-none'"
        >
            <div class="flex h-16 items-center justify-between px-4 border-b border-white/15 lg:px-5">
                <span class="font-bold text-white truncate">{{ config('ctc.name') }}</span>
                <button type="button" @click="sidebarOpen = false" class="lg:hidden p-2 rounded-lg hover:bg-white/10 text-white" aria-label="Close menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="flex-1 min-h-0">
                @include('admin-dashboard.components.sidebar')
            </div>
        </aside>

        <div
            data-ctc-admin-main
            class="relative z-10 flex min-h-0 min-w-0 flex-1 flex-col overflow-hidden"
        >
            {{-- Topbar: fixed within app shell --}}
            <header class="shrink-0 z-20 flex h-16 items-center justify-between gap-4 border-b border-gray-200/80 bg-white/85 backdrop-blur-xl px-4 shadow-[0_1px_0_rgba(15,23,42,0.04)] lg:px-8">
                <button type="button" @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg text-admin-muted hover:bg-admin-bg hover:text-admin-teal transition-colors" aria-label="Open menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                @php
                    $adminTips = config('admin.tips', []);
                    $routeName = request()->route()?->getName();
                    $tip = null;
                    foreach ($adminTips as $t) {
                        if (!isset($t['pattern'])) continue;
                        if ($routeName && \Illuminate\Support\Str::is($t['pattern'], $routeName)) {
                            $tip = $t;
                            break;
                        }
                    }
                @endphp
                <div class="min-w-0">
                    <h1 class="text-lg font-semibold text-admin-dark truncate">@yield('header', 'Dashboard')</h1>
                    @if($tip && !empty($tip['text']))
                        <p class="mt-0.5 text-xs text-admin-muted truncate">
                            {{ $tip['text'] }}
                            @if(!empty($tip['public']))
                                <a href="{{ url($tip['public']) }}" target="_blank" rel="noopener"
                                   class="ml-2 inline-flex items-center gap-1 text-admin-teal hover:text-admin-teal-dark font-medium">
                                    View page
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h6m0 0v6m0-6L10 16m-1 5H6a2 2 0 01-2-2v-3"/></svg>
                                </a>
                            @endif
                        </p>
                    @endif
                </div>
                @php
                    $headerLinks = collect(config('admin.header_links', []))->filter(function ($item) {
                        $permission = $item['permission'] ?? null;
                        return !$permission || auth()->user()->hasPermission($permission);
                    })->values();
                    $userName = auth()->user()->name ?? 'Admin';
                    $initials = collect(preg_split('/\s+/', trim($userName)))->filter()->take(2)->map(fn ($p) => mb_strtoupper(mb_substr($p, 0, 1)))->implode('');
                @endphp
                <div class="flex items-center gap-3">
                    <span class="text-sm text-admin-muted hidden md:inline truncate max-w-[18rem]">{{ $userName }}</span>
                    <span class="hidden sm:inline rounded-full bg-admin-gold/20 text-admin-gold-dark px-2.5 py-0.5 text-xs font-medium">
                        {{ auth()->user()->role?->name ?? 'No role' }}
                    </span>

                    <div class="relative" @keydown.escape.window="adminMenuOpen = false">
                        <button type="button"
                                @click="adminMenuOpen = !adminMenuOpen"
                                class="group inline-flex items-center gap-2 rounded-xl border border-gray-200/80 bg-white px-2.5 py-2 text-sm text-admin-dark shadow-sm hover:shadow-md hover:border-gray-300 transition-all"
                                :aria-expanded="adminMenuOpen ? 'true' : 'false'"
                                aria-haspopup="menu">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-[linear-gradient(135deg,rgba(26,26,104,0.95),rgba(98,163,161,0.92))] text-white text-xs font-extrabold tracking-wide">
                                {{ $initials ?: 'A' }}
                            </span>
                            <span class="hidden sm:inline font-medium text-admin-dark/90">Admin</span>
                            <svg class="h-4 w-4 text-admin-muted transition-transform" :class="adminMenuOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="adminMenuOpen"
                             x-transition:enter="transition ease-out duration-120"
                             x-transition:enter-start="opacity-0 translate-y-1 scale-[0.98]"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-90"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-1 scale-[0.98]"
                             @click.outside="adminMenuOpen = false"
                             x-cloak
                             class="absolute right-0 mt-2 w-[18.5rem] origin-top-right rounded-2xl border border-gray-200 bg-white shadow-[0_28px_70px_rgba(15,23,42,0.18)] overflow-hidden z-50"
                             role="menu">
                            <div class="px-4 py-3 bg-gradient-to-r from-admin-bg to-white">
                                <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-admin-muted">Quick actions</p>
                                <p class="mt-1 text-sm font-semibold text-admin-dark truncate">{{ $userName }}</p>
                            </div>

                            <div class="p-2">
                                @foreach($headerLinks->reject(fn ($link) => !empty($link['danger'])) as $link)
                                    <a href="{{ route($link['route']) }}"
                                       class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-admin-dark hover:bg-admin-bg transition-colors"
                                       role="menuitem">
                                        <span class="text-admin-teal">
                                            @include('admin-dashboard.components.icon', ['name' => $link['icon']])
                                        </span>
                                        <span class="truncate">{{ $link['label'] }}</span>
                                    </a>
                                @endforeach

                                <a href="{{ url('/') }}" target="_blank" rel="noopener"
                                   class="mt-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-admin-dark hover:bg-admin-bg transition-colors"
                                   role="menuitem">
                                    <span class="text-admin-teal">
                                        @include('admin-dashboard.components.icon', ['name' => 'external-link'])
                                    </span>
                                    <span class="truncate">View site</span>
                                </a>
                            </div>

                            @php $dangerLinks = $headerLinks->filter(fn ($link) => !empty($link['danger'])); @endphp
                            @if($dangerLinks->isNotEmpty())
                                <div class="border-t border-red-100 p-2 bg-red-50/60">
                                    @foreach($dangerLinks as $link)
                                        <a href="{{ route($link['route']) }}"
                                           class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-red-700 hover:bg-red-100/80 transition-colors"
                                           role="menuitem">
                                            <span class="text-red-600">
                                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                                                </svg>
                                            </span>
                                            <span class="truncate font-semibold">{{ $link['label'] }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            @endif

                            <div class="border-t border-gray-200/80 p-2 bg-white">
                                <form method="post" action="{{ route('admin-dashboard.logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-admin-coral hover:bg-red-50 transition-colors"
                                            role="menuitem">
                                        <span class="text-admin-coral">
                                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H9m4 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1"/>
                                            </svg>
                                        </span>
                                        <span class="truncate font-medium">Log out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Main --}}
            <main class="flex-1 min-h-0 overflow-y-auto p-4 lg:p-8">
                @if(session('success'))
                    <div class="mb-6 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800 shadow-sm flex items-center gap-2">
                        <svg class="w-5 h-5 shrink-0 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800 shadow-sm">{{ session('error') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
