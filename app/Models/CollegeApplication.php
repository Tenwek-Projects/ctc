<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CollegeApplication extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_UNDER_REVIEW = 'under_review';
    public const STATUS_INCOMPLETE = 'incomplete';
    public const STATUS_AWAITING_DOCUMENTS = 'awaiting_documents';
    public const STATUS_PAYMENT_PENDING_VERIFICATION = 'payment_pending_verification';
    public const STATUS_ELIGIBLE = 'eligible';
    public const STATUS_SHORTLISTED = 'shortlisted';
    public const STATUS_INTERVIEW_INVITED = 'interview_invited';
    public const STATUS_INTERVIEW_COMPLETED = 'interview_completed';
    public const STATUS_ADMITTED = 'admitted';
    public const STATUS_WAITLISTED = 'waitlisted';
    public const STATUS_UNSUCCESSFUL = 'unsuccessful';
    public const STATUS_WITHDRAWN = 'withdrawn';

    protected $fillable = [
        'uuid',
        'access_token',
        'application_number',
        'programme_id',
        'programme_intake_id',
        'status',
        'payment_verification_status',
        'document_completeness_status',
        'reference_status',
        'interview_status',
        'current_step',
        'completion_percent',
        'draft_payload',
        'submitted_at',
        'submission_ip',
        'submission_user_agent',
        'last_autosaved_at',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'last_autosaved_at' => 'datetime',
            'draft_payload' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $application): void {
            if (! $application->uuid) {
                $application->uuid = (string) Str::uuid();
            }
            if (! $application->access_token) {
                $application->access_token = Str::random(64);
            }
        });
    }

    public function programme(): BelongsTo
    {
        return $this->belongsTo(Programme::class);
    }

    public function intake(): BelongsTo
    {
        return $this->belongsTo(ProgrammeIntake::class, 'programme_intake_id');
    }

    public function personalDetail(): HasOne
    {
        return $this->hasOne(ApplicantPersonalDetail::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ApplicantDocument::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(ApplicantPayment::class);
    }

    public function declaration(): HasOne
    {
        return $this->hasOne(ApplicantDeclaration::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(ApplicationStatusHistory::class);
    }
}

