# Requirements Document

## Introduction

An onboarding checklist widget for the school admin dashboard that guides newly registered schools through essential initial configuration steps. The widget verifies that cycles, terms, and programs have been set up correctly, providing a visual checklist with progress tracking. Once all items are complete, the widget disappears or displays a completion state.

## Glossary

- **Onboarding_Widget**: A Filament dashboard widget that displays a checklist of required configuration steps for a school tenant
- **School_Tenant**: The current school context in the multi-tenant system, identified by `school_id`
- **Cycle**: An academic year/cycle record belonging to a school (model: `Cycle` with `school_id`, `start_date`, `end_date`, `is_active`)
- **Term**: An academic period within a cycle (model: `Term` with `name`, `cycle_id`, `school_id`, `is_active`, `order`)
- **Program**: An academic program offered by a school (model: `Program` with `name`, `school_id`, `active`, `program_level_id`)
- **Checklist_Item**: A single verifiable step in the onboarding process, displayed as a checkbox-style element
- **Setup_Complete_State**: The state where all checklist items have been verified as complete
- **Admin_Panel**: The main Filament admin panel at `/admin` path using School as tenant
- **IT_Panel**: The IT/information-technology Filament panel at `/information-technology` path using School as tenant

## Requirements

### Requirement 1: Display Onboarding Widget on Dashboard

**User Story:** As a school administrator, I want to see an onboarding checklist on my dashboard when my school is new, so that I know what configuration steps are needed.

#### Acceptance Criteria

1. WHEN a school tenant has not completed all onboarding steps, THE Onboarding_Widget SHALL display on the dashboard of the Admin_Panel
2. WHEN a school tenant has not completed all onboarding steps, THE Onboarding_Widget SHALL display on the dashboard of the IT_Panel
3. THE Onboarding_Widget SHALL display a title "Configuración de la Escuela" and a progress indicator showing the number of completed items out of total items
4. THE Onboarding_Widget SHALL render with high sort priority so it appears at the top of the dashboard

### Requirement 2: Verify Cycles Configuration

**User Story:** As a school administrator, I want the checklist to verify that at least one academic cycle exists, so that I can confirm my school's calendar is set up.

#### Acceptance Criteria

1. THE Onboarding_Widget SHALL include a Checklist_Item labeled "Ciclos Escolares" with description "Años/ciclos académicos"
2. WHEN at least one Cycle record exists for the current School_Tenant, THE Onboarding_Widget SHALL mark the cycles Checklist_Item as complete
3. WHEN no Cycle records exist for the current School_Tenant, THE Onboarding_Widget SHALL mark the cycles Checklist_Item as incomplete
4. WHEN the cycles Checklist_Item is incomplete, THE Onboarding_Widget SHALL provide a link or action to navigate to the Cycles resource

### Requirement 3: Verify Terms Configuration

**User Story:** As a school administrator, I want the checklist to verify that at least one academic term exists, so that I can confirm my periods are configured.

#### Acceptance Criteria

1. THE Onboarding_Widget SHALL include a Checklist_Item labeled "Períodos" with description "Términos, semestres o períodos dentro de los ciclos"
2. WHEN at least one Term record exists for the current School_Tenant, THE Onboarding_Widget SHALL mark the terms Checklist_Item as complete
3. WHEN no Term records exist for the current School_Tenant, THE Onboarding_Widget SHALL mark the terms Checklist_Item as incomplete
4. WHEN the terms Checklist_Item is incomplete, THE Onboarding_Widget SHALL provide a link or action to navigate to the Terms resource

### Requirement 4: Verify Programs Configuration

**User Story:** As a school administrator, I want the checklist to verify that at least one program exists, so that I can confirm my academic offerings are loaded.

#### Acceptance Criteria

1. THE Onboarding_Widget SHALL include a Checklist_Item labeled "Programas" with description "Programas académicos ofrecidos por su escuela"
2. WHEN at least one Program record exists for the current School_Tenant, THE Onboarding_Widget SHALL mark the programs Checklist_Item as complete
3. WHEN no Program records exist for the current School_Tenant, THE Onboarding_Widget SHALL mark the programs Checklist_Item as incomplete
4. WHEN the programs Checklist_Item is incomplete, THE Onboarding_Widget SHALL provide a link or action to navigate to the Programs resource

### Requirement 5: Hide Widget When Setup Is Complete

**User Story:** As a school administrator, I want the checklist to disappear once all items are done, so that my dashboard is not cluttered after onboarding.

#### Acceptance Criteria

1. WHEN all Checklist_Items are marked as complete, THE Onboarding_Widget SHALL not render on the dashboard
2. THE Onboarding_Widget SHALL evaluate completeness on each dashboard load by checking the existence of Cycle, Term, and Program records for the current School_Tenant

### Requirement 6: Multi-Panel Consistency

**User Story:** As a school administrator, I want the onboarding checklist to behave consistently across both the Admin and IT panels, so that I get the same guidance regardless of which panel I use.

#### Acceptance Criteria

1. THE Onboarding_Widget SHALL use the same verification logic for Checklist_Items in both the Admin_Panel and the IT_Panel
2. THE Onboarding_Widget SHALL resolve navigation links to the correct resource URLs based on the current panel context
3. THE Onboarding_Widget SHALL use translations from the `lang/es/fields.php` file for all user-facing text
