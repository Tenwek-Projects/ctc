@extends('layouts.app')

@section('title', $service->name)

@section('content')
    @include('components.page-banner', [
        'title' => $service->name,
        'subtitle' => 'Our Services',
        'bannerKey' => 'service_show',
    ])

    <section class="py-16 lg:py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-12 items-start">
                <article class="lg:col-span-8">
                    <div class="rounded-2xl bg-white border border-gray-200 shadow-sm p-6 sm:p-8">
                        @if($service->featured_image_url)
                            <div class="mb-6 aspect-video rounded-2xl overflow-hidden border border-gray-200 bg-gray-50">
                                <img src="{{ $service->featured_image_url }}" alt="{{ $service->name }}" class="h-full w-full object-cover" loading="eager" fetchpriority="high">
                            </div>
                        @endif
                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-accent">
                            {{ str_replace('_', ' ', ucfirst($service->category)) }}
                        </p>
                        <h2 class="mt-3 text-2xl sm:text-3xl font-headline font-extrabold tracking-tight text-ctc-blue">
                            {{ $service->name }}
                        </h2>

                        @if($service->description)
                            <div class="ctc-service-prose mt-6 prose prose-slate max-w-none text-[1.05rem]
                                        prose-headings:font-headline prose-headings:text-ctc-blue
                                        prose-p:text-gray-700 prose-p:leading-relaxed
                                        prose-strong:text-ctc-blue prose-strong:font-semibold
                                        prose-a:text-ctc-secondary prose-a:font-semibold">
                                {!! \App\Support\TrixHtmlSanitizer::normalizeBlocksForDisplay($service->description ?? '') !!}
                            </div>
                        @endif

                        <div class="ctc-service-prose mt-10 border-t border-gray-100 pt-8 prose prose-slate max-w-none
                                    prose-headings:font-headline prose-headings:text-ctc-blue
                                    prose-p:text-gray-700 prose-p:leading-relaxed
                                    prose-strong:text-ctc-blue prose-strong:font-semibold
                                    prose-a:text-ctc-secondary prose-a:font-semibold">
                            <h3>What this service includes</h3>
                            <p>
                                Our team provides patient‑centred evaluation, safe peri‑operative care, and follow‑up planning. We work with referring clinicians
                                to ensure each patient receives the right tests and the right pathway, from consultation through recovery.
                            </p>

                            <h3>When to refer</h3>
                            <p>
                                If you are a clinician, refer patients with suspected cardiac or thoracic disease needing specialist review. Patients and families
                                can also contact us to learn the next steps and how to share medical records for review.
                            </p>

                            <h3>Appointments and referrals</h3>
                            <p>
                                For appointments, referrals, or international patient coordination, please contact our team. We’ll guide you on the information
                                needed and expected timelines.
                            </p>
                        </div>

                        <div class="mt-10 flex flex-wrap items-center gap-3">
                            <a href="{{ route('book-appointment') }}"
                               class="inline-flex items-center justify-center gap-2 rounded-xl px-6 py-3.5 font-headline font-bold uppercase text-[0.62rem] tracking-[0.18em] text-white shadow-[0_18px_45px_rgba(0,0,0,0.18)]
                                      bg-[linear-gradient(135deg,rgba(26,26,104,0.95),rgba(98,163,161,0.92))] hover:brightness-105 transition-all">
                                Book appointment
                                <span class="h-2 w-2 rounded-full bg-ctc-accent shadow-[0_0_0_4px_rgba(158, 196, 248,0.22)]"></span>
                            </a>
                            <a href="{{ route('contact') }}"
                               class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-6 py-3.5 text-[0.62rem] font-bold uppercase tracking-[0.18em] text-ctc-blue hover:bg-ctc-grey-light transition-colors">
                                General enquiry
                            </a>
                            <a href="{{ route('services') . '#' . $service->category }}"
                               class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-6 py-3.5 text-[0.62rem] font-bold uppercase tracking-[0.18em] text-ctc-blue hover:bg-ctc-grey-light transition-colors">
                                Back to services
                            </a>
                        </div>
                    </div>
                </article>

                <aside class="lg:col-span-4">
                    <div class="sticky top-24 space-y-6">
                        <div class="rounded-2xl bg-white border border-gray-200 shadow-sm p-6">
                            <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-secondary">Need help?</p>
                            <h3 class="mt-3 text-lg font-bold text-gray-900">Talk to the team</h3>
                            <p class="mt-2 text-sm text-gray-600">Request a visit or send a general message.</p>
                            <a href="{{ route('book-appointment') }}" class="mt-5 inline-flex w-full items-center justify-center rounded-xl bg-ctc-blue px-5 py-3 text-[11px] font-bold uppercase tracking-[0.18em] text-white hover:bg-ctc-blue-dark transition-colors">
                                Book appointment
                            </a>
                            <a href="{{ route('contact') }}" class="mt-2 inline-flex w-full items-center justify-center rounded-xl border border-gray-200 bg-white px-5 py-3 text-[11px] font-bold uppercase tracking-[0.18em] text-ctc-blue hover:bg-ctc-grey-light transition-colors">
                                Contact us
                            </a>
                        </div>

                        <div class="rounded-2xl bg-white border border-gray-200 shadow-sm p-6">
                            <h3 class="text-sm font-bold uppercase tracking-widest text-gray-500">Related services</h3>
                            <div class="mt-4 space-y-3">
                                @forelse($related as $r)
                                    <a href="{{ route('services.show', $r) }}" class="block group">
                                        <p class="text-sm font-semibold text-gray-900 group-hover:text-ctc-blue transition-colors line-clamp-2">{{ $r->name }}</p>
                                        @if($r->description)
                                            <p class="mt-1 text-xs text-gray-500 line-clamp-2">{{ str($r->description)->stripTags()->limit(120) }}</p>
                                        @endif
                                    </a>
                                @empty
                                    <p class="text-sm text-gray-600">More services will appear here.</p>
                                @endforelse
                            </div>
                            <a href="{{ route('services') }}" class="mt-5 inline-flex items-center text-sm font-semibold text-ctc-secondary hover:underline">
                                View all services →
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection

