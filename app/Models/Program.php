<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Program extends Model
{
    protected $fillable = [
        'name',
        'active',
        'school_id',
        'program_level_id',
        'plan_de_estudios_pdf',
        'extra_field_1',
        'extra_field_2',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Get the school that owns the program.
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get the program level that owns the program.
     */
    public function programLevel(): BelongsTo
    {
        return $this->belongsTo(ProgramLevel::class);
    }

    /**
     * Get the students enrolled in this program.
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'program_student')
                    ->withPivot('is_current', 'enrolled_at', 'completed_at')
                    ->withTimestamps();
    }
}
