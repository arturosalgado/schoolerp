<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Document extends Model
{
    protected $fillable = [
        'name',
        'active',
        'school_id',
        'required',
    ];

    protected $casts = [
        'active' => 'boolean',
        'required' => 'boolean',
    ];

    /**
     * Get the school that owns the document.
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get the students associated with this document.
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'document_student')
            ->withPivot('is_digital', 'is_guarded', 'date_guarded', 'date_out')
            ->withTimestamps();
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
