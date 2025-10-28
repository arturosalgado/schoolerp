<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BloodType extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * Get the students with this blood type.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
