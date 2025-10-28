<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'active',
        'is_system',
        'school_id'
    ];

    protected $casts = [
        'active' => 'boolean',
        'is_system' => 'boolean'
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Check if this status is a system/protected status
     */
    public function isSystemStatus(): bool
    {
        return $this->is_system;
    }

    /**
     * Scope to get only non-system statuses (user-editable)
     */
    public function scopeUserEditable($query)
    {
        return $query->where('is_system', false);
    }

    /**
     * Scope to get only system statuses
     */
    public function scopeSystemOnly($query)
    {
        return $query->where('is_system', true);
    }

}
