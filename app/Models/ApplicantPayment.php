<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicantPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'college_application_id',
        'payment_method',
        'amount_paid_kes',
        'payment_date',
        'transaction_reference',
        'payer_name',
        'payer_phone',
        'applicant_name_in_narration',
        'payment_notes',
        'verification_status',
        'verified_by',
        'verified_at',
        'verification_notes',
    ];

    protected function casts(): array
    {
        return [
            'payment_date' => 'date',
            'verified_at' => 'datetime',
        ];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(CollegeApplication::class, 'college_application_id');
    }
}

