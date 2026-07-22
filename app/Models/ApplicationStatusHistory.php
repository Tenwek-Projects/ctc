<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'college_application_id',
        'from_status',
        'to_status',
        'notes',
        'changed_by',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(CollegeApplication::class, 'college_application_id');
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}

