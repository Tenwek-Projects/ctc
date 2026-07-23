@extends('layouts.app')

@section('title', 'International Patients')

@php
    $address = $contact?->address ?: config('ctc.contact.address');
    $phone = $contact?->phone ?: config('ctc.contact.phone');
    $email = $contact?->email ?: config('ctc.contact.email');
    $appointmentsPhone = $contact?->appointments_phone;
    $whatsapp = $contact?->whatsapp;
@endphp

@section('content')
    @include('components.page-banner', [
        'title' => 'International Patients',
        'subtitle' => config('ctc.hospital'),
        'bannerKey' => 'international_patients',
    ])

    {{-- Intro + trust strip --}}
    <section class="relative py-14 lg:py-20 bg-white">
        <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-ctc-secondary/40 to-transparent" aria-hidden="true"></div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-accent">Global access to care</p>
                <h2 class="mt-3 font-headline text-2xl sm:text-3xl font-extrabold tracking-tight text-ctc-blue">
                    Cardiothoracic excellence for patients travelling to Kenya
                </h2>
                <p class="mt-4 text-gray-600 leading-relaxed text-[1.02rem]">
                    We welcome patients from across Africa and beyond for consultation, surgery, and follow-up.
                    Our team helps coordinate referrals, medical review, and practical planning so you can focus on your health.
                </p>
            </div>

            <div class="mt-10 grid sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
                @foreach([
                    ['label' => 'Coordinated pathway', 'text' => 'Structured steps from first enquiry to arrival and discharge.'],
                    ['label' => 'Clinical review', 'text' => 'Remote review of records before you travel when appropriate.'],
                    ['label' => 'Transparent communication', 'text' => 'Clear timelines, expectations, and points of contact.'],
                    ['label' => 'Continuity of care', 'text' => 'Follow-up planning and liaison with your home clinicians.'],
                ] as $item)
                    <div class="rounded-2xl border border-gray-200/90 bg-gradient-to-b from-white to-ctc-grey-light/40 p-5 shadow-sm hover:shadow-md hover:border-ctc-blue/15 transition-shadow">
                        <div class="flex items-center gap-2 text-[11px] font-extrabold uppercase tracking-[0.18em] text-ctc-blue/80">
                            <span class="h-2 w-2 rounded-full bg-ctc-accent shadow-[0_0_0_4px_rgba(179,49,39,0.2)]"></span>
                            {{ $item['label'] }}
                        </div>
                        <p class="mt-3 text-sm text-gray-600 leading-relaxed">{{ $item['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Care pathway --}}
    <section class="py-14 lg:py-20 bg-ctc-grey-light/80 border-y border-gray-200/80">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mb-12">
                <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-secondary">Your journey</p>
                <h2 class="mt-3 font-headline text-2xl sm:text-3xl font-extrabold tracking-tight text-ctc-blue">Four steps from enquiry to treatment</h2>
                <p class="mt-3 text-gray-600 leading-relaxed">A typical pathway; your team will tailor details to your condition and travel needs.</p>
            </div>

            <ol class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                @foreach([
                    ['step' => '1', 'title' => 'Enquiry & records', 'body' => 'Contact us with a short summary of your condition. Share recent reports, imaging, and medication list where possible.'],
                    ['step' => '2', 'title' => 'Clinical alignment', 'body' => 'Our specialists review your case, advise on suitability and timing, and outline the proposed care plan and stay.'],
                    ['step' => '3', 'title' => 'Travel planning', 'body' => 'Confirm dates, length of stay, companion arrangements, and any pre-travel tests or documents we request.'],
                    ['step' => '4', 'title' => 'Arrival & care', 'body' => 'Register at the hospital, meet your team, complete assessments, and proceed with treatment and follow-up as planned.'],
                ] as $i => $step)
                    <li class="relative flex gap-4 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[linear-gradient(135deg,rgba(26,26,104,0.08),rgba(98,163,161,0.12))] font-headline text-lg font-extrabold text-ctc-blue">
                            {{ $step['step'] }}
                        </div>
                        <div>
                            <h3 class="font-headline text-lg font-bold text-ctc-blue">{{ $step['title'] }}</h3>
                            <p class="mt-2 text-sm text-gray-600 leading-relaxed">{{ $step['body'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- Preparation + arrival --}}
    <section class="py-14 lg:py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-2 lg:gap-14 max-w-6xl mx-auto">
                <div class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8 shadow-sm">
                    <h2 class="font-headline text-xl font-extrabold text-ctc-blue">Before you travel</h2>
                    <p class="mt-2 text-sm text-gray-600">Gathering information early helps us plan safe, efficient care.</p>
                    <ul class="mt-6 space-y-4">
                        @foreach([
                            'Recent clinic letters, discharge summaries, and surgical history (if any).',
                            'Imaging on disc or secure link (echo, CT, MRI, cath reports) with dates and facility names.',
                            'Current medications and allergies; vaccination status if relevant.',
                            'Passport copy and insurance / funding details if you wish to discuss billing early.',
                        ] as $line)
                            <li class="flex gap-3 text-sm text-gray-700 leading-relaxed">
                                <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-ctc-secondary"></span>
                                <span>{{ $line }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <a href="{{ route('patient-information') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-ctc-blue hover:text-ctc-blue-dark">
                            Patient information &amp; preparing for care
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </a>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8 shadow-sm">
                    <h2 class="font-headline text-xl font-extrabold text-ctc-blue">On arrival &amp; during your stay</h2>
                    <p class="mt-2 text-sm text-gray-600">What most international visitors can expect at Tenwek Hospital.</p>
                    <ul class="mt-6 space-y-4">
                        @foreach([
                            'Hospital registration and identification verification.',
                            'Introduction to your care coordinator and treating team.',
                            'In-person assessments and any additional tests before procedures.',
                            'Discharge planning, medication instructions, and follow-up contacts.',
                        ] as $line)
                            <li class="flex gap-3 text-sm text-gray-700 leading-relaxed">
                                <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-ctc-accent"></span>
                                <span>{{ $line }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <p class="mt-6 text-xs text-gray-500 leading-relaxed">
                        Visa and entry requirements depend on your nationality. Check the latest guidance from Kenyan immigration authorities and allow time for any visas or travel documents.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Quick contact bar --}}
    <section class="py-12 bg-ctc-blue text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
                <div class="max-w-xl">
                    <h2 class="font-headline text-xl sm:text-2xl font-extrabold">Speak with our coordination team</h2>
                    <p class="mt-2 text-white/80 text-sm leading-relaxed">
                        For international referrals, appointment requests, and travel-related questions, use the channel that works best for you.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row flex-wrap gap-3">
                    @if($appointmentsPhone)
                        <a href="tel:{{ preg_replace('/\s+/', '', $appointmentsPhone) }}"
                           class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-bold text-ctc-blue shadow-lg hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 shrink-0 opacity-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            Appointments
                        </a>
                    @endif
                    <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}"
                       class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/35 bg-white/10 px-5 py-3 text-sm font-bold text-white backdrop-blur-sm hover:bg-white/15 transition-colors">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        {{ $phone }}
                    </a>
                    <a href="mailto:{{ $email }}"
                       class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/35 bg-white/10 px-5 py-3 text-sm font-bold text-white backdrop-blur-sm hover:bg-white/15 transition-colors">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Email
                    </a>
                    @if($whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $whatsapp) }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center justify-center gap-2 rounded-xl border border-emerald-300/50 bg-emerald-500/20 px-5 py-3 text-sm font-bold text-white hover:bg-emerald-500/30 transition-colors">
                            WhatsApp
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="py-14 lg:py-20 bg-white" x-data="{ open: null }">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-3xl">
            <h2 class="font-headline text-2xl font-extrabold text-ctc-blue">Frequently asked questions</h2>
            <p class="mt-2 text-gray-600 text-sm">Quick answers for international visitors. For case-specific advice, contact us directly.</p>

            <div class="mt-8 divide-y divide-gray-200 rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                @foreach([
                    ['id' => 1, 'q' => 'Do I need a referral?', 'a' => 'A formal referral from your physician is helpful but not always required for an initial enquiry. We will advise what documentation we need after we understand your situation.'],
                    ['id' => 2, 'q' => 'How long should I plan to stay?', 'a' => 'Length of stay depends on your procedure and recovery. Your team will give an estimated range after reviewing your records; plan flexibility where possible.'],
                    ['id' => 3, 'q' => 'Can family or a companion travel with me?', 'a' => 'Yes. Let us know if you need guidance on visitor policies, accommodation in the area, or local support services.'],
                    ['id' => 4, 'q' => 'How are fees and payment handled?', 'a' => 'We can outline typical cost areas and payment expectations during coordination. Bring insurance or sponsor letters early if they apply to your care.'],
                    ['id' => 5, 'q' => 'Is English spoken in the hospital?', 'a' => 'Clinical and administrative communication is primarily in English. Tell us if you need language support and we will advise what arrangements may be possible.'],
                ] as $faq)
                    <div class="border-b border-gray-100 last:border-b-0">
                        <h3>
                            <button type="button"
                                    id="faq-btn-{{ $faq['id'] }}"
                                    class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left font-headline text-sm font-bold text-ctc-blue hover:bg-ctc-grey-light/50 transition-colors"
                                    @click="open = open === {{ $faq['id'] }} ? null : {{ $faq['id'] }}"
                                    :aria-expanded="open === {{ $faq['id'] }}"
                                    aria-controls="faq-panel-{{ $faq['id'] }}">
                                <span>{{ $faq['q'] }}</span>
                                <svg class="w-5 h-5 shrink-0 text-ctc-secondary transition-transform" :class="open === {{ $faq['id'] }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </h3>
                        <div id="faq-panel-{{ $faq['id'] }}"
                             role="region"
                             aria-labelledby="faq-btn-{{ $faq['id'] }}"
                             x-show="open === {{ $faq['id'] }}"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-1"
                             x-cloak
                             class="border-t border-gray-100 bg-ctc-grey-light/30 px-5 py-4 text-sm text-gray-600 leading-relaxed">
                            {{ $faq['a'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Location + CTA --}}
    <section class="py-14 lg:py-20 bg-ctc-grey-light border-t border-gray-200/80">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto grid gap-10 lg:grid-cols-12 lg:gap-12 items-start">
                <div class="lg:col-span-5">
                    <h2 class="font-headline text-xl font-extrabold text-ctc-blue">Find us</h2>
                    <p class="mt-3 text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ $address }}</p>
                    <div class="mt-6 flex flex-col sm:flex-row flex-wrap gap-3">
                        <a href="{{ route('book-appointment') }}"
                           class="inline-flex items-center justify-center rounded-xl bg-ctc-blue px-6 py-3 text-sm font-bold text-white shadow-md hover:bg-ctc-blue-dark transition-colors">
                            Book appointment
                        </a>
                        <a href="{{ route('contact') }}"
                           class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-6 py-3 text-sm font-bold text-ctc-blue hover:border-ctc-blue/30 transition-colors">
                            Contact form
                        </a>
                        <a href="{{ route('services') }}"
                           class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-6 py-3 text-sm font-bold text-ctc-blue hover:border-ctc-blue/30 transition-colors">
                            Our services
                        </a>
                    </div>
                </div>
                <div class="lg:col-span-7 rounded-2xl border border-gray-200 bg-white p-2 shadow-sm overflow-hidden">
                    <div class="aspect-[16/10] rounded-xl bg-ctc-grey-light overflow-hidden">
                        <iframe
                            title="Tenwek Hospital Cardiothoracic Centre on Google Maps"
                            src="{{ $contact?->map_embed_url ?: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255328.57190435287!2d35.412123193156454!3d-0.713531316170022!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182b99e773d0b419%3A0x9a894bffe3e322cd!2sAGC%20Tenwek%20Cardiothoracic%20Centre!5e0!3m2!1sen!2ske!4v1778251323615!5m2!1sen!2ske' }}"
                            class="h-full w-full border-0"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            allowfullscreen
                        ></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
