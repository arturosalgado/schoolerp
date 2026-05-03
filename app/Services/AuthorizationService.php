<?php

namespace App\Services;

use App\Models\User;

class AuthorizationService
{
    // Maps each panel to the roles that can access it.
    // 'super' bypasses all checks and can access every panel.
    private const PANEL_ROLES = [
        'admin'   => ['admin', 'teacher'],
        'it'      => ['information_technology'],
        'finance' => ['finance'],
    ];

    public static function canAccessPanel(User $user, string $panelId): bool
    {
        $userRoles = $user->roles()->pluck('name')->toArray();

        if (\in_array('super', $userRoles)) {
            return true;
        }

        $allowed = self::PANEL_ROLES[$panelId] ?? [];

        return !empty(array_intersect($userRoles, $allowed));
    }
}
