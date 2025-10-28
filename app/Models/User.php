<?php

namespace App\Models;
use App\Services\AuthorizationService;
use Illuminate\Database\Eloquent\Model;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Panel;
use Illuminate\Support\Collection;

class User extends Authenticatable implements FilamentUser, HasTenants
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;



    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * The schools that belong to the user (many-to-many relationship).
     * This allows users to belong to multiple schools and schools can have multiple users.
     */
    public function schools(): BelongsToMany
    {
        return $this->belongsToMany(School::class, 'school_user');
    }

    /**
     * Get the students for the user.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function getTenants(Panel $panel): Collection
    {
        return $this->schools;
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->schools()->whereKey($tenant)->exists();
    }

    public function canAccessPanel(Panel $panel): bool{
        //return true;
        return AuthorizationService::canAccessPanel($this, $panel->getId());

    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }



}
