<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EnrollmentPeriod extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'school_id',
        'cycle_id',
        'name',
        'opens_at',
        'closes_at',
        'is_active',
    ];

    protected $casts = [
        'opens_at'  => 'date',
        'closes_at' => 'date',
        'is_active' => 'boolean',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function cycle(): BelongsTo
    {
        return $this->belongsTo(Cycle::class);
    }

    public function programs(): BelongsToMany
    {
        return $this->belongsToMany(Program::class, 'enrollment_period_program')
            ->withPivot('quota')
            ->withTimestamps();
    }

    public function terms(): BelongsToMany
    {
        return $this->belongsToMany(Term::class, 'enrollment_period_term')
            ->withTimestamps();
    }

    public function prospects(): HasMany
    {
        return $this->hasMany(Prospect::class);
    }

    /**
     * Prospects that were converted to students.
     */
    public function convertedProspects(): HasMany
    {
        return $this->hasMany(Prospect::class)->where('status', 'converted');
    }

    public function __toString(): string
    {
        return $this->name ?? $this->cycle?->name ?? "Enrollment Period #{$this->id}";
    }
}
