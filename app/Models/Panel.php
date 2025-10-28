<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Panel extends Model
{
    protected $guarded = [];

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'panel_user');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'panel_role');
    }
}
