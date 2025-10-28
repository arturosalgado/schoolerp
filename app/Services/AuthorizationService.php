<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthorizationService
{
        public static function canAccessPanel(User $user, string $panelId){
            //dump($panelId);
            //dd($user->name);

            if ($user->id===1){
                //dd('true');
                return true;
            }

            $schools = $user->schools()->pluck('id')->toArray();

            $can = DB::table('panels')->
            join('panel_role', 'panels.id', '=', 'panel_role.panel_id')->
            join('roles', 'roles.id', '=', 'panel_role.role_id')->
            join('role_user', 'role_user.role_id', '=', 'roles.id')->
            where('role_user.user_id', $user->id)->
            whereIn('roles.school_id',$schools)->
            where('panels.name', $panelId)->exists();

            //dd($can);
            return $can;

        }
}
