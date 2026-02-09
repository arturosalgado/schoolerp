<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'resource',
        'resource_es',// if we just translate on the fly, the search doesnt work. for example for becas it finds nothing because it is stored as scholarship
        'action',
        'description',
        'panel'
    ];

    /**
     * Panel that this permission belongs to
     */
    public function panel(): BelongsTo
    {
        return $this->belongsTo(Panel::class);
    }

    /**
     * Roles that have this permission
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'permission_role')->withPivot('active')->withTimestamps();
    }

    /**
     * Find permission by name
     */
    public static function findByName(string $name): ?Permission
    {
        return static::where('name', $name)->first();
    }

    /**
     * Create permission with resource.action format
     */
    public static function createFromResourceAction(string $resource, string $action, ?string $description = null): Permission
    {
        return static::create([
            'name' => "{$resource}.{$action}",
            'resource' => $resource,
            'action' => $action,
            'description' => $description ?? "Permission to {$action} {$resource}"
        ]);
    }

    /**
     * Get all permissions for a specific resource
     */
    public static function forResource(string $resource): Collection
    {
        return static::where('resource', $resource)->get();
    }
}

