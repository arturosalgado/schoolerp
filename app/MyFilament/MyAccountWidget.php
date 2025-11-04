<?php

namespace App\MyFilament;

use Filament\Widgets\AccountWidget;

class MyAccountWidget extends AccountWidget
{
    protected static ?int $sort = -3;

    protected static bool $isLazy = false;

    /**
     * @var view-string
     */
    protected string $view = 'filament.widgets.my-account-widget';
    #protected string $view = 'filament-panels::widgets.account-widget';

}
