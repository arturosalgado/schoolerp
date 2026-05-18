<?php

namespace App\MyFilament;

use Filament\Facades\Filament;
use Filament\Http\Controllers\Auth\LogoutController;
use Illuminate\Http\Request;

class ProspectsLogout extends LogoutController
{
    public function __invoke(Request $request)
    {
        // Get the user's school slug before logging out
        $user = Filament::auth()->user();
        $school = $user?->schools()->first();
        $slug = $school?->slug;

        Filament::auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($slug) {
            return redirect('/prospects/' . $slug . '/register');
        }

        return redirect('/prospects/login');
    }
}
