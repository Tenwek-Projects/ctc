<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCollegeApplicationDraftRequest;
use App\Http\Requests\SubmitCollegeApplicationRequest;
use App\Models\ApplicantDeclaration;
use App\Models\ApplicantDocument;
use App\Models\ApplicantPayment;
use App\Models\ApplicantPersonalDetail;
use App\Models\CollegeApplication;
use App\Models\Programme;
use App\Models\ProgrammeIntake;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CollegeApplicationController extends Controller
{
    private const REQUIRED_DOCUMENT_TYPES = [
        'application_form',
        'kcse_certificate',
        'secondary_leaving_certificate',
        'id_or_passport',
        'coc_practice_licence',
        'higher_diploma_anaesthesia_or_ecco',
        'diploma_or_degree_clinical_medicine',
        'application_fee_evidence',
        'essay_response_1',
        'essay_response_2',
        'essay_response_3',
        'essay_response_4',
        'essay_response_5',
        'essay_response_6',
    ];

    public function landing(): View
    {
        $programme = Programme::query()
            ->where('code', 'THC-SHS-CP')
            ->where('is_active', true)
            ->first();

        $intake = $programme
            ? ProgrammeIntake::query()
                ->where('programme_id', $programme->id)
                ->where('status', 'open')
                ->orderByDesc('opening_date')
                ->first()
            : null;

        return view('pages.college-application-landing', compact('programme', 'intake'));
    }

    public function start(Request $request): RedirectResponse
    {
        $programme = Programme::query()
            ->where('code', 'THC-SHS-CP')
            ->where('is_active', true)
            ->firstOrFail();

        $intake = ProgrammeIntake::query()
            ->where('programme_id', $programme->id)
            ->where('status', 'open')
            ->orderByDesc('opening_date')
            ->first();

        $application = CollegeApplication::query()->create([
            'programme_id' => $programme->id,
            'programme_intake_id' => $intake?->id,
            'status' => CollegeApplication::STATUS_DRAFT,
        ]);

        return redirect()->route('college.apply.show', ['application' => $application->uuid, 'token' => $application->access_token]);
    }

    public function show(Request $request, string $application): View
    {
        $app = CollegeApplication::query()->where('uuid', $application)->firstOrFail();
        $this->assertToken($request, $app);

        $programme = $app->programme;
        $intake = $app->intake;
        $documents = $app->documents()->latest()->get();
        $maxFileMb = (int) config('ctc.college_application.max_file_mb', 5);

        return view('pages.college-application', [
            'application' => $app,
            'programme' => $programme,
            'intake' => $intake,
            'documents' => $documents,
            'maxFileMb' => $maxFileMb,
            'draftData' => $app->draft_payload ?? [],
            'draftToken' => $app->access_token,
        ]);
    }

    public function saveDraft(StoreCollegeApplicationDraftRequest $request, string $application)
    {
        $app = CollegeApplication::query()->where('uuid', $application)->firstOrFail();
        $this->assertToken($request, $app);

        $payload = $request->validated();
        $current = $app->draft_payload ?? [];
        $stepKey = 'step_'.$payload['step'];
        $current[$stepKey] = $payload['data'];

        $app->fill([
            'draft_payload' => $current,
            'current_step' => max((int) $app->current_step, (int) ($payload['current_step'] ?? $payload['step'])),
            'completion_percent' => $this->calculateCompletionPercent($current),
            'last_autosaved_at' => now(),
        ])->save();

        $this->syncCoreRelationalData($app, $current);

        return response()->json([
            'ok' => true,
            'saved_at' => $app->last_autosaved_at?->toIso8601String(),
            'completion_percent' => $app->completion_percent,
        ]);
    }

    public function uploadDocument(Request $request, string $application)
    {
        $app = CollegeApplication::query()->where('uuid', $application)->firstOrFail();
        $this->assertToken($request, $app);

        $maxFileMb = (int) config('ctc.college_application.max_file_mb', 5);
        $request->validate([
            'document_type' => ['required', 'string', 'max:120'],
            'document' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:'.($maxFileMb * 1024)],
        ]);

        $file = $request->file('document');
        $original = $file->getClientOriginalName();
        $ext = strtolower($file->getClientOriginalExtension());
        $stored = Str::uuid().'.'.$ext;
        $folder = 'college-applications/'.$app->uuid.'/documents';
        $path = $file->storeAs($folder, $stored, 'local');

        $doc = ApplicantDocument::query()->create([
            'college_application_id' => $app->id,
            'document_type' => $request->string('document_type')->value(),
            'status' => 'uploaded',
            'original_filename' => $original,
            'stored_filename' => $stored,
            'storage_disk' => 'local',
            'storage_path' => $path,
            'mime_type' => $file->getMimeType() ?: 'application/octet-stream',
            'file_size' => $file->getSize(),
        ]);

        return response()->json([
            'ok' => true,
            'document' => [
                'id' => $doc->id,
                'document_type' => $doc->document_type,
                'filename' => $doc->original_filename,
                'size' => $doc->file_size,
                'status' => $doc->status,
                'preview_url' => URL::temporarySignedRoute(
                    'college.apply.document.preview',
                    now()->addMinutes(15),
                    ['application' => $app->uuid, 'document' => $doc->id, 'token' => $app->access_token]
                ),
            ],
        ]);
    }

    public function previewDocument(Request $request, string $application, ApplicantDocument $document)
    {
        if (! $request->hasValidSignature()) {
            abort(403);
        }

        $app = CollegeApplication::query()->where('uuid', $application)->firstOrFail();
        $this->assertToken($request, $app);

        if ((int) $document->college_application_id !== (int) $app->id) {
            abort(404);
        }

        return Storage::disk($document->storage_disk)->response(
            $document->storage_path,
            $document->original_filename,
            ['Content-Type' => $document->mime_type]
        );
    }

    public function submit(SubmitCollegeApplicationRequest $request, string $application): RedirectResponse
    {
        $app = CollegeApplication::query()->where('uuid', $application)->firstOrFail();
        $this->assertToken($request, $app);

        if ($app->status !== CollegeApplication::STATUS_DRAFT) {
            return redirect()->route('college.apply.dashboard', ['application' => $app->uuid, 'token' => $app->access_token]);
        }

        $draft = $app->draft_payload ?? [];
        $this->validateSubmissionReadiness($app, $draft);

        DB::transaction(function () use ($app, $request, $draft): void {
            $this->syncCoreRelationalData($app, $draft);

            ApplicantDeclaration::query()->updateOrCreate(
                ['college_application_id' => $app->id],
                [
                    'declaration_truthfulness' => true,
                    'declaration_no_withholding' => true,
                    'consent_contact_referees' => true,
                    'declaration_no_guarantee' => true,
                    'declaration_non_refundable_fee' => true,
                    'consent_data_processing' => true,
                    'typed_legal_name' => $request->string('typed_legal_name')->value(),
                    'signature_type' => 'typed',
                    'signature_payload' => $request->string('typed_legal_name')->value(),
                    'declaration_date' => Carbon::today(),
                ]
            );

            $app->fill([
                'status' => CollegeApplication::STATUS_SUBMITTED,
                'submitted_at' => now(),
                'submission_ip' => request()->ip(),
                'submission_user_agent' => (string) request()->userAgent(),
                'completion_percent' => 100,
            ]);

            if (! $app->application_number) {
                $year = now()->year;
                $seq = str_pad((string) ($app->id % 100000), 5, '0', STR_PAD_LEFT);
                $app->application_number = "THC-SHS-CP-{$year}-{$seq}";
            }

            $app->save();

            $app->statusHistory()->create([
                'from_status' => CollegeApplication::STATUS_DRAFT,
                'to_status' => CollegeApplication::STATUS_SUBMITTED,
                'notes' => 'Submitted by applicant',
            ]);
        });

        return redirect()->route('college.apply.success', ['application' => $app->uuid, 'token' => $app->access_token]);
    }

    public function success(Request $request, string $application): View
    {
        $app = CollegeApplication::query()->where('uuid', $application)->firstOrFail();
        $this->assertToken($request, $app);

        return view('pages.college-application-success', ['application' => $app]);
    }

    public function dashboard(Request $request, string $application): View
    {
        $app = CollegeApplication::query()->where('uuid', $application)->firstOrFail();
        $this->assertToken($request, $app);

        return view('pages.college-application-dashboard', ['application' => $app]);
    }

    private function assertToken(Request $request, CollegeApplication $application): void
    {
        $token = (string) $request->query('token');
        if (! hash_equals($application->access_token, $token)) {
            abort(403);
        }
    }

    private function calculateCompletionPercent(array $draft): int
    {
        $filledSteps = 0;
        for ($i = 1; $i <= 12; $i++) {
            if (! empty($draft['step_'.$i])) {
                $filledSteps++;
            }
        }

        return (int) round(($filledSteps / 12) * 100);
    }

    private function syncCoreRelationalData(CollegeApplication $application, array $draft): void
    {
        $personal = $draft['step_2']['personal'] ?? [];
        if (! empty($personal)) {
            $dob = isset($personal['date_of_birth']) && $personal['date_of_birth']
                ? Carbon::parse($personal['date_of_birth'])
                : null;

            ApplicantPersonalDetail::query()->updateOrCreate(
                ['college_application_id' => $application->id],
                [
                    'application_date' => isset($personal['application_date']) ? Carbon::parse($personal['application_date']) : now()->toDateString(),
                    'full_legal_name' => $personal['full_legal_name'] ?? 'Draft Applicant',
                    'national_id_number' => $personal['national_id_number'] ?? null,
                    'passport_number' => $personal['passport_number'] ?? null,
                    'postal_address' => $personal['postal_address'] ?? null,
                    'postal_code' => $personal['postal_code'] ?? null,
                    'town' => $personal['town'] ?? null,
                    'county' => $personal['county'] ?? null,
                    'country_of_residence' => $personal['country_of_residence'] ?? null,
                    'primary_mobile_number' => $personal['primary_mobile_number'] ?? 'N/A',
                    'alternative_mobile_number' => $personal['alternative_mobile_number'] ?? null,
                    'email' => $personal['email'] ?? 'draft@example.test',
                    'nationality' => $personal['nationality'] ?? null,
                    'date_of_birth' => $dob,
                    'calculated_age' => $dob ? max(0, $dob->age) : null,
                    'sex' => $personal['sex'] ?? null,
                    'marital_status' => $personal['marital_status'] ?? null,
                    'spouse_name' => $personal['spouse_name'] ?? null,
                    'spouse_address' => $personal['spouse_address'] ?? null,
                    'spouse_occupation' => $personal['spouse_occupation'] ?? null,
                    'spouse_mobile_number' => $personal['spouse_mobile_number'] ?? null,
                    'children_count' => $personal['children_count'] ?? null,
                    'children_names_or_initials' => $personal['children_names_or_initials'] ?? null,
                    'children_ages' => $personal['children_ages'] ?? null,
                    'youngest_child_dob' => isset($personal['youngest_child_dob']) && $personal['youngest_child_dob'] ? Carbon::parse($personal['youngest_child_dob']) : null,
                ]
            );
        }

        $payment = $draft['step_11']['payment'] ?? [];
        if (! empty($payment)) {
            ApplicantPayment::query()->updateOrCreate(
                ['college_application_id' => $application->id],
                [
                    'payment_method' => $payment['payment_method'] ?? null,
                    'amount_paid_kes' => $payment['amount_paid_kes'] ?? null,
                    'payment_date' => isset($payment['payment_date']) && $payment['payment_date'] ? Carbon::parse($payment['payment_date']) : null,
                    'transaction_reference' => $payment['transaction_reference'] ?? null,
                    'payer_name' => $payment['payer_name'] ?? null,
                    'payer_phone' => $payment['payer_phone'] ?? null,
                    'applicant_name_in_narration' => $payment['applicant_name_in_narration'] ?? null,
                    'payment_notes' => $payment['payment_notes'] ?? null,
                    'verification_status' => 'pending',
                ]
            );
        }
    }

    private function validateSubmissionReadiness(CollegeApplication $application, array $draft): void
    {
        $personal = $draft['step_2']['personal'] ?? [];
        if (empty($personal['full_legal_name']) || empty($personal['primary_mobile_number']) || empty($personal['email'])) {
            abort(422, 'Please complete the Personal Details step before submitting.');
        }

        $uploadedTypes = $application->documents()->pluck('document_type')->all();
        foreach (self::REQUIRED_DOCUMENT_TYPES as $requiredType) {
            if (! in_array($requiredType, $uploadedTypes, true)) {
                abort(422, "Missing required document: {$requiredType}");
            }
        }

        $payment = $draft['step_11']['payment'] ?? [];
        if (empty($payment['amount_paid_kes']) || (int) $payment['amount_paid_kes'] < 1500) {
            abort(422, 'Application fee amount must be at least KES 1,500.');
        }
    }
}

