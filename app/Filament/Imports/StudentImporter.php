<?php

namespace App\Filament\Imports;

use App\Models\Program;
use App\Models\Student;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Number;

class StudentImporter extends Importer
{
    protected static ?string $model = Student::class;

    public static function getColumns(): array
    {
        return [
            // Spanish column names mapped to English fields using fillRecordUsing
            ImportColumn::make('enrollment')
                ->label('Matricula')
                ->exampleHeader('Matricula')
                ->rules(['required'])
                ->fillRecordUsing(function ($record, $state) {
                    $record->enrollment = $state;
                }),

            ImportColumn::make('last_name')
                ->label('Apellido Paterno')
                ->rules(['required'])
                ->exampleHeader('Apellido Paterno')
                ->fillRecordUsing(function ($record, $state) {
                    $record->last_name = $state;
                }),

            ImportColumn::make('second_last_name')
                ->label('Apellido Materno')
                ->exampleHeader('Apellido Materno')
                ->fillRecordUsing(function ($record, $state) {
                    $record->second_last_name = $state;
                }),

            ImportColumn::make('name')
                ->label('Nombre(s)')
                ->exampleHeader('Nombre(s)')
                ->rules(['required'])
                ->fillRecordUsing(function ($record, $state) {
                    $record->name = $state;
                }),

            ImportColumn::make('email')
                ->label('Correo Electrónico')
                ->exampleHeader('Correo Electrónico')
                ->rules(['required', 'email'])
                ->fillRecordUsing(function ($record, $state) {
                    $record->email = $state;
                }),

            ImportColumn::make('mobile')
                ->label('Celular')
                ->rules(['required'])
                ->exampleHeader('Celular')
                ->fillRecordUsing(function ($record, $state) {
                    $record->mobile = $state;
                }),

            ImportColumn::make('program')
                ->label('Programa')
                ->exampleHeader('Programa')

        ];
    }

    public function resolveRecord(): Student
    {
        Log::info('=== RESOLVE RECORD START ===');
        Log::info('Raw data received:', $this->data);

        // Get enrollment from Spanish column name
        $enrollment = $this->data['enrollment'] ?? null;
        Log::info('Enrollment extracted:', ['enrollment' => $enrollment]);

        $student = Student::firstOrNew([
            'enrollment' => $enrollment,
        ]);

        Log::info('Student resolved:', [
            'exists' => $student->exists,
            'id' => $student->id,
            'enrollment' => $student->enrollment
        ]);

        Log::info('=== RESOLVE RECORD END ===');

        return $student;
    }
    protected function beforeSave(): void
    {
        Log::info('=== BEFORE SAVE START ===');
        Log::info('Record state before save:', [
            'id' => $this->record->id,
            'enrollment' => $this->record->enrollment,
            'name' => $this->record->name,
            'email' => $this->record->email,
            'exists' => $this->record->exists
        ]);
        unset($this->record->program);
        // Set school_id and password (these aren't in the CSV)
        $this->record->school_id = 1; // school_id();
        Log::info('School ID set to:', ['school_id' => $this->record->school_id]);

        if (empty($this->record->password)) {
            $this->record->password = $this->record->enrollment;
            Log::info('Password set to enrollment:', ['enrollment' => $this->record->enrollment]);
        }

        Log::info('=== BEFORE SAVE END ===');


       // unset($this->data['program']);
    }

    protected function afterSave(): void
    {
//        Log::info('=== AFTER SAVE START ===');
//        Log::info('Record state after save:', [
//            'id' => $this->record->id,
//            'enrollment' => $this->record->enrollment,
//            'name' => $this->record->name,
//            'email' => $this->record->email,
//            'school_id' => $this->record->school_id,
//            'user_id' => $this->record->user_id
//        ]);

        // Handle the many-to-many relationship with Program
        $programName = $this->data['program'] ?? null;
//        Log::info('All data contents:', $this->data);
//        Log::info('Program from CSV:', ['program' => $programName]);

        if (!empty($programName)) {
            // Try to find the program by name
            $program = Program::where('name', $programName)->first();

            if ($program) {
                Log::info('Program found:', [
                    'program_id' => $program->id,
                    'program_name' => $program->name
                ]);

                // Attach the program to the student
             //   Log::info('Attempting to attach program to student...');

                try {
                    $this->record->programs()->syncWithoutDetaching([
                        $program->id => [
                            'is_current' => true,
                            'enrolled_at' => now()
                        ]
                    ]);

                   // Log::info('Program attached successfully!');

                    // Verify the attachment
                    $attachedPrograms = $this->record->programs()->get();
                    Log::info('Programs now attached to student:', [
                        'count' => $attachedPrograms->count(),
                        'programs' => $attachedPrograms->pluck('name', 'id')->toArray()
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to attach program:', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            } else {
               // Log::warning('Program not found in database:', ['program_name' => $programName]);

                // List available programs for debugging
                $availablePrograms = Program::pluck('name', 'id')->toArray();
                //Log::info('Available programs in database:', $availablePrograms);
            }
        } else {
            Log::warning('No program name provided in CSV data');
        }

        //Log::info('=== AFTER SAVE END ===');
    }


    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your student import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
