<?php

namespace App\MyFilament;

use App\Models\School;
use App\Services\CurpService;
use App\Services\MexicanStatesService;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class ProspectsRegister extends MyAdminRegister
{
    public ?School $school = null;

    public function mount(): void
    {
        $slug = request()->route('schoolSlug');

        \Log::info('[ProspectsRegister] mount()', ['slug' => $slug, 'url' => request()->url()]);

        if (! $slug) {
            \Log::error('[ProspectsRegister] No slug');
            abort(404);
        }

        $this->school = School::where('slug', $slug)->first();

        if (! $this->school) {
            \Log::error('[ProspectsRegister] School not found: ' . $slug);
            abort(404);
        }

        parent::mount();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                $this->getPaternoFormComponent()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($set, $get) => $this->generateCurp($set, $get)),

                $this->getMaternoFormComponent()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($set, $get) => $this->generateCurp($set, $get)),

                $this->getNombresFormComponent()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($set, $get) => $this->generateCurp($set, $get)),

                $this->getEmailFormComponent(),

                $this->getDateOfBirthFormComponent(),

                $this->getSexFormComponent(),

                $this->getStateOfBirthFormComponent(),

                $this->getCurpDisplayFormComponent(),

                $this->getPasswordFormComponent()
                    ->columnSpanFull(),

                $this->getPasswordConfirmationFormComponent()
                    ->columnSpanFull(),
            ]);
    }

    private function generateCurp(callable $set, callable $get): void
    {
        $firstName    = $get('name');
        $lastName     = $get('last_name');
        $secondLast   = $get('second_last_name') ?: 'X';
        $birthDate    = $get('dob');
        $gender       = $get('sex');
        $stateOfBirth = $get('state_of_birth');

        if (empty($firstName) || empty($lastName) || empty($birthDate) || empty($gender) || empty($stateOfBirth)) {
            return;
        }

        try {
            $curp = (new CurpService($firstName, $lastName, $secondLast, $birthDate, $gender, $stateOfBirth))->generate();
            $set('curp', $curp);
        } catch (\Exception) {}
    }

    protected function getDateOfBirthFormComponent(): Component
    {
        return DatePicker::make('dob')
            ->label('Fecha de Nacimiento')
            ->required()
            ->native(false)
            ->live()
            ->afterStateUpdated(fn($set, $get) => $this->generateCurp($set, $get));
    }

    protected function getSexFormComponent(): Component
    {
        return Select::make('sex')
            ->label('Sexo')
            ->required()
            ->options(['male' => 'Masculino', 'female' => 'Femenino'])
            ->live()
            ->afterStateUpdated(fn($set, $get) => $this->generateCurp($set, $get));
    }

    protected function getStateOfBirthFormComponent(): Component
    {
        $names = array_values(MexicanStatesService::getStateNames());

        return Select::make('state_of_birth')
            ->label('Estado de Nacimiento')
            ->required()
            ->options(array_combine($names, $names))
            ->searchable()
            ->live()
            ->afterStateUpdated(fn($set, $get) => $this->generateCurp($set, $get));
    }

    protected function getCurpDisplayFormComponent(): Component
    {
        return TextInput::make('curp')
            ->label('CURP')
            ->disabled()
            ->dehydrated()
            ->maxLength(18)
            ->placeholder('Se generará automáticamente');
    }

    protected function handleRegistration(array $data): Model
    {
        $firstName  = $data['name'];
        $lastName   = $data['last_name'];
        $secondLast = $data['second_last_name'] ?: 'X';

        if (!empty($firstName) && !empty($lastName) && !empty($data['dob']) && !empty($data['sex']) && !empty($data['state_of_birth'])) {
            try {
                $data['curp'] = (new CurpService(
                    $firstName,
                    $lastName,
                    $secondLast,
                    $data['dob'],
                    $data['sex'],
                    $data['state_of_birth']
                ))->generate();
            } catch (\Exception) {}
        }

        $data['name'] = trim("{$lastName} {$secondLast} {$firstName}");

        $user = $this->getUserModel()::create($data);

        $this->school->users()->attach($user->id);

        // Store school slug in session for logout redirect
        session(['prospect_school_slug' => $this->school->slug]);

        // Create prospect linked to user and active enrollment period
        $activeEnrollment = $this->school->enrollmentPeriods()
            ->where('is_active', true)
            ->first();

        \App\Models\Prospect::create([
            'school_id' => $this->school->id,
            'user_id' => $user->id,
            'enrollment_period_id' => $activeEnrollment?->id,
            'name' => $firstName,
            'last_name' => $lastName,
            'second_last_name' => $data['second_last_name'] ?? null,
            'email' => $data['email'] ?? null,
            'dob' => $data['dob'] ?? null,
            'sex' => $data['sex'] ?? null,
            'curp' => $data['curp'] ?? null,
            'source' => 'registration_form',
            'status' => 'new',
        ]);

        return $user;
    }
}
