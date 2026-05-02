<?php

namespace App\Filament\Resources\Students\Pages;

use App\Filament\Resources\Programs\ProgramResource;
use App\Filament\Resources\Students\StudentResource;
use App\Models\Program;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    public function mount(): void
    {
        parent::mount();

        $hasPrograms = Program::where('school_id', school_id())->where('active', true)->exists();

        if (!$hasPrograms) {
            Notification::make()
                ->title('No hay programas registrados')
                ->body('Debes agregar al menos un programa antes de registrar alumnos. Serás redirigido a la sección de Programas.')
                ->warning()
                ->persistent()
                ->send();

            $this->redirect(ProgramResource::getUrl('index'));
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
