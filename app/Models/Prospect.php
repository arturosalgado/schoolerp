<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Prospect extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'school_id',
        'enrollment_period_id',
        'name',
        'last_name',
        'second_last_name',
        'email',
        'mobile',
        'dob',
        'sex',
        'curp',
        'state_id',
        'program_id',
        'photo',
        'source',
        'status',
        'notes',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    public function enrollmentPeriod(): BelongsTo
    {
        return $this->belongsTo(EnrollmentPeriod::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function getImageUrl(): ?string
    {
        if ($this->photo === null) {
            return null;
        }

        return Storage::disk('public')->url($this->photo);
    }

    public function __toString(): string
    {
        return "$this->name $this->last_name";
    }
}
