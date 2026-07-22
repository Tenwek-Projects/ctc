<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicantPersonalDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'college_application_id',
        'application_date',
        'full_legal_name',
        'national_id_number',
        'passport_number',
        'postal_address',
        'postal_code',
        'town',
        'county',
        'country_of_residence',
        'primary_mobile_number',
        'alternative_mobile_number',
        'email',
        'nationality',
        'date_of_birth',
        'calculated_age',
        'sex',
        'marital_status',
        'spouse_name',
        'spouse_address',
        'spouse_occupation',
        'spouse_mobile_number',
        'children_count',
        'children_names_or_initials',
        'children_ages',
        'youngest_child_dob',
        'photo_document_id',
    ];

    protected function casts(): array
    {
        return [
            'application_date' => 'date',
            'date_of_birth' => 'date',
            'youngest_child_dob' => 'date',
        ];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(CollegeApplication::class, 'college_application_id');
    }
}

