<?php

namespace App\Models;

use App\Actions\SchoolCreatedActions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany; // used by roles()

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
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($school) {

            // dd($school);// checked, it does bring the just created school.
            // Seed default program levels for the new school
            // dd(auth()->id());
            // dd(auth()->guard()->user());//checked it does have the user that created the school, so we can pass it to the actions for logging purposes
            SchoolCreatedActions::run($school, auth()->guard()->user());

        });
    }

    /**
     * Get the name attribute for the tenant.
     */
    public function getNameAttribute(): string
    {
        // dd($this->slug);
        return $this->slug;
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
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'school_student')
            ->withPivot('student_status_id')
            ->withTimestamps();
    }

    /**
     * Get the teachers for the school.
     */
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'school_teacher');
    }

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }
}
