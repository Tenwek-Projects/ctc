@extends('layouts.app')

@section('title', 'Book an appointment')

@php
    $contact = $contact ?? null;
    $address = $contact?->address ?: config('ctc.contact.address');
    $phone = $contact?->phone ?: config('ctc.contact.phone');
    $email = $contact?->email ?: config('ctc.contact.email');
    $emergency = $contact?->emergency_phone ?: config('ctc.contact.emergency');
    $appointmentsPhone = $contact?->appointments_phone;
    $mathA = $mathA ?? 0;
    $mathB = $mathB ?? 0;
    $minDate = now()->format('Y-m-d');
@endphp

@section('content')
    @include('components.page-banner', [
        'title' => 'Book an appointment',
        'subtitle' => config('ctc.name'),
        'bannerKey' => 'book_appointment',
    ])

    <section class="py-14 lg:py-20 bg-gradient-to-b from-white to-ctc-grey-light/40">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <p class="flex items-center justify-center gap-2 text-center text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-ruby max-w-2xl mx-auto">
                    <x-icon-calendar class="h-4 w-4 shrink-0 text-ctc-ruby" />
                    <span>Request a visit</span>
                </p>
                <p class="mt-4 text-center text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    Share your details and preferred timing. Our coordination team will review your request and contact you, usually within a few business days, to confirm or suggest alternatives.
                </p>

                <div class="mt-12 lg:mt-14 grid lg:grid-cols-12 gap-10 lg:gap-12 items-start">
                    {{-- Form --}}
                    <div class="lg:col-span-7 order-2 lg:order-1">
                        <div class="relative rounded-3xl border border-gray-200/90 bg-white shadow-[0_20px_50px_-20px_rgba(26,26,104,0.15)] overflow-hidden">
                            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-ctc-blue via-emerald-500 to-[var(--color-ctc-gold)]" aria-hidden="true"></div>

                            <div class="p-6 sm:p-8 lg:p-10">
                                <div class="flex flex-wrap gap-3 mb-8">
                                    <span class="inline-flex items-center gap-2 rounded-full bg-ctc-blue/[0.06] border border-ctc-blue/15 px-3 py-1 text-xs font-semibold text-ctc-blue">
                                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-ctc-blue text-white text-[11px] font-extrabold">1</span>
                                        Your details
                                    </span>
                                    <span class="inline-flex items-center gap-2 rounded-full bg-gray-50 border border-gray-200 px-3 py-1 text-xs font-semibold text-gray-700">
                                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-200 text-gray-700 text-[11px] font-extrabold">2</span>
                                        Visit type &amp; date
                                    </span>
                                    <span class="inline-flex items-center gap-2 rounded-full bg-gray-50 border border-gray-200 px-3 py-1 text-xs font-semibold text-gray-700">
                                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-200 text-gray-700 text-[11px] font-extrabold">3</span>
                                        Notes &amp; send
                                    </span>
                                </div>

                                @if(session('success'))
                                    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-4 text-sm text-emerald-900 flex gap-3">
                                        <span class="shrink-0 mt-0.5 flex h-8 w-8 items-center justify-center rounded-full bg-emerald-200/80 text-emerald-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        </span>
                                        <div>
                                            <p class="font-semibold">Request received</p>
                                            <p class="mt-1 text-emerald-800/90">{{ session('success') }}</p>
                                            <p class="mt-3 text-xs text-emerald-800/80">For urgent medical concerns, call the emergency line shown on this page.</p>
                                        </div>
                                    </div>
                                @endif

                                <form action="{{ route('book-appointment.submit') }}" method="post" class="space-y-6">
                                    @csrf
                                    <div class="hidden" aria-hidden="true">
                                        <label for="website">Leave blank</label>
                                        <input type="text" name="website" id="website" tabindex="-1" autocomplete="off" value="{{ old('website') }}">
                                    </div>

                                    <div class="grid sm:grid-cols-2 gap-5">
                                        <div class="sm:col-span-2">
                                            <label for="patient_name" class="block text-sm font-medium text-gray-800 mb-1.5">Full name <span class="text-red-500">*</span></label>
                                            <input type="text" name="patient_name" id="patient_name" required
                                                   class="ctc-field w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-ctc-blue focus:border-ctc-blue"
                                                   placeholder="As it should appear on records"
                                                   value="{{ old('patient_name') }}">
                                            @error('patient_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                        </div>
                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-800 mb-1.5">Email <span class="text-red-500">*</span></label>
                                            <input type="email" name="email" id="email" required
                                                   class="ctc-field w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-ctc-blue focus:border-ctc-blue"
                                                   placeholder="you@example.com"
                                                   value="{{ old('email') }}">
                                            @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                        </div>
                                        <div>
                                            <label for="phone" class="block text-sm font-medium text-gray-800 mb-1.5">Phone <span class="text-gray-400 font-normal">(recommended)</span></label>
                                            <input type="tel" name="phone" id="phone"
                                                   class="ctc-field w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-ctc-blue focus:border-ctc-blue"
                                                   placeholder="+254 …"
                                                   value="{{ old('phone') }}">
                                            @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                        </div>
                                    </div>

                                    <div class="grid sm:grid-cols-2 gap-5 pt-2 border-t border-gray-100">
                                        <div>
                                            <label for="type" class="block text-sm font-medium text-gray-800 mb-1.5">Type of request <span class="text-red-500">*</span></label>
                                            <select name="type" id="type" required
                                                    class="ctc-field w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-ctc-blue focus:border-ctc-blue bg-white">
                                                <option value="" disabled {{ old('type') ? '' : 'selected' }}>Select…</option>
                                                <option value="appointment" @selected(old('type') === 'appointment')>Outpatient / follow-up appointment</option>
                                                <option value="consultation" @selected(old('type') === 'consultation')>New consultation / referral discussion</option>
                                            </select>
                                            @error('type')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                        </div>
                                        <div>
                                            <label for="requested_date" class="block text-sm font-medium text-gray-800 mb-1.5">Preferred date <span class="text-gray-400 font-normal">(optional)</span></label>
                                            <input type="date" name="requested_date" id="requested_date" min="{{ $minDate }}"
                                                   class="ctc-field w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-ctc-blue focus:border-ctc-blue"
                                                   value="{{ old('requested_date') }}">
                                            @error('requested_date')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                            <p class="mt-1.5 text-xs text-gray-500">We will confirm availability; another date may be offered.</p>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="notes" class="block text-sm font-medium text-gray-800 mb-1.5">Clinical notes or context <span class="text-gray-400 font-normal">(optional)</span></label>
                                        <textarea name="notes" id="notes" rows="4"
                                                  class="ctc-field w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-ctc-blue focus:border-ctc-blue resize-y min-h-[6rem]"
                                                  placeholder="e.g. referral from…, procedure interest, recent tests, international travel dates">{{ old('notes') }}</textarea>
                                        @error('notes')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="rounded-2xl border border-amber-200/80 bg-amber-50/60 px-4 py-4">
                                        <label for="math_answer" class="block text-sm font-medium text-amber-950 mb-2">
                                            Anti-spam: what is {{ (int) $mathA }} + {{ (int) $mathB }}?
                                        </label>
                                        <input type="number" name="math_answer" id="math_answer" required inputmode="numeric"
                                               class="ctc-field max-w-[12rem] rounded-xl border border-amber-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                               placeholder="Answer"
                                               value="{{ old('math_answer') }}">
                                        @error('math_answer')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-2">
                                        <p class="text-xs text-gray-500 max-w-md leading-relaxed">
                                            Submitting this form does not guarantee a specific slot. See our <a href="{{ route('terms-of-service') }}" class="text-ctc-blue font-medium hover:underline">terms</a> and <a href="{{ route('privacy-policy') }}" class="text-ctc-blue font-medium hover:underline">privacy policy</a>.
                                        </p>
                                        <button type="submit"
                                                class="ctc-magnetic inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-xl font-semibold text-sm bg-ctc-blue text-white hover:bg-ctc-blue-dark shadow-lg shadow-ctc-blue/20 transition-colors shrink-0">
                                            <x-icon-calendar class="h-4 w-4 shrink-0 opacity-95" />
                                            Submit request
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Sidebar --}}
                    <aside class="lg:col-span-5 order-1 lg:order-2 space-y-5 lg:sticky lg:top-28">
                        <div class="rounded-2xl border border-red-200 bg-gradient-to-br from-red-50 to-white p-5 sm:p-6">
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-red-900/90">Urgent or emergency</p>
                            <p class="mt-2 text-sm text-gray-700">For life-threatening symptoms, seek emergency care immediately.</p>
                            <a href="tel:{{ preg_replace('/\s+/', '', $emergency) }}" class="mt-4 inline-flex items-center gap-2 text-lg font-bold text-gray-900 hover:text-ctc-blue transition-colors">
                                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100 text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </span>
                                {{ $emergency }}
                            </a>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 shadow-sm">
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-800">Call the centre</p>
                            <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="mt-3 block text-base font-semibold text-ctc-blue hover:underline">{{ $phone }}</a>
                            @if(!empty($appointmentsPhone))
                                <p class="mt-4 text-xs font-bold uppercase tracking-[0.18em] text-gray-500">Appointments line</p>
                                <a href="tel:{{ preg_replace('/\s+/', '', $appointmentsPhone) }}" class="mt-2 block text-sm font-semibold text-ctc-blue hover:underline">{{ $appointmentsPhone }}</a>
                            @endif
                            <p class="mt-4 text-xs font-bold uppercase tracking-[0.18em] text-gray-500">Email</p>
                            <a href="mailto:{{ $email }}" class="mt-2 block text-sm font-semibold text-ctc-blue hover:underline break-all">{{ $email }}</a>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 shadow-sm">
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-gray-500">Not scheduling?</p>
                            <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                                For general questions, media, or non-appointment messages, use the contact form instead.
                            </p>
                            <a href="{{ route('contact') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-ctc-blue hover:underline">
                                Go to contact
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>

                        <div class="rounded-2xl border border-emerald-100 bg-emerald-50/40 p-5 sm:p-6">
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-900">Before you arrive</p>
                            <p class="mt-2 text-sm text-gray-700 leading-relaxed">{{ \Illuminate\Support\Str::limit($address, 120) }}</p>
                            <a href="{{ route('patient-information') }}" class="mt-3 inline-flex text-sm font-semibold text-emerald-900 hover:underline">Patient information →</a>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
@endsection
