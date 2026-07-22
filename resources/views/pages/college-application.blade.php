@extends('layouts.app')

@section('title', 'Apply - Higher Diploma in Cardiovascular Perfusion')

@section('content')
    <section class="bg-gray-50 border-b border-gray-200">
        <div class="container mx-auto px-4 py-6 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm sm:p-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-start gap-3">
                        <img src="{{ asset('logo-ctc.png') }}" alt="Tenwek Hospital College logo" class="h-14 w-14 rounded-full object-contain">
                        <div>
                            <p class="text-sm font-semibold text-ctc-blue">Tenwek Hospital College</p>
                            <p class="text-sm text-gray-700">School of Health Sciences</p>
                            <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-gray-600">Higher Diploma in Cardiovascular/Cardiac Perfusion Clinical Medicine</p>
                        </div>
                    </div>
                    <a href="{{ config('ctc.college_website.url', '#') }}" class="inline-flex items-center rounded-lg border border-ctc-secondary px-3 py-2 text-sm font-semibold text-ctc-secondary hover:bg-ctc-secondary/10">Return to College Website</a>
                </div>
                <div class="mt-4 grid gap-2 text-sm text-gray-700 sm:grid-cols-2">
                    <p>Tenwek Hospital College, School of Health Sciences, P.O. Box 39-20400, Bomet, Kenya</p>
                    <p>Phone: 0736 568177 / 0728 091900 · Email: <a href="mailto:shs@tenwekhosp.org" class="text-ctc-blue underline">shs@tenwekhosp.org</a></p>
                </div>
            </div>
        </div>
    </section>

    <section class="container mx-auto px-4 py-8 sm:px-6 lg:px-8"
        x-data="collegeApplicationWizard({
            initialStep: {{ max(1, (int) $application->current_step) }},
            saveUrl: '{{ route('college.apply.save-draft', ['application' => $application->uuid, 'token' => $draftToken]) }}',
            uploadUrl: '{{ route('college.apply.upload-document', ['application' => $application->uuid, 'token' => $draftToken]) }}',
            submitUrl: '{{ route('college.apply.submit', ['application' => $application->uuid, 'token' => $draftToken]) }}',
            csrf: '{{ csrf_token() }}',
            intakeId: '{{ $intake?->id }}',
            initialData: @js($draftData ?? []),
            maxFileMb: {{ $maxFileMb }},
        })"
        x-init="init()"
    >
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-6">
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <h1 class="text-2xl font-extrabold text-ctc-blue">Application for Higher Diploma in Cardiovascular Perfusion</h1>
                    <p class="mt-3 text-gray-700">Tenwek Hospital College – School of Health Sciences is receiving applications for the two-year Higher Diploma in Cardiovascular Perfusion programme.</p>
                    <ul class="mt-4 list-disc space-y-1 pl-5 text-sm text-gray-700">
                        <li>Submission of an application does not guarantee admission.</li>
                        <li>Only shortlisted applicants will be contacted.</li>
                        <li>Shortlisted applicants will receive interview information by SMS.</li>
                        <li>Applicants are responsible for interview travel, meals, accommodation, and related expenses.</li>
                        <li>The school may close applications once the required number of applicants has been reached.</li>
                    </ul>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-bold text-ctc-blue">Programme Cost</h2>
                    <p class="mt-2 text-sm text-gray-700">Estimated total programme cost: <span class="font-semibold">KES {{ number_format((int) ($intake->estimated_programme_cost_kes ?? 700000)) }}</span></p>
                    <p class="mt-2 text-sm text-gray-700">Non-refundable admission deposit upon acceptance: <span class="font-semibold">KES {{ number_format((int) ($intake->deposit_amount_kes ?? 250000)) }}</span></p>
                    <p class="mt-2 text-sm text-gray-600">Remaining balance will be paid in instalments according to timelines communicated by the college.</p>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-ctc-blue">Application Wizard</h2>
                        <span class="text-xs font-semibold text-gray-600" x-text="saveState"></span>
                    </div>

                    <div class="mb-4 h-2 w-full rounded-full bg-gray-200">
                        <div class="h-2 rounded-full bg-ctc-secondary transition-all" :style="`width: ${progressPercent()}%`"></div>
                    </div>

                    <div class="mb-6 grid grid-cols-3 gap-2 text-xs sm:grid-cols-6 lg:grid-cols-12">
                        <template x-for="(label, idx) in stepLabels" :key="idx">
                            <button type="button" class="rounded border px-2 py-1 text-left" :class="stepClass(idx + 1)" @click="goTo(idx + 1)">
                                <span class="font-semibold" x-text="idx + 1"></span>
                            </button>
                        </template>
                    </div>

                    <div class="space-y-6">
                        <div x-show="step===1" x-cloak>
                            <h3 class="text-base font-semibold text-ctc-blue">Instructions and Eligibility</h3>
                            <label class="mt-3 flex items-start gap-2 text-sm text-gray-700"><input type="checkbox" x-model="form.step1.instructions_ack" class="mt-1">I have read and understood the application instructions.</label>
                        </div>

                        <div x-show="step===2" x-cloak class="grid gap-4 sm:grid-cols-2">
                            <h3 class="sm:col-span-2 text-base font-semibold text-ctc-blue">Personal Details</h3>
                            <label class="text-sm">Full legal name <input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" x-model="form.step2.personal.full_legal_name"></label>
                            <label class="text-sm">National ID number <input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" x-model="form.step2.personal.national_id_number"></label>
                            <label class="text-sm">Primary mobile number <input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" x-model="form.step2.personal.primary_mobile_number"></label>
                            <label class="text-sm">Email address <input type="email" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" x-model="form.step2.personal.email"></label>
                            <label class="text-sm">Date of birth <input type="date" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" x-model="form.step2.personal.date_of_birth"></label>
                            <label class="text-sm">Marital status
                                <select class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" x-model="form.step2.personal.marital_status">
                                    <option value="">Select</option><option>Single</option><option>Married</option><option>Widowed</option><option>Divorced</option><option>Separated</option><option>Prefer not to say</option>
                                </select>
                            </label>
                            <template x-if="form.step2.personal.marital_status==='Married'">
                                <div class="sm:col-span-2 grid gap-4 sm:grid-cols-2 rounded-lg border border-gray-200 bg-gray-50 p-3">
                                    <label class="text-sm">Spouse name <input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" x-model="form.step2.personal.spouse_name"></label>
                                    <label class="text-sm">Number of children <input type="number" min="0" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" x-model="form.step2.personal.children_count"></label>
                                </div>
                            </template>
                        </div>

                        <div x-show="step===3" x-cloak class="grid gap-4 sm:grid-cols-2">
                            <h3 class="sm:col-span-2 text-base font-semibold text-ctc-blue">Family and Church Information</h3>
                            <label class="text-sm">Name of local church <input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" x-model="form.step3.church.church_name"></label>
                            <label class="text-sm">Pastor's mobile <input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" x-model="form.step3.church.pastor_mobile_number"></label>
                            <label class="text-sm sm:col-span-2">Areas of church involvement <textarea class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" x-model="form.step3.church.areas_of_involvement"></textarea></label>
                        </div>

                        <div x-show="step===4" x-cloak>
                            <h3 class="text-base font-semibold text-ctc-blue">Education</h3>
                            <label class="mt-2 block text-sm">Secondary school attended <input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" x-model="form.step4.secondary.school_name"></label>
                        </div>

                        <div x-show="step===5" x-cloak>
                            <h3 class="text-base font-semibold text-ctc-blue">Professional Information</h3>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <label class="text-sm">COC licence number <input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" x-model="form.step5.professional.coc_licence_number"></label>
                                <label class="text-sm">Licence expiry date <input type="date" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" x-model="form.step5.professional.licence_expiry_date"></label>
                            </div>
                        </div>

                        <div x-show="step===6" x-cloak>
                            <h3 class="text-base font-semibold text-ctc-blue">Employment and Leadership</h3>
                            <label class="mt-2 block text-sm">Current employer <input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" x-model="form.step6.employment.employer_name"></label>
                        </div>

                        <div x-show="step===7" x-cloak>
                            <h3 class="text-base font-semibold text-ctc-blue">References</h3>
                            <label class="mt-2 block text-sm">Reference 1 (Pastor) full name <input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" x-model="form.step7.references.pastor_name"></label>
                            <label class="mt-2 block text-sm">Reference 3 years known <input type="number" min="0" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" x-model="form.step7.references.long_term_years_known"></label>
                        </div>

                        <div x-show="step===8" x-cloak>
                            <h3 class="text-base font-semibold text-ctc-blue">Essay Questions</h3>
                            <label class="mt-2 block text-sm">How did you learn about the college?
                                <select class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" x-model="form.step8.essays.heard_about_source">
                                    <option value="">Select source</option>
                                    <option>Tenwek Hospital website</option><option>Social media</option><option>Current student</option><option>Former student</option><option>Hospital employee</option><option>Church</option><option>Employer</option><option>Friend or family member</option><option>Advertisement</option><option>Search engine</option><option>Other</option>
                                </select>
                            </label>
                        </div>

                        <div x-show="step===9" x-cloak>
                            <h3 class="text-base font-semibold text-ctc-blue">Medical History</h3>
                            <label class="mt-2 block text-sm">Any hereditary disease in the family?
                                <select class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" x-model="form.step9.medical.hereditary_family_disease">
                                    <option value="">Select</option><option value="yes">Yes</option><option value="no">No</option>
                                </select>
                            </label>
                            <template x-if="form.step9.medical.hereditary_family_disease==='yes'">
                                <label class="mt-2 block text-sm">Explanation <textarea class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" x-model="form.step9.medical.hereditary_family_disease_explanation"></textarea></label>
                            </template>
                        </div>

                        <div x-show="step===10" x-cloak>
                            <h3 class="text-base font-semibold text-ctc-blue">Supporting Documents</h3>
                            <p class="text-sm text-gray-600">Accepted formats: PDF, JPG, JPEG, PNG. Max {{ $maxFileMb }} MB per file.</p>
                            <div class="mt-3 grid gap-3 sm:grid-cols-2">
                                <template x-for="doc in requiredDocuments" :key="doc.type">
                                    <div class="rounded-lg border border-gray-200 p-3">
                                        <p class="text-sm font-medium" x-text="doc.label"></p>
                                        <div class="mt-2 flex items-center gap-2">
                                            <input type="file" class="text-xs" @change="uploadDocument(doc.type, $event)">
                                            <span class="text-xs text-gray-500" x-text="documentStatus(doc.type)"></span>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div x-show="step===11" x-cloak class="grid gap-4 sm:grid-cols-2">
                            <h3 class="sm:col-span-2 text-base font-semibold text-ctc-blue">Application Fee and Payment Details</h3>
                            <label class="text-sm">Payment method
                                <select class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" x-model="form.step11.payment.payment_method">
                                    <option value="">Select</option><option>M-PESA Paybill</option><option>KCB bank deposit</option><option>KCB bank transfer</option><option>Other approved method</option>
                                </select>
                            </label>
                            <label class="text-sm">Amount paid (KES) <input type="number" min="0" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" x-model="form.step11.payment.amount_paid_kes"></label>
                            <label class="text-sm">Transaction code/reference <input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" x-model="form.step11.payment.transaction_reference"></label>
                            <label class="text-sm">Payer phone <input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" x-model="form.step11.payment.payer_phone"></label>
                            <p class="sm:col-span-2 text-sm text-red-700">Do not send cash or personal cheques.</p>
                        </div>

                        <div x-show="step===12" x-cloak>
                            <h3 class="text-base font-semibold text-ctc-blue">Declaration and Review</h3>
                            <div class="mt-3 space-y-2 text-sm text-gray-700">
                                <label class="flex items-start gap-2"><input type="checkbox" x-model="form.step12.declarations.truthful" class="mt-1">I declare that the information I have provided is complete and correct.</label>
                                <label class="flex items-start gap-2"><input type="checkbox" x-model="form.step12.declarations.no_withholding" class="mt-1">I have not knowingly withheld important information.</label>
                                <label class="flex items-start gap-2"><input type="checkbox" x-model="form.step12.declarations.contact_referees" class="mt-1">I consent to Tenwek Hospital College contacting my referees.</label>
                                <label class="flex items-start gap-2"><input type="checkbox" x-model="form.step12.declarations.no_guarantee" class="mt-1">I understand that submitting an application does not guarantee admission.</label>
                                <label class="flex items-start gap-2"><input type="checkbox" x-model="form.step12.declarations.non_refundable" class="mt-1">I understand that the application fee is non-refundable.</label>
                                <label class="flex items-start gap-2"><input type="checkbox" x-model="form.step12.declarations.data_processing" class="mt-1">I consent to processing of personal and medical information for this application.</label>
                            </div>
                            <label class="mt-4 block text-sm">Typed legal name
                                <input class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" x-model="form.step12.declarations.typed_legal_name">
                            </label>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-wrap items-center justify-between gap-2">
                        <button type="button" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700" @click="prev()" :disabled="step===1">Previous Step</button>
                        <div class="flex gap-2">
                            <button type="button" class="rounded-lg border border-ctc-secondary px-4 py-2 text-sm font-semibold text-ctc-secondary" @click="saveNow()">Save as Draft</button>
                            <button type="button" class="rounded-lg bg-ctc-blue px-4 py-2 text-sm font-semibold text-white" x-show="step<12" @click="next()">Save and Continue</button>
                            <button type="button" class="rounded-lg bg-ctc-magenta px-4 py-2 text-sm font-semibold text-white" x-show="step===12" @click="submitApplication()">Submit Application</button>
                        </div>
                    </div>
                </div>
            </div>

            <aside class="space-y-6">
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-bold text-ctc-blue">Important Dates</h2>
                    <dl class="mt-3 space-y-2 text-sm">
                        <div class="flex items-center justify-between"><dt class="text-gray-600">Opening date</dt><dd class="font-semibold text-gray-900">{{ optional($intake?->opening_date)->format('d M Y') ?? 'TBA' }}</dd></div>
                        <div class="flex items-center justify-between"><dt class="text-gray-600">Deadline</dt><dd class="font-semibold text-gray-900">{{ optional($intake?->deadline_date)->format('d M Y') ?? 'TBA' }}</dd></div>
                        <div class="flex items-center justify-between"><dt class="text-gray-600">Expected intake date</dt><dd class="font-semibold text-gray-900">{{ optional($intake?->expected_intake_date)->format('d M Y') ?? 'TBA' }}</dd></div>
                        <div class="flex items-center justify-between"><dt class="text-gray-600">Communication</dt><dd class="font-semibold text-gray-900">{{ $intake?->interview_communication_method ?? 'SMS' }}</dd></div>
                    </dl>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-bold text-ctc-blue">Payment Details</h2>
                    <p class="mt-2 text-sm text-gray-700">Application Fee: <span class="font-semibold">KES {{ number_format((int) ($intake?->application_fee_kes ?? 1500)) }}</span></p>
                    <p class="mt-2 text-sm text-gray-700">KCB Account Number: <span class="font-semibold">1118320271</span></p>
                    <p class="mt-1 text-sm text-gray-700">M-PESA Paybill: <span class="font-semibold">522522</span>, Account Number: <span class="font-semibold">1118320271</span></p>
                </div>

                <div class="rounded-2xl border border-amber-300 bg-amber-50 p-5 shadow-sm">
                    <h2 class="text-sm font-bold uppercase tracking-wide text-amber-900">Required Documents Checklist</h2>
                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-amber-900">
                        <li>KCSE certificate</li>
                        <li>Secondary leaving certificate</li>
                        <li>National ID/Passport</li>
                        <li>COC practice licence</li>
                        <li>Clinical Medicine qualification</li>
                        <li>Anaesthesia or ECCO qualification</li>
                        <li>Payment evidence</li>
                        <li>Handwritten essay responses</li>
                    </ul>
                </div>
            </aside>
        </div>
    </section>

    @push('scripts')
        <script>
            function collegeApplicationWizard(config) {
                return {
                    step: 1,
                    saveState: 'Saved',
                    saveTimer: null,
                    uploadedDocs: {},
                    requiredDocuments: [
                        { type: 'kcse_certificate', label: 'KCSE results certificate' },
                        { type: 'secondary_leaving_certificate', label: 'Secondary leaving certificate' },
                        { type: 'id_or_passport', label: 'National ID or Passport' },
                        { type: 'coc_practice_licence', label: 'Clinical Officers Council practice licence' },
                        { type: 'diploma_or_degree_clinical_medicine', label: 'Diploma/Degree in Clinical Medicine and Surgery' },
                        { type: 'higher_diploma_anaesthesia_or_ecco', label: 'Higher Diploma in Anaesthesia or ECCO' },
                        { type: 'application_fee_evidence', label: 'Application fee payment evidence' },
                        { type: 'essay_response_1', label: 'Essay response #1 (handwritten upload)' },
                    ],
                    stepLabels: ['Instructions','Personal','Family/Church','Education','Professional','Employment','References','Essays','Medical','Documents','Payment','Declaration'],
                    form: {
                        step1: { instructions_ack: false },
                        step2: { personal: { full_legal_name: '', national_id_number: '', primary_mobile_number: '', email: '', date_of_birth: '', marital_status: '' } },
                        step3: { church: { church_name: '', pastor_mobile_number: '', areas_of_involvement: '' } },
                        step4: { secondary: { school_name: '' } },
                        step5: { professional: { coc_licence_number: '', licence_expiry_date: '' } },
                        step6: { employment: { employer_name: '' } },
                        step7: { references: { pastor_name: '', long_term_years_known: '' } },
                        step8: { essays: { heard_about_source: '' } },
                        step9: { medical: { hereditary_family_disease: '', hereditary_family_disease_explanation: '' } },
                        step10: {},
                        step11: { payment: { payment_method: '', amount_paid_kes: '', transaction_reference: '', payer_phone: '' } },
                        step12: { declarations: { truthful:false, no_withholding:false, contact_referees:false, no_guarantee:false, non_refundable:false, data_processing:false, typed_legal_name:'' } },
                    },
                    init() {
                        this.step = config.initialStep || 1;
                        if (config.initialData) {
                            for (const [k, v] of Object.entries(config.initialData)) {
                                if (k.startsWith('step_') && typeof v === 'object') {
                                    const idx = Number(k.split('_')[1]);
                                    this.form['step' + idx] = { ...this.form['step' + idx], ...v };
                                }
                            }
                        }
                    },
                    stepClass(stepNumber) {
                        if (this.step === stepNumber) return 'border-ctc-blue bg-ctc-blue text-white';
                        if (this.form['step' + stepNumber]) return 'border-ctc-secondary/50 bg-ctc-secondary/10 text-ctc-blue';
                        return 'border-gray-300 bg-white text-gray-600';
                    },
                    progressPercent() {
                        return Math.round((this.step / 12) * 100);
                    },
                    goTo(n) { this.step = n; },
                    prev() { if (this.step > 1) this.step--; },
                    next() {
                        if (this.step === 1 && !this.form.step1.instructions_ack) {
                            alert('Please confirm you have read and understood the application instructions.');
                            return;
                        }
                        this.saveNow().then(() => {
                            if (this.step < 12) this.step++;
                        });
                    },
                    payloadForCurrentStep() {
                        return this.form['step' + this.step];
                    },
                    saveNow() {
                        this.saveState = 'Saving...';
                        return fetch(config.saveUrl, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': config.csrf, 'Accept': 'application/json' },
                            body: JSON.stringify({
                                step: this.step,
                                current_step: this.step,
                                programme_intake_id: config.intakeId || null,
                                data: this.payloadForCurrentStep(),
                            }),
                        })
                        .then((r) => {
                            if (!r.ok) throw new Error('Draft save failed');
                            return r.json();
                        })
                        .then(() => { this.saveState = 'Saved'; })
                        .catch(() => { this.saveState = 'Unable to save'; });
                    },
                    uploadDocument(documentType, event) {
                        const file = event.target.files?.[0];
                        if (!file) return;
                        const maxBytes = config.maxFileMb * 1024 * 1024;
                        if (file.size > maxBytes) {
                            alert(`File too large. Max allowed is ${config.maxFileMb} MB.`);
                            return;
                        }
                        this.saveState = 'Saving...';
                        const fd = new FormData();
                        fd.append('_token', config.csrf);
                        fd.append('document_type', documentType);
                        fd.append('document', file);
                        fetch(config.uploadUrl, { method: 'POST', body: fd, headers: { 'Accept': 'application/json' } })
                            .then((r) => r.json())
                            .then((json) => {
                                if (!json.ok) throw new Error('Upload failed');
                                this.uploadedDocs[documentType] = json.document;
                                this.saveState = 'Saved';
                            })
                            .catch(() => { this.saveState = 'Unable to save'; });
                    },
                    documentStatus(documentType) {
                        return this.uploadedDocs[documentType] ? `Uploaded: ${this.uploadedDocs[documentType].filename}` : 'Not uploaded';
                    },
                    submitApplication() {
                        if (!this.form.step12.declarations.truthful
                            || !this.form.step12.declarations.no_withholding
                            || !this.form.step12.declarations.contact_referees
                            || !this.form.step12.declarations.no_guarantee
                            || !this.form.step12.declarations.non_refundable
                            || !this.form.step12.declarations.data_processing
                            || !this.form.step12.declarations.typed_legal_name) {
                            alert('Please complete all declarations before submitting.');
                            return;
                        }

                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = config.submitUrl;
                        form.innerHTML = `
                            <input type="hidden" name="_token" value="${config.csrf}">
                            <input type="hidden" name="typed_legal_name" value="${this.form.step12.declarations.typed_legal_name}">
                            <input type="hidden" name="declaration_truthfulness" value="1">
                            <input type="hidden" name="declaration_no_withholding" value="1">
                            <input type="hidden" name="consent_contact_referees" value="1">
                            <input type="hidden" name="declaration_no_guarantee" value="1">
                            <input type="hidden" name="declaration_non_refundable_fee" value="1">
                            <input type="hidden" name="consent_data_processing" value="1">
                        `;
                        document.body.appendChild(form);
                        form.submit();
                    },
                };
            }
        </script>
    @endpush
@endsection

