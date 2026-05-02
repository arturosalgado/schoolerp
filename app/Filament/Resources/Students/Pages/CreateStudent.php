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
        //dump("in mutate ");
        //dump("data before mutation ", $data);
        if (isset($data['student_status_id'])) {
            $this->tempStudentStatusId = $data['student_status_id'];
            unset($data['student_status_id']);
        }

        unset($data['student_programs']);
      //  dump('data after ', $data);
      //  dump('this status id ', $this->tempStudentStatusId);
        //dd();

        return $data;
    }

    protected function afterCreate(): void
    {   

       // dd("after create ", $this->record, " temp status id ", $this->tempStudentStatusId);

        if ($this->tempStudentStatusId) {
            $schoolId = school_id();
            //dd("current school",$schoolId);
            if ($schoolId) {
                $this->record->schools()->updateExistingPivot($schoolId, [
                    'student_status_id' => $this->tempStudentStatusId,
                ]);
            }
        }
    }
}
