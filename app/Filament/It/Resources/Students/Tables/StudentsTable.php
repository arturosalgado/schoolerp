<?php

namespace App\Filament\It\Resources\Students\Tables;
use Filament\Actions\Action;
use App\Tables\Students\StudentTable;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\ImportAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use App\Filament\Imports\StudentImporter;

use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use App\Jobs\ProcessStudentPhotos;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class StudentsTable
{


    public static function configure(Table $table): Table{
        $table =  StudentTable::getTable($table,'it');

        $table->headerActions([
            ImportAction::make()
                ->importer(StudentImporter::class)
            ,
            Action::make('attachPictures')
                ->label('Adjuntar Fotos')
                ->icon(Heroicon::OutlinedPhoto)
                ->form([
                    FileUpload::make('pictures')
                        ->label('Fotografías')
                        ->multiple()
                        ->image()
                        ->imageEditor()
                        ->directory('temp/student-pictures')
                        ->disk('public')
                        ->preserveFilenames()
                        ->maxFiles(50)
                        ->reorderable()
                        ->appendFiles()
                        ->panelLayout('grid')
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
                        ->maxSize(5120) // 5MB
                        ->required()
                        ->helperText('Puede cargar múltiples fotografías. Las imágenes se guardarán en una carpeta temporal.'),
                ])
                ->action(function (array $data): void {
                    Notification::make()
                        ->success()
                        ->title('Fotos adjuntadas exitosamente')
                        ->body(count($data['pictures']).' fotografías fueron guardadas en la carpeta temporal.')
                        ->send();
                }),


            Action::make('processPhotos')
                ->label('Procesar Fotos')
                ->icon(Heroicon::OutlinedCog)
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Procesar Fotos de Alumnos')
                ->modalDescription('Esto procesará todas las fotos en la carpeta temporal, buscará el alumno por matrícula (nombre del archivo) y subirá la foto a S3.')
                ->modalSubmitActionLabel('Procesar')
                ->action(function (): void {
                    // Get all photos in temp directory
                    $photos = Storage::disk('public')->files('temp/student-pictures');
                    //dd($photos);
                    if (empty($photos)) {
                        Notification::make()
                            ->warning()
                            ->title('No hay fotos para procesar')
                            ->body('No se encontraron fotos en la carpeta temporal.')
                            ->send();

                        return;
                    }

                    // Dispatch job
                    ProcessStudentPhotos::dispatch(
                        Auth::id(),
                        school_id(),
                        $photos
                    );

                    Notification::make()
                        ->info()
                        ->title('Procesamiento iniciado')
                        ->body('Se están procesando '.count($photos).' fotos. Recibirá una notificación cuando termine.')
                        ->send();
                })

        ]);

        return $table;

    }

}
