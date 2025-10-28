<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudyPlan extends Model
{
    protected $fillable = [
        'name',
        'program_id',
        'school_id',
        'effective_year',
        'total_credits',
        'duration_periods',
        'rvoe',
        'duration_years',
    ];

    protected $casts = [
        'effective_year' => 'integer',
        'total_credits' => 'integer',
        'duration_periods' => 'integer',
        'duration_years' => 'integer',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
