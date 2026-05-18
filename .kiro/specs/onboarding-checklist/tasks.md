# Tasks: Onboarding Checklist Widget

## Task 1: Create the base OnboardingChecklistWidget class for Admin panel

- [ ] 1.1 Create `app/Filament/Widgets/OnboardingChecklistWidget.php` extending `Filament\Widgets\Widget`
- [ ] 1.2 Implement `canView()` static method that returns false when all setup items are complete for the current tenant
- [ ] 1.3 Implement `getChecklistItems()` method returning array of items with label, description, complete status, URL, and icon
- [ ] 1.4 Implement protected URL methods (`getCyclesUrl`, `getTermsUrl`, `getProgramsUrl`) using Admin panel resource classes
- [ ] 1.5 Set sort priority to `-2` and `$isLazy = false`

## Task 2: Create the Blade view for the widget

- [ ] 2.1 Create `resources/views/filament/widgets/onboarding-checklist-widget.blade.php`
- [ ] 2.2 Render widget title "Configuración de la Escuela" and progress indicator (X/3 complete)
- [ ] 2.3 Render each checklist item with checkbox icon (filled/empty), label, and description
- [ ] 2.4 Render "Configurar" button for incomplete items linking to the resource URL
- [ ] 2.5 Show "Completo" badge for completed items
- [ ] 2.6 Use Filament component classes (`x-filament-widgets::widget`, `x-filament::section`) for consistent styling

## Task 3: Create the IT panel OnboardingChecklistWidget subclass

- [ ] 3.1 Create `app/Filament/It/Widgets/OnboardingChecklistWidget.php` extending the base widget
- [ ] 3.2 Override URL methods to point to IT panel resource classes (`App\Filament\It\Resources\Cycles\CycleResource`, etc.)

## Task 4: Register widgets in panel providers

- [ ] 4.1 Verify the Admin panel auto-discovers widgets from `app/Filament/Widgets/` (already configured in AdminPanelProvider)
- [ ] 4.2 Verify the IT panel auto-discovers widgets from `app/Filament/It/Widgets/` (already configured in ItPanelProvider)

## Task 5: Verify translations exist

- [ ] 5.1 Confirm all required translation keys exist in `lang/es/fields.php` (`school_configuration`, `setup_progress`, `setup`, `complete`, `school_cycles`, `school_cycles_description`, `terms`, `terms_description`, `programs`, `programs_description`)
- [ ] 5.2 Add any missing translation keys if needed
