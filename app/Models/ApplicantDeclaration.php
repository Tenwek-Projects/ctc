<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicantDeclaration extends Model
{
    use HasFactory;

    protected $fillable = [
        'college_application_id',
        'declaration_truthfulness',
        'declaration_no_withholding',
        'consent_contact_referees',
        'declaration_no_guarantee',
        'declaration_non_refundable_fee',
        'consent_data_processing',
        'typed_legal_name',
        'signature_type',
        'signature_payload',
        'declaration_date',
    ];

    protected function casts(): array
    {
        return [
            'declaration_truthfulness' => 'boolean',
            'declaration_no_withholding' => 'boolean',
            'consent_contact_referees' => 'boolean',
            'declaration_no_guarantee' => 'boolean',
            'declaration_non_refundable_fee' => 'boolean',
            'consent_data_processing' => 'boolean',
            'declaration_date' => 'date',
        ];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(CollegeApplication::class, 'college_application_id');
    }
}

