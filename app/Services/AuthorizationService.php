<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthorizationService
{
        public static function canAccessPanel(User $user, string $panelId){
            // Super admin always has access
            if ($user->id===1){
                return true;
            }

            // Allow new users without schools to access admin panel for tenant registration
            if ($user->schools()->count() === 0 && $panelId === 'admin') {
                return true;
            }

            // Check if user has a role with access to the panel
            $schools = $user->schools()->pluck('id')->toArray();

            $can = DB::table('panels')->
            join('panel_role', 'panels.id', '=', 'panel_role.panel_id')->
            join('roles', 'roles.id', '=', 'panel_role.role_id')->
            join('role_user', 'role_user.role_id', '=', 'roles.id')->
            where('role_user.user_id', $user->id)->
            whereIn('roles.school_id',$schools)->
            where('panels.name', $panelId)->exists();

            return $can;

        }
}
