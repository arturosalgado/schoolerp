<?php

namespace App\Schemas\Students;

use App\Services\SchoolFileUploadService;
use App\Services\CurpService;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class StudentSections
{
    private static function generateCurpIfPossible(callable $set, callable $get): void
    {
        // Check if CURP is already filled
        $curp = $get('curp');
        if (!empty($curp)) {
            return;
        }

        // Get all required fields
        $firstName = $get('name');
        $lastName = $get('last_name');
        $secondLastName = $get('second_last_name');
        $birthDate = $get('dob');
        $gender = $get('sex');
        $stateId = $get('state_id');

        // Check if all dependencies are filled
        if (empty($firstName) || empty($lastName) || empty($birthDate) || empty($gender) || empty($stateId)) {
            return;
        }

        // If second_last_name is empty, use 'X' as default
        if (empty($secondLastName)) {
            $secondLastName = 'X';
        }

        try {
            // Get the state name from state_id
            $state = \App\Models\State::find($stateId);
            if (!$state) {
                return;
            }

            // Generate CURP using the service
            $curpService = new CurpService(
                $firstName,
                $lastName,
                $secondLastName,
                $birthDate,
                $gender,
                $state->name
            );

            $generatedCurp = $curpService->generate();
            $set('curp', $generatedCurp);
        } catch (\Exception $e) {
            // If CURP generation fails, silently do nothing
            // You could log this error if needed
        }
    }

    public static function getPersonalData($panel=null ):Section{

        $section  = Section::make('Datos Personales')
            //  ->label('Datos Academicos')
            ->schema([
                TextInput::make('last_name')
                    ->required()
                    ->label('Apellido Paterno')
                    ->maxLength(255)
                    ->columnSpan(1)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        static::generateCurpIfPossible($set, $get);
                    })
                ,
                TextInput::make('second_last_name')
                    ->label('Apellido Materno')
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        static::generateCurpIfPossible($set, $get);
                    })
                ,
                TextInput::make('name')
                    ->label('Nombre(s)')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        static::generateCurpIfPossible($set, $get);
                    })
                ,


                Select::make('state_id')
                    ->label('Estado de Nacimiento')
                    ->required(function ($get) use ($panel) {
                        if ($panel!=null and $panel == 'it') {
                            return false;
                        }
                        return true;
                    })
                    ->relationship('state', 'name')
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        static::generateCurpIfPossible($set, $get);
                    })


                ,
                DatePicker::make('dob')
                    ->required(
                        function ($get) use ($panel) {
                            if ($panel!=null and $panel == 'it') {
                                return false;
                            }
                            return true;
                        }
                    )
                    ->label('Fecha de Nacimiento')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        static::generateCurpIfPossible($set, $get);
                    })
                ,


                Radio::make('sex')
                    ->options([
                        'male' => 'Masculino',
                        'female' => 'Femenino'
                    ])
                    ->label('Genero')
                    ->required(
                        function ($get) use ($panel) {
                            if ($panel!=null and $panel == 'it') {
                                return false;
                            }
                            return true;
                        }
                    )
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        static::generateCurpIfPossible($set, $get);
                    })
                ,

                TextInput::make('curp')
                    ->label('CURP')
                    ->required(function ($get) use ($panel) {
                        if ($panel!=null and $panel == 'it') {
                            return false;
                        }
                        return true;
                    })
                    ->maxLength(18)
                ,
                Select::make('blood_type_id')->
                    label('Tipo de Sangre')->
                relationship('bloodType', 'name')
                    ,

            ],


            )
            ->columns([
                'xl' => 3, // Monitor 1920px
                '2xl' => 4,// monitor 3440px
            ]);


        return $section;

    }
    public static function getPhoto($panel = null):Section{
        return Section::make()
            ->collapsible()
            ->heading(__('fields.photo'))

            ->schema([
                FileUpload::make('photo')
                    ->disk('s3')
                    ->directory(SchoolFileUploadService::getStudentPhotoDirectory())
                    ->visibility('public')
                    ->image()
                    ->hiddenLabel()
                    ->imageEditor()
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1.2')
                    ->imageResizeTargetWidth('400')
                    ->imageResizeTargetHeight('460')
                    ->maxSize(5048) // 2MB max (reduced from 5MB)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])

                //->helperText('Las imágenes se redimensionarán automáticamente a 300x300px. Tamaño máximo: 2MB'),
            ]);
    }
    public static function getContactData($panel = null):Section{

        $section  = Section::make('Datos de Contacto')
            //  ->label('Datos Academicos')
            ->schema([
                TextInput::make('email')

                    ->required()// because the account for user is created , email is required
                    ->label('Correo Electrónico')
                    ->maxLength(255)
                    ->columnSpan(1)
                ,
                TextInput::make('mobile')
                    ->required(function ($get) use ($panel) {
                        if ($panel=='it'){
                            return false;
                        }
                        return true;
                    })
                    ->label('Celular')
                    ->maxLength(255)
                ,
                TextInput::make('emergency_name')
                  //  ->required()
                    ->label('Nombre para Emergencias')
                    ->maxLength(255)
                ->columnSpan(1)
                ,
                TextInput::make('emergency_phone')
                   // ->required()
                    ->label('Telefono para Emergencias')
                    ->maxLength(255)->columnSpan(1)
                ,

            ],


            )

            // ->columns(3);
            ->columns([


                'xl' => 4,
                '2xl' => 4,
            ]);

        return $section;

    }


    public static function getAcademicData(){

        return
        Section::make('Datos Academicos')->schema([
           // Select::make('school_id')
            TextInput::make('enrollment')->label('Matricula'),


        ]);
    }

    public static function getProgramsOfStudy()
    {
        return Section::make()
            ->heading('Datos Academicos')
            ->description('Gestiona los programas y planes de estudio del estudiante')
            ->schema([
                TextInput::make('enrollment')->label('Matricula')->columnSpan(1),
                Repeater::make('student_programs')
                    ->columnSpanFull(2)
                    ->label('Programas')
                    ->schema([
                        Select::make('program_id')
                            ->label('Programa')
                            ->options(function () {
                                return \App\Models\Program::with('programLevel')
                                    ->where('school_id', school_id())
                                    ->where('active', true)
                                    ->get()
                                    ->mapWithKeys(function ($program) {
                                        $name = $program->name;

                                        if ($program->programLevel) {
                                            $abbreviation = strtoupper(substr($program->programLevel->name, 0, 3));
                                            $name .= " ({$abbreviation})";
                                        }

                                        return [$program->id => $name];
                                    });
                            })
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (callable $set) {
                                $set('study_plan_id', null);
                                $set('terminal_id', null);
                            }),

                        Select::make('study_plan_id')
                           // ->columnSpan(2)
                            ->label('Plan de Estudios')
                            ->options(function (callable $get) {
                                $programId = $get('program_id');

                                if (!$programId) {
                                    return [];
                                }

                                return \App\Models\StudyPlan::where('program_id', $programId)
                                    ->whereHas('program', function ($query) {
                                        $query->where('school_id', school_id());
                                    })
                                    ->get()
                                    ->mapWithKeys(function ($studyPlan) {
                                        $label = "{$studyPlan->name} ({$studyPlan->effective_year})";
                                        $label .= " - {$studyPlan->total_credits} créditos";
                                        return [$studyPlan->id => $label];
                                    });
                            })
                            ->visible(fn (callable $get) => filled($get('program_id')))
                            ->live()
                            ->afterStateUpdated(fn (callable $set) => $set('terminal_id', null))
                           // ->searchable()

                        ,
                        Select::make('terminal_id')
                            ->label('Terminal')
                            ->options(function (callable $get) {
                                $studyPlanId = $get('study_plan_id');

                                if (!$studyPlanId) {
                                    return [];
                                }

                                return \App\Models\Terminal::where('study_plan_id', $studyPlanId)
                                    ->where('school_id', school_id())
                                    ->where('active', true)
                                    ->get()
                                    ->pluck('name', 'id');
                            })
                            ->visible(true)
                            //->searchable()
                        ,
                        Select::make('is_current')
                            ->label('Estado')
                            ->options([
                                1 => 'Programa Actual',
                                0 => 'Programa Histórico',
                            ])
                            ->default(1)
                           // ->required()
                        ,

                        DatePicker::make('enrolled_at')
                            ->label('Fecha de Inscripción')
                            ->default(now()),

                        DatePicker::make('completed_at')
                            ->label('Fecha de Finalización')
                            ->visible(fn (callable $get) => $get('is_current') == 0),
                    ])
                    ->columns(3)
                    ->defaultItems(1)
                    ->addActionLabel('Agregar Programa')
                    ->reorderableWithButtons()
                    ->collapsible()
                    ->itemLabel(function (array $state): ?string {
                        if (!isset($state['program_id']) || !$state['program_id']) {
                            return 'Nuevo Programa';
                        }

                        $program = \App\Models\Program::find($state['program_id']);
                        $status = ($state['is_current'] ?? 1) ? '(Actual)' : '(Histórico)';

                        return $program ? "{$program->name} {$status}" : 'Programa';
                    })
                    ->dehydrated(true), // Allow form data to be saved
            ])
            ->columns(4)
            ->collapsible();
        //->collapsed()

    }



}
