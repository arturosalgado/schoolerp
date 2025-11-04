@php
    use Filament\Facades\Filament;

    $user = filament()->auth()->user();
    $currentPanel = filament()->getCurrentPanel();

    // Get all available panels
    $allPanels = Filament::getPanels();
    $availablePanels = [];

    foreach ($allPanels as $panel) {
        // Check if user can access this panel and it's not the current one
        if ($user->canAccessPanel($panel) && $panel->getId() !== $currentPanel->getId()) {
            $availablePanels[] = $panel;
        }
    }

    // Panel display names and icons
    $panelConfig = [
        'admin' => [
            'label' => 'Admin Panel',
            'icon' => 'heroicon-o-shield-check',
            'color' => 'success'
        ],
        'it' => [
            'label' => 'IT Panel',
            'icon' => 'heroicon-o-wrench-screwdriver',
            'color' => 'info'
        ],
        'finance' => [
            'label' => 'Finance Panel',
            'icon' => 'heroicon-o-currency-dollar',
            'color' => 'warning'
        ],
    ];
@endphp

<x-filament-widgets::widget class="fi-account-widget">
    <x-filament::section>
        <x-filament-panels::avatar.user
            size="lg"
            :user="$user"
            loading="lazy"
        />

        <div class="fi-account-widget-main">
            <h2 class="fi-account-widget-heading">
                {{ __('filament-panels::widgets/account-widget.welcome', ['app' => config('app.name')]) }}
            </h2>

            <p class="fi-account-widget-user-name">
                {{ filament()->getUserName($user) }}
            </p>
        </div>

        @if(count($availablePanels) > 0)
            @foreach($availablePanels as $panel)
                @php
                    $panelId = $panel->getId();
                    $config = $panelConfig[$panelId] ?? [
                        'label' => ucfirst($panelId),
                        'icon' => 'heroicon-o-rectangle-group',
                        'color' => 'gray'
                    ];

                    // Build URL for panel
                    if ($panel->hasTenancy() && Filament::getTenant()) {
                        $panelUrl = route("filament.{$panelId}.tenant", ['tenant' => Filament::getTenant()]);
                    } else {
                        $panelUrl = $panel->getUrl();
                    }
                @endphp

                <x-filament::button
                    :href="$panelUrl"
                    tag="a"
                    :color="$config['color']"
                    :icon="$config['icon']"
                    size="sm"
                    outlined
                >
                    {{ $config['label'] }}
                </x-filament::button>
            @endforeach
        @endif

        <form
            action="{{ filament()->getLogoutUrl() }}"
            method="post"
            class="fi-account-widget-logout-form"
        >
            @csrf

            <x-filament::button
                color="gray"
                :icon="\Filament\Support\Icons\Heroicon::ArrowLeftEndOnRectangle"
                :icon-alias="\Filament\View\PanelsIconAlias::WIDGETS_ACCOUNT_LOGOUT_BUTTON"
                size="sm"
                tag="button"
                type="submit"
                outlined
            >
                {{ __('filament-panels::widgets/account-widget.actions.logout.label') }}
            </x-filament::button>
        </form>
    </x-filament::section>
</x-filament-widgets::widget>
