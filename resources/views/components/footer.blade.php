@php
    $contact = config('ctc.contact', []);
    $footer = config('ctc.footer', []);
    $social = array_filter([
        'Facebook' => \App\Models\SiteSetting::getValue('social.facebook', config('ctc.social.Facebook')),
        'LinkedIn' => \App\Models\SiteSetting::getValue('social.linkedin', config('ctc.social.LinkedIn')),
        'Instagram' => \App\Models\SiteSetting::getValue('social.instagram', config('ctc.social.Instagram')),
        'TikTok' => \App\Models\SiteSetting::getValue('social.tiktok', config('ctc.social.TikTok')),
        'YouTube' => \App\Models\SiteSetting::getValue('social.youtube', config('ctc.social.YouTube')),
        'X' => \App\Models\SiteSetting::getValue('social.x', config('ctc.social.X')),
    ]);

    $primaryPhone = $contact['phone'] ?? null;
    $emergency = $contact['emergency'] ?? null;
    $email = $contact['email'] ?? null;
    $address = $contact['address'] ?? null;

    $hospitalName = config('ctc.hospital');
    $centreName = config('ctc.name');
    $tagline = config('ctc.tagline');

    $description = $footer['description'] ?? ($hospitalName . '. ' . $tagline . '.');
    $columns = $footer['columns'] ?? [];
    $legalLinks = $footer['legal_links'] ?? [];

    $routeUrl = function (?string $route, ?string $fallbackUrl = null) {
        if ($route && \Illuminate\Support\Facades\Route::has($route)) {
            return route($route);
        }
        return $fallbackUrl;
    };
@endphp

<footer class="bg-ctc-blue-dark text-white mt-auto overflow-hidden relative border-t-4 border-ctc-ruby" role="contentinfo">
    <div class="absolute inset-0 opacity-[0.06] pointer-events-none" aria-hidden="true">
        <svg width="100%" height="100%" preserveAspectRatio="none" viewBox="0 0 100 100">
            <path d="M0 100 Q 50 0 100 100" fill="none" stroke="white" stroke-width=".2" />
            <path d="M0 75 Q 50 -25 100 75" fill="none" stroke="white" stroke-width=".12" />
        </svg>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-10 relative">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-10 gap-y-14 mb-14">
            <div class="col-span-2 md:col-span-4 lg:col-span-2">
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="block text-[11px] font-semibold uppercase tracking-[0.22em] text-white/50">Powered by</span>
                        <span class="block text-lg font-semibold text-white/90">{{ $hospitalName }}</span>
                    </div>

                    <div class="pt-2">
                        <span class="block text-2xl font-bold tracking-tight text-white">{{ $centreName }}</span>
                        <p class="mt-3 text-white/65 text-sm leading-relaxed max-w-sm font-medium">{{ $description }}</p>
                    </div>

                    @if(count($social) > 0)
                        <div class="pt-3">
                            <p class="text-[10px] text-white/45 uppercase tracking-widest font-bold mb-2">Follow</p>
                            <div class="flex flex-wrap items-center gap-3">
                                @foreach($social as $name => $href)
                                    <a href="{{ $href }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 bg-white/5 text-white/70 hover:text-white hover:bg-white/10 transition-colors"
                                       aria-label="{{ $name }}">
                                        @switch($name)
                                            @case('Facebook')
                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M22 12a10 10 0 10-11.56 9.87v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.89 3.77-3.89 1.09 0 2.23.2 2.23.2v2.46h-1.26c-1.24 0-1.62.77-1.62 1.56V12h2.76l-.44 2.88h-2.32v6.99A10 10 0 0022 12z"/>
                                                </svg>
                                                @break
                                            @case('Instagram')
                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M7 2C4.24 2 2 4.24 2 7v10c0 2.76 2.24 5 5 5h10c2.76 0 5-2.24 5-5V7c0-2.76-2.24-5-5-5H7zm10 2a3 3 0 013 3v10a3 3 0 01-3 3H7a3 3 0 01-3-3V7a3 3 0 013-3h10zm-5 3.5A4.5 4.5 0 1016.5 12 4.5 4.5 0 0012 7.5zm0 7.4A2.9 2.9 0 1114.9 12 2.9 2.9 0 0112 14.9zM17.6 6.4a1 1 0 11-1-1 1 1 0 011 1z"/>
                                                </svg>
                                                @break
                                            @case('YouTube')
                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M21.6 7.2a2.7 2.7 0 00-1.9-1.9C18 4.9 12 4.9 12 4.9s-6 0-7.7.4A2.7 2.7 0 002.4 7.2 28.1 28.1 0 002 12a28.1 28.1 0 00.4 4.8 2.7 2.7 0 001.9 1.9c1.7.4 7.7.4 7.7.4s6 0 7.7-.4a2.7 2.7 0 001.9-1.9A28.1 28.1 0 0022 12a28.1 28.1 0 00-.4-4.8zM10 15.5V8.5L16 12l-6 3.5z"/>
                                                </svg>
                                                @break
                                            @case('X')
                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M18.9 2H22l-6.8 7.8L23 22h-6.6l-5.2-6.6L5.4 22H2l7.3-8.4L1 2h6.8l4.7 6.1L18.9 2zm-1.2 18h1.7L7.1 3.9H5.3L17.7 20z"/>
                                                </svg>
                                                @break
                                            @case('LinkedIn')
                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M4.98 3.5A2.5 2.5 0 102.5 6a2.5 2.5 0 002.48-2.5zM3 8.98h3.96V21H3V8.98zM9.5 8.98H13.3v1.64h.05c.53-1 1.83-2.06 3.77-2.06 4.03 0 4.78 2.65 4.78 6.1V21h-3.96v-5.4c0-1.29-.02-2.95-1.8-2.95-1.8 0-2.08 1.4-2.08 2.86V21H9.5V8.98z"/>
                                                </svg>
                                                @break
                                            @case('TikTok')
                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M16.7 2h-3.2v12.3c0 1.6-1.3 2.9-2.9 2.9s-2.9-1.3-2.9-2.9 1.3-2.9 2.9-2.9c.3 0 .6 0 .9.1V8.2c-.3 0-.6-.1-.9-.1-3.4 0-6.2 2.8-6.2 6.2s2.8 6.2 6.2 6.2 6.2-2.8 6.2-6.2V8.7c1.3 1 3 1.6 4.9 1.6V7.1c-2.3 0-4.2-1.9-4.2-4.2V2z"/>
                                                </svg>
                                                @break
                                            @default
                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm1 14h-2v-2h2v2zm0-4h-2V6h2v6z"/>
                                                </svg>
                                        @endswitch
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @foreach($columns as $col)
                <div class="space-y-6">
                    <h4 class="text-[0.65rem] font-bold uppercase tracking-[0.2em] text-white/55">{{ $col['title'] ?? 'Links' }}</h4>
                    <ul class="space-y-3 text-xs font-semibold text-white/60">
                        @foreach(($col['links'] ?? []) as $item)
                            @php
                                $href = $routeUrl($item['route'] ?? null, $item['url'] ?? null);
                            @endphp
                            @if($href)
                                <li>
                                    <a href="{{ $href }}" class="hover:text-white transition-colors">{{ $item['label'] ?? 'Link' }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-10 py-10 border-t border-white/10">
            <div class="col-span-2 md:col-span-2 space-y-6">
                <h4 class="text-[0.65rem] font-bold uppercase tracking-[0.2em] text-white/55">Contact</h4>
                <address class="not-italic space-y-3 text-sm text-white/70">
                    @if($address)
                        <p class="leading-relaxed">{{ $address }}</p>
                    @endif
                    @if($primaryPhone)
                        <p>
                            <span class="block text-[10px] text-white/45 uppercase tracking-widest font-bold mb-1">Phone</span>
                            <a href="tel:{{ preg_replace('/\D+/', '', $primaryPhone) }}" class="text-white/85 hover:text-white transition-colors font-semibold">{{ $primaryPhone }}</a>
                        </p>
                    @endif
                    @if($email)
                        <p>
                            <span class="block text-[10px] text-white/45 uppercase tracking-widest font-bold mb-1">Email</span>
                            <a href="mailto:{{ $email }}" class="text-white/85 hover:text-white transition-colors font-semibold break-all">{{ $email }}</a>
                        </p>
                    @endif
                </address>
            </div>

            <div class="col-span-2 md:col-span-2 lg:col-span-3 space-y-6 lg:pl-6">
                <h4 class="text-[0.65rem] font-bold uppercase tracking-[0.2em] text-white/55">Emergency access</h4>
                <div class="grid sm:grid-cols-2 gap-6">
                    <div class="rounded-xl bg-white/5 border border-white/10 p-5">
                        <span class="block text-[10px] text-white/45 uppercase tracking-widest font-bold mb-2">24/7 emergency</span>
                        @if($emergency)
                            <a href="tel:{{ preg_replace('/\D+/', '', $emergency) }}" class="block text-white font-extrabold text-lg sm:text-xl tracking-tight hover:text-ctc-secondary transition-colors">{{ $emergency }}</a>
                        @else
                            <span class="block text-white/70 text-sm">Call the main hospital line</span>
                        @endif
                    </div>
                    <div class="rounded-xl bg-white/5 border border-white/10 p-5 space-y-3">
                        <span class="block text-[10px] text-white/45 uppercase tracking-widest font-bold mb-2">Appointments</span>
                        @php
                            $bookHref = $routeUrl('book-appointment');
                            $contactHref = $routeUrl('contact');
                        @endphp
                        <div class="grid grid-cols-2 gap-3">
                            @if($bookHref)
                                <a href="{{ $bookHref }}" class="inline-flex w-full min-w-0 items-center justify-center rounded-lg bg-ctc-accent px-3 py-3 text-[10px] sm:text-[11px] font-bold uppercase tracking-[0.12em] sm:tracking-[0.18em] text-ctc-blue hover:brightness-95 transition-colors whitespace-nowrap">
                                    Book
                                </a>
                            @endif
                            @if($contactHref)
                                <a href="{{ $contactHref }}" class="inline-flex w-full min-w-0 items-center justify-center rounded-lg bg-ctc-secondary px-3 py-3 text-[10px] sm:text-[11px] font-bold uppercase tracking-[0.12em] sm:tracking-[0.18em] text-white hover:bg-ctc-secondary-dark transition-colors whitespace-nowrap">
                                    Contact Us
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-2 lg:col-span-1 flex items-end justify-start lg:justify-end">
                <div class="w-full text-left lg:text-right">
                    <p class="text-[10px] text-white/40 font-bold uppercase tracking-[0.28em]">
                        &copy; {{ date('Y') }} {{ $hospitalName }}. All rights reserved.
                    </p>
                    <p class="mt-2 text-[10px] text-white/30 font-semibold uppercase tracking-[0.22em]">
                        Cardiothoracic Centre website
                    </p>
                </div>
            </div>
        </div>

        <div class="pt-7 flex flex-wrap gap-6 text-[10px] font-bold uppercase tracking-[0.35em] text-white/35">
            @foreach($legalLinks as $item)
                @php
                    $label = $item['label'] ?? null;
                    $href = $routeUrl($item['route'] ?? null, $item['url'] ?? null);
                @endphp
                @if($href && $label)
                    <a href="{{ $href }}" class="hover:text-white transition-colors">{{ $label }}</a>
                @elseif($label && ! $href)
                    <span class="text-white/25">{{ $label }}</span>
                @endif
            @endforeach
        </div>
    </div>
</footer>
