<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * Get the students in this state.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
