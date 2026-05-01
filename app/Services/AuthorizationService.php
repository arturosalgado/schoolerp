<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthorizationService
{
        public static function canAccessPanel(User $user, string $panelId){
           
           

            return true;

        }
}
