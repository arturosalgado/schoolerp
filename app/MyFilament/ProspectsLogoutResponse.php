<?php

namespace App\MyFilament;

use Filament\Auth\Http\Responses\Contracts\LogoutResponse;
use Filament\Facades\Filament;
use Illuminate\Http\RedirectResponse;

class ProspectsLogoutResponse implements LogoutResponse
{
    public function toResponse($request): RedirectResponse
    {
        $slug = session('prospect_school_slug');

        // If we have a stored school slug and came from the prospects panel
        if ($slug && str_contains($request->headers->get('referer', ''), '/prospects')) {
            return redirect('/prospects/' . $slug . '/register');
        }

        // Default: redirect to the current panel's login
        return redirect(Filament::getLoginUrl());
    }
}
