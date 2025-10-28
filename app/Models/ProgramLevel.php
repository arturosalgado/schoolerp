<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramLevel extends Model
{
    protected $fillable = [
        'name',
        'active',
        'school_id',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Get the school that owns the program level.
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get the programs for the program level.
     */
    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }
}
