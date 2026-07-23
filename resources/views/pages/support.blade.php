@extends('layouts.app')

@section('title', 'Support the CTC')

@php($metaDescription = 'Support Tenwek CTC through donations, sponsoring surgeries, and helping equip life-saving cardiothoracic care for patients across the region.')

@section('content')
    @include('components.page-banner', [
        'title' => 'Support the CTC',
        'subtitle' => config('ctc.name'),
        'bannerKey' => 'support',
    ])

    <section class="py-16 lg:py-20" x-data="supportModals()" x-cloak>
        @if(session('success'))
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 mb-8">
                <div class="max-w-5xl rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 max-w-6xl lg:grid-cols-12 items-stretch">
                <div class="lg:col-span-8">
                    <div class="grid md:grid-cols-2 gap-10">
                        {{-- Donate: M-Pesa + Stripe CTAs --}}
                        <div class="p-6 rounded-xl bg-white border border-gray-200 shadow-sm flex flex-col">
                            <h2 class="text-2xl font-bold text-gray-900 mb-3">Donate</h2>
                            <p class="text-gray-600 leading-relaxed mb-6 flex-grow">General donations support our daily operations, from equipment and supplies to patient care. Every gift makes a difference.</p>
                            <div class="flex flex-wrap gap-3">
                                <button type="button" @click="openModal('mpesa')"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg font-medium bg-[#0cb318] text-white hover:bg-[#0a9b14] transition-colors shadow-sm">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm3.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                                    M-Pesa
                                </button>
                                <button type="button" @click="openModal('stripe')"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg font-medium bg-[#635bff] text-white hover:bg-[#5851e8] transition-colors shadow-sm">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13.976 9.15c-2.172-.806-3.356-1.426-3.356-2.409 0-.831.683-1.305 1.901-1.305 2.227 0 4.515.858 6.09 1.631l.89-5.494C18.252 1.5 15.697.5 12.165.5c-3.533 0-6.093 1.072-6.093 3.752 0 2.381 2.39 3.57 5.018 4.377 2.634.807 3.78 1.426 3.78 2.409 0 .98-.716 1.562-2.078 1.562-1.875 0-4.965-.921-6.99-2.109l-.9 5.555C5.175 22.99 8.385 24 11.714 24c3.366 0 5.785-1.042 5.785-3.711 0-2.381-2.362-3.537-4.523-4.139z"/></svg>
                                    Card (Stripe)
                                </button>
                            </div>
                        </div>

                        <div class="p-6 rounded-xl bg-white border border-gray-200 shadow-sm flex flex-col">
                            <h2 class="text-2xl font-bold text-gray-900 mb-3">Sponsor a Surgery</h2>
                            <p class="text-gray-600 leading-relaxed mb-6 flex-grow">Many patients cannot afford the full cost of surgery. Sponsoring a surgery allows us to offer life-saving care to those in need.</p>
                            <button type="button" @click="openEnquiry('sponsor')"
                                    class="self-start inline-flex items-center px-5 py-2.5 rounded-lg font-medium bg-ctc-blue text-white hover:bg-ctc-blue-dark transition-colors">
                                Send enquiry
                            </button>
                        </div>

                        <div class="p-6 rounded-xl bg-white border border-gray-200 shadow-sm flex flex-col">
                            <h2 class="text-2xl font-bold text-gray-900 mb-3">Equipment Needs</h2>
                            <p class="text-gray-600 leading-relaxed mb-6 flex-grow">We maintain a list of current equipment needs, from surgical instruments to imaging and monitoring equipment.</p>
                            <button type="button" @click="openEnquiry('equipment')"
                                    class="self-start inline-flex items-center px-5 py-2.5 rounded-lg font-medium bg-ctc-blue text-white hover:bg-ctc-blue-dark transition-colors">
                                Send enquiry
                            </button>
                        </div>

                        <div class="p-6 rounded-xl bg-white border border-gray-200 shadow-sm flex flex-col">
                            <h2 class="text-2xl font-bold text-gray-900 mb-3">Partner With Us</h2>
                            <p class="text-gray-600 leading-relaxed mb-6 flex-grow">Hospitals, universities, and NGOs can partner with the CTC in training, research, or clinical support.</p>
                            <button type="button" @click="openEnquiry('partner')"
                                    class="self-start inline-flex items-center px-5 py-2.5 rounded-lg font-medium bg-ctc-blue text-white hover:bg-ctc-blue-dark transition-colors">
                                Send enquiry
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Right-side image (matches cards column height) --}}
                <div class="lg:col-span-4 self-stretch">
                    <div class="h-full rounded-2xl overflow-hidden border border-gray-200 bg-ctc-grey-light shadow-sm">
                        <img
                            src="{{ (\App\Support\SiteImage::urlFor('support_side') ?: \App\Support\PageBanner::defaultUrl()) }}"
                            alt="Support the Cardiothoracic Centre"
                            class="h-full w-full object-cover"
                            loading="lazy"
                        >
                    </div>
                </div>
            </div>
        </div>

        {{-- M-Pesa STK modal --}}
        <div x-show="currentModal === 'mpesa'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" @keydown.escape.window="currentModal = null" role="dialog" aria-modal="true" :aria-label="'Pay with M-Pesa'">
            <div x-show="currentModal === 'mpesa'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                 @click.outside="currentModal = null" class="relative w-full max-w-md rounded-2xl bg-white shadow-xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Pay with M-Pesa</h3>
                    <button type="button" @click="currentModal = null" class="p-2 rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600" aria-label="Close">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <p class="text-sm text-gray-500 mb-4">You will receive an STK push on your phone to complete the payment.</p>
                <form @submit.prevent="submitMpesa" class="space-y-4">
                    <div>
                        <label for="mpesa-phone" class="block text-sm font-medium text-gray-700 mb-1">M-Pesa phone number</label>
                        <input type="tel" id="mpesa-phone" x-model="mpesa.phone" placeholder="07XX XXX XXX" required
                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:ring-2 focus:ring-ctc-secondary focus:border-ctc-secondary">
                    </div>
                    <div>
                        <label for="mpesa-amount" class="block text-sm font-medium text-gray-700 mb-1">Amount (KES)</label>
                        <input type="number" id="mpesa-amount" x-model="mpesa.amount" min="10" step="1" placeholder="500" required
                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:ring-2 focus:ring-ctc-secondary focus:border-ctc-secondary">
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="button" @click="currentModal = null" class="flex-1 px-4 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium">Cancel</button>
                        <button type="submit" class="flex-1 px-4 py-2.5 rounded-lg font-medium bg-[#0cb318] text-white hover:bg-[#0a9b14]">
                            Send STK Push
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Stripe card modal --}}
        <div x-show="currentModal === 'stripe'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" @keydown.escape.window="currentModal = null" role="dialog" aria-modal="true" :aria-label="'Pay with card'">
            <div x-show="currentModal === 'stripe'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                 @click.outside="currentModal = null" class="relative w-full max-w-md rounded-2xl bg-white shadow-xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Pay with card</h3>
                    <button type="button" @click="currentModal = null" class="p-2 rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600" aria-label="Close">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <p class="text-sm text-gray-500 mb-4">Secure payment powered by Stripe.</p>
                <form @submit.prevent="submitStripe" class="space-y-4">
                    <div>
                        <label for="card-number" class="block text-sm font-medium text-gray-700 mb-1">Card number</label>
                        <input type="text" id="card-number" x-model="stripe.cardNumber" placeholder="4242 4242 4242 4242" maxlength="19" inputmode="numeric" autocomplete="cc-number"
                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:ring-2 focus:ring-[#635bff] focus:border-[#635bff] font-mono">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="card-expiry" class="block text-sm font-medium text-gray-700 mb-1">Expiry</label>
                            <input type="text" id="card-expiry" x-model="stripe.expiry" placeholder="MM/YY" maxlength="5" inputmode="numeric" autocomplete="cc-exp"
                                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:ring-2 focus:ring-[#635bff] focus:border-[#635bff] font-mono">
                        </div>
                        <div>
                            <label for="card-cvc" class="block text-sm font-medium text-gray-700 mb-1">CVC</label>
                            <input type="text" id="card-cvc" x-model="stripe.cvc" placeholder="123" maxlength="4" inputmode="numeric" autocomplete="cc-csc"
                                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:ring-2 focus:ring-[#635bff] focus:border-[#635bff] font-mono">
                        </div>
                    </div>
                    <div>
                        <label for="card-amount" class="block text-sm font-medium text-gray-700 mb-1">Amount (KES)</label>
                        <input type="number" id="card-amount" x-model="stripe.amount" min="100" step="1" placeholder="1000"
                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:ring-2 focus:ring-[#635bff] focus:border-[#635bff]">
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="button" @click="currentModal = null" class="flex-1 px-4 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium">Cancel</button>
                        <button type="submit" class="flex-1 px-4 py-2.5 rounded-lg font-medium bg-[#635bff] text-white hover:bg-[#5851e8]">
                            Pay
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Enquiry modal --}}
        <div x-show="currentModal === 'enquiry'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" @keydown.escape.window="currentModal = null" role="dialog" aria-modal="true" aria-label="Send enquiry">
            <div x-show="currentModal === 'enquiry'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                 @click.outside="currentModal = null" class="relative w-full max-w-md rounded-2xl bg-white shadow-xl p-6 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900" x-text="enquiryTitle"></h3>
                    <button type="button" @click="currentModal = null" class="p-2 rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600" aria-label="Close">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form action="{{ route('support.enquiry.submit') }}" method="post" class="space-y-4">
                    @csrf
                    {{-- Honeypot: bots fill this, humans don't --}}
                    <div class="hidden" aria-hidden="true">
                        <label for="website">Website</label>
                        <input type="text" name="website" id="website" tabindex="-1" autocomplete="off" value="">
                    </div>
                    <input type="hidden" name="enquiry_type" :value="enquiryType">
                    <div>
                        <label for="enquiry-name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" name="name" id="enquiry-name" required
                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:ring-2 focus:ring-ctc-blue focus:border-ctc-blue"
                               placeholder="Your name">
                    </div>
                    <div>
                        <label for="enquiry-email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="enquiry-email" required
                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:ring-2 focus:ring-ctc-blue focus:border-ctc-blue"
                               placeholder="your@email.com">
                    </div>
                    <div>
                        <label for="enquiry-message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea name="message" id="enquiry-message" rows="4" required
                                  class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:ring-2 focus:ring-ctc-blue focus:border-ctc-blue"
                                  placeholder="Your enquiry..."></textarea>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="button" @click="currentModal = null" class="flex-1 px-4 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium">Cancel</button>
                        <button type="submit" class="flex-1 px-4 py-2.5 rounded-lg font-medium bg-ctc-blue text-white hover:bg-ctc-blue-dark">
                            Send enquiry
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <x-cta-section
        title="Get in touch"
        description="Contact us to donate, sponsor a surgery, or explore partnership."
        buttonLabel="Contact us"
        :buttonUrl="route('contact')"
    />
@endsection

@push('scripts')
<script>
function supportModals() {
    return {
        currentModal: null,
        enquiryType: '',
        enquiryTitles: {
            sponsor: 'Enquire: Sponsor a Surgery',
            equipment: 'Enquire: Equipment Needs',
            partner: 'Enquire: Partner With Us',
        },
        get enquiryTitle() {
            return this.enquiryTitles[this.enquiryType] || 'Send enquiry';
        },
        mpesa: { phone: '', amount: '' },
        stripe: { cardNumber: '', expiry: '', cvc: '', amount: '' },
        openEnquiry(type) {
            this.enquiryType = type;
            this.currentModal = 'enquiry';
        },
        openModal(name) {
            this.currentModal = name;
        },
        submitMpesa() {
            // Demo: in production, call backend to initiate STK push
            alert('Demo: STK push would be sent to ' + (this.mpesa.phone || 'your number') + ' for KES ' + (this.mpesa.amount || '0') + '. Integrate with M-Pesa API to enable.');
            this.currentModal = null;
        },
        submitStripe() {
            // Demo: in production, create PaymentIntent and confirm with Stripe.js
            alert('Demo: Card payment would be processed for KES ' + (this.stripe.amount || '0') + '. Integrate with Stripe to enable.');
            this.currentModal = null;
        },
    };
}
</script>
@endpush
