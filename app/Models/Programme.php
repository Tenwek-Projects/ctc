<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Programme extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'school_name',
        'description',
        'is_active',
    ];

    public function intakes(): HasMany
    {
        return $this->hasMany(ProgrammeIntake::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(CollegeApplication::class);
    }
}

