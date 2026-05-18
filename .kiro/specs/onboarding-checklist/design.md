# Design Document: Onboarding Checklist Widget

## Overview

A Filament dashboard widget that displays an onboarding checklist for school tenants. The widget checks whether essential configuration (cycles, terms, programs) exists and guides administrators through setup. It renders on both the Admin and IT panels and hides completely once all items are satisfied.

## Architecture

### Component Structure

```
app/Filament/Widgets/OnboardingChecklistWidget.php   ← Shared widget class (Admin panel)
app/Filament/It/Widgets/OnboardingChecklistWidget.php ← IT panel widget (extends or duplicates)
resources/views/filament/widgets/onboarding-checklist-widget.blade.php ← Blade view
```

**Approach:** Create a single widget class in `app/Filament/Widgets/` for the Admin panel. For the IT panel, create a lightweight subclass in `app/Filament/It/Widgets/` that extends the base widget but overrides the resource URL resolution to point to IT panel resources.

### Widget Class Design

```php
// app/Filament/Widgets/OnboardingChecklistWidget.php
namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class OnboardingChecklistWidget extends Widget
{
    protected static ?int $sort = -2; // High priority, below account widget
    protected static bool $isLazy = false;
    protected string $view = 'filament.widgets.onboarding-checklist-widget';

    public static function canView(): bool
    {
        // Hide widget entirely when all items are complete
        $school = filament()->getTenant();
        if (!$school) return false;

        return !static::isSetupComplete($school);
    }

    public function getChecklistItems(): array
    {
        $school = filament()->getTenant();
        return [
            [
                'key' => 'cycles',
                'label' => __('fields.school_cycles'),
                'description' => __('fields.school_cycles_description'),
                'complete' => \App\Models\Cycle::where('school_id', $school->id)->exists(),
                'url' => $this->getCyclesUrl(),
                'icon' => 'heroicon-o-calendar-days',
            ],
            [
                'key' => 'terms',
                'label' => __('fields.terms'),
                'description' => __('fields.terms_description'),
                'complete' => \App\Models\Term::where('school_id', $school->id)->exists(),
                'url' => $this->getTermsUrl(),
                'icon' => 'heroicon-o-clock',
            ],
            [
                'key' => 'programs',
                'label' => __('fields.programs'),
                'description' => __('fields.programs_description'),
                'complete' => \App\Models\Program::where('school_id', $school->id)->exists(),
                'url' => $this->getProgramsUrl(),
                'icon' => 'heroicon-o-academic-cap',
            ],
        ];
    }

    protected static function isSetupComplete($school): bool
    {
        return \App\Models\Cycle::where('school_id', $school->id)->exists()
            && \App\Models\Term::where('school_id', $school->id)->exists()
            && \App\Models\Program::where('school_id', $school->id)->exists();
    }

    // Resource URL methods - overridden in IT panel subclass
    protected function getCyclesUrl(): string { ... }
    protected function getTermsUrl(): string { ... }
    protected function getProgramsUrl(): string { ... }
}
```

### IT Panel Widget

```php
// app/Filament/It/Widgets/OnboardingChecklistWidget.php
namespace App\Filament\It\Widgets;

use App\Filament\Widgets\OnboardingChecklistWidget as BaseWidget;

class OnboardingChecklistWidget extends BaseWidget
{
    // Override URL methods to point to IT panel resources
    protected function getCyclesUrl(): string { ... }
    protected function getTermsUrl(): string { ... }
    protected function getProgramsUrl(): string { ... }
}
```

### Blade View

The view renders a card with:
- Title: "Configuración de la Escuela"
- Progress bar showing X/3 items complete
- List of checklist items with checkbox icons (filled when complete, empty when not)
- Each incomplete item has a "Configurar" button linking to the relevant resource

### URL Resolution

Use Filament's `Resource::getUrl()` static method to generate tenant-aware URLs:
- Admin: `\App\Filament\Resources\Cycles\CycleResource::getUrl('index')`
- IT: `\App\Filament\It\Resources\Cycles\CycleResource::getUrl('index')`

### Visibility Logic

The `canView()` method checks all three conditions. This runs on every dashboard load, ensuring the widget disappears as soon as setup is complete. The queries are lightweight (`EXISTS` checks) and scoped to the tenant.

## Data Flow

1. User navigates to dashboard
2. Filament calls `canView()` on widget → checks if any item is incomplete
3. If incomplete: widget renders, `getChecklistItems()` evaluates each item
4. User clicks "Configurar" → navigates to resource list page
5. User creates the required record
6. User returns to dashboard → widget re-evaluates, item now shows as complete
7. When all items complete → `canView()` returns false → widget not rendered

## Translations

All text uses existing keys from `lang/es/fields.php`:
- `fields.school_configuration` → Widget title
- `fields.school_cycles` / `fields.school_cycles_description` → Cycles item
- `fields.terms` / `fields.terms_description` → Terms item
- `fields.programs` / `fields.programs_description` → Programs item
- `fields.setup_progress` → Progress label
- `fields.setup` → Button text for incomplete items
- `fields.complete` → Status text for complete items
