<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgrammeIntake extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'programme_id',
        'intake_name',
        'opening_date',
        'deadline_date',
        'expected_intake_date',
        'interview_period',
        'interview_communication_method',
        'programme_duration',
        'application_fee_kes',
        'estimated_programme_cost_kes',
        'deposit_amount_kes',
        'max_applicants',
        'status',
        'additional_instructions',
    ];

    protected function casts(): array
    {
        return [
            'opening_date' => 'date',
            'deadline_date' => 'date',
            'expected_intake_date' => 'date',
        ];
    }

    public function programme(): BelongsTo
    {
        return $this->belongsTo(Programme::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(CollegeApplication::class, 'programme_intake_id');
    }
}

