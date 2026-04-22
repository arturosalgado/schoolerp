<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'label_es',
        'description',
        'is_active',
        'system',
        'school_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'system'    => 'boolean',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class)->withPivot('active')->withTimestamps();
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function panels(): BelongsToMany
    {
        return $this->belongsToMany(Panel::class, 'panel_role');
    }

    public static function findByName(string $name): ?Role
    {
        return static::where('name', $name)->first();
    }

    public function hasPermission(string $permission): bool
    {
        return $this->permissions()->where('name', $permission)->wherePivot('active', true)->exists();
    }

    public function grantPermission(string $permissionName): void
    {
        $permission = Permission::findByName($permissionName);
        if ($permission) {
            $this->permissions()->syncWithoutDetaching([
                $permission->id => ['active' => true],
            ]);
        }
    }

    public function revokePermission(string $permissionName): void
    {
        $permission = Permission::findByName($permissionName);
        if ($permission) {
            $this->permissions()->detach($permission->id);
        }
    }
}
