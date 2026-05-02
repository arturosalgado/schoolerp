<?php

namespace App\Filament\Resources\Students\Pages;

use App\Filament\Resources\Students\StudentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected ?int $tempStudentStatusId = null;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (isset($data['student_status_id'])) {
            $this->tempStudentStatusId = $data['student_status_id'];
            unset($data['student_status_id']);
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        if ($this->tempStudentStatusId) {
            $schoolId = \app('currentSchoolId') ?? auth()->user()->schools()->first()?->id;
            if ($schoolId) {
                $this->record->schools()->updateExistingPivot($schoolId, [
                    'student_status_id' => $this->tempStudentStatusId,
                ]);
            }
        }
    }
}
