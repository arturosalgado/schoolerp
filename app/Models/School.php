<?php

namespace App\Models;

use App\Actions\Seeders\SeedProgramLevels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    protected $fillable = [
        'slug',
        'rfc',
        'address',
        'image',
        'full_name',
        'email',
        'phone',
        'website',
        'student_field_config',
        'program_field_config',
    ];

    protected $casts = [
        'student_field_config' => 'array',
        'program_field_config' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($school) {
            // Seed default program levels for the new school
            SeedProgramLevels::run($school->id);
        });
    }

    /**
     * Get the name attribute for the tenant.
     */
    public function getNameAttribute(): string
    {
        //dd($this->slug);
        return  $this->slug;
    }

    /**
     * Get the users associated with the school.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'school_user');
    }

    /**
     * Get the students for the school.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
