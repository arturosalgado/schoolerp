<?php

namespace App\MyFilament;

use App\Models\School;
use Filament\Actions\Action;

class ProspectsLogin extends MyAdminLogin
{
    public function mount(): void
    {
        $slug = request()->route('school');

        if ($slug && ! School::where('slug', $slug)->exists()) {
            abort(404);
        }

        parent::mount();
    }

    public function registerAction(): Action
    {
        return Action::make('register')->hidden();
    }
}
