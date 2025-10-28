<?php

namespace App\Filament\Resources\Students\Pages;

use App\Filament\Resources\Students\StudentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditStudent extends EditRecord
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load existing programs with their pivot data
        $programs = $this->record->programs()
            ->withPivot(['is_current', 'enrolled_at', 'completed_at'])
            ->get();

        $programsData = [];

        foreach ($programs as $program) {
            // Get the active study plan for this program
            $studyPlan = $this->record->studyPlans()
                ->where('student_study_plan.program_id', $program->id)
                ->where('student_study_plan.is_active', true)
                ->first();

            // Get the terminal for this study plan if it exists
            $terminal = null;
            if ($studyPlan) {
                $terminal = $this->record->terminals()
                    ->where('student_terminal.study_plan_id', $studyPlan->id)
                    ->first();
            }

            $programsData[] = [
                'program_id' => $program->id,
                'study_plan_id' => $studyPlan?->id,
                'terminal_id' => $terminal?->id,
                'is_current' => $program->pivot->is_current ? 1 : 0,
                'enrolled_at' => $program->pivot->enrolled_at,
                'completed_at' => $program->pivot->completed_at,
            ];
        }

        $data['student_programs'] = $programsData;

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Handle saving the program, study plan, and terminal relationships
        if (isset($data['student_programs']) && is_array($data['student_programs'])) {
            $programIds = [];
            $studyPlanIds = [];
            $terminalIds = [];

            foreach ($data['student_programs'] as $programData) {
                if (!empty($programData['program_id'])) {
                    $programIds[$programData['program_id']] = [
                        'is_current' => $programData['is_current'] ?? 0,
                        'enrolled_at' => $programData['enrolled_at'] ?? now(),
                        'completed_at' => $programData['completed_at'] ?? null,
                    ];

                    if (!empty($programData['study_plan_id'])) {
                        $studyPlanIds[$programData['study_plan_id']] = [
                            'program_id' => $programData['program_id'],
                            'is_active' => true,
                            'assigned_at' => $programData['enrolled_at'] ?? now(),
                            'progress_percentage' => 0.00,
                            'completed_subjects' => null,
                        ];

                        // Handle terminal relationship if selected
                        if (!empty($programData['terminal_id'])) {
                            $terminalIds[$programData['terminal_id']] = [
                                'study_plan_id' => $programData['study_plan_id'],
                            ];
                        }
                    }
                }
            }

            // Sync the relationships
            $this->record->programs()->sync($programIds);
            $this->record->studyPlans()->sync($studyPlanIds);
            $this->record->terminals()->sync($terminalIds);
        }

        // Remove student_programs from data since it's not a column in students table
        unset($data['student_programs']);

        return $data;
    }
}
