<?php

namespace App\Models;

use App\RoleLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'hierarchy_level',
        'level',
        'is_active',
        'system',
        'school_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'hierarchy_level' => 'integer',
        'level' => RoleLevel::class
    ];

    /**
     * Role hierarchy level
     */
    protected static array $hierarchy = [
        'super' => 100,
        'admin' => 80,
        'teacher' => 60,
        'student' => 40,
        'prospect' => 20,
        'it' => 70,
        'payments' => 50
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class)->withPivot('active')->withTimestamps();
    }

    /**
     * Find role by name
     */
    public static function findByName(string $name): ?Role
    {
        return static::where('name', $name)->first();
    }

    /**
     * Check if role has higher level than another role
     */
    public function hasHigherLevelThan(Role $role): bool
    {
        return $this->hierarchy_level > $role->hierarchy_level;
    }

    /**
     * Check if role has specific permission
     */
    public function hasPermission(string $permission): bool
    {
        return $this->permissions()->where('name', $permission)->exists();
    }

    /**
     * Grant permission to role
     */
    public function grantPermission(string $permissionName): void
    {
        $permission = Permission::findByName($permissionName);
        if ($permission && !$this->hasPermission($permissionName)) {
            $this->permissions()->attach($permission->id);
        }
    }

    /**
     * Revoke permission from role
     */
    public function revokePermission(string $permissionName): void
    {
        $permission = Permission::findByName($permissionName);
        if ($permission) {
            $this->permissions()->detach($permission->id);
        }
    }

    /**
     * Get hierarchy level for role name
     */
    public static function getHierarchyLevel(string $roleName): int
    {
        return static::$hierarchy[$roleName] ?? 0;
    }

    /**
     * Sync hierarchy level from predefined hierarchy on save
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($role) {
            if (isset(static::$hierarchy[$role->name])) {
                $role->hierarchy_level = static::$hierarchy[$role->name];
            }
        });
    }

    public static function setUp(): void
    {
        // Create default roles if they don't exist
        foreach (array_keys(static::$hierarchy) as $roleName) {
            if (!static::where('name', $roleName)->exists()) {
                static::create(['name' => $roleName, 'is_active' => true]);
            }
        }
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function panels(): BelongsToMany
    {
        return $this->belongsToMany(Panel::class, 'panel_role');
    }

    /**
     * Get critical permissions that this role should never lose
     */
    public function getCriticalPermissions(): array
    {
        return match($this->name) {
            'tecnologias de la info' => [
                'information-technology.roles.viewAny',
                'information-technology.roles.update',
                'information-technology.roles.replicate',

                'information-technology.permissions.viewAny',
                'information-technology.permissions.update',
                'information-technology.permissions.update',

            ],
            'super' => [
                // Super admin critical permissions if needed
            ],
            'admin' => [
                // Admin critical permissions if needed
            ],
            default => []
        };
    }

    /**
     * Check if this role can deactivate a specific permission
     */
    public function canDeactivatePermission(string $permissionName): bool
    {
        return !in_array($permissionName, $this->getCriticalPermissions());
    }
}
