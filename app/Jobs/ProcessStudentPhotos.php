<?php

namespace App\Jobs;

use App\Models\Student;
use Filament\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProcessStudentPhotos implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $userId;

    private int $schoolId;

    private array $photoPaths;

    /**
     * Create a new job instance.
     */
    public function __construct(int $userId, int $schoolId, array $photoPaths)
    {
        $this->userId = $userId;
        $this->schoolId = $schoolId;
        $this->photoPaths = $photoPaths;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $processedCount = 0;
        $failedCount = 0;
        $errors = [];

        try {
            foreach ($this->photoPaths as $photoPath) {
                // Extract filename from path
                $filename = basename($photoPath);

                //dd($filename);;
                // Get enrollment from filename (remove extension)
                $enrollment = pathinfo($filename, PATHINFO_FILENAME);
                //dump($enrollment);
                // Find student by enrollment and school
                $student = Student::where('enrollment', $enrollment)
                    ->where('school_id', $this->schoolId)
                    ->first();
                //dump($student);
                //dd();
                if (! $student) {
                    $errors[] = "No se encontró alumno con matrícula: {$enrollment}";
                    $failedCount++;

                    continue;
                }

                // Get the full path in storage
                $fullPath = storage_path('app/public/'.$photoPath);
                //dump($fullPath);
                if (! File::exists($fullPath)) {
                    $errors[] = "Archivo no encontrado: {$filename}";
                    $failedCount++;

                    continue;
                }

                // Upload to S3
                $s3Path = "students/{$this->schoolId}/{$student->id}/".Str::uuid().'_'.$filename;
               // dd($s3Path);
                // Read file contents and upload to S3
                $fileContents = File::get($fullPath);
                Storage::disk('s3')->put($s3Path, $fileContents, 'public');

                // Update student photo field
                $student->photo = $s3Path;
                $student->save();

                // Delete temporary file
                Storage::disk('public')->delete($photoPath);

                $processedCount++;
            }

            // Send success notification
            $message = "Procesamiento completado: {$processedCount} fotos procesadas exitosamente";
            if ($failedCount > 0) {
                $message .= ", {$failedCount} fallidas.<br><br>Errores:<br>".implode('<br>', $errors);
            }

            Notification::make()
                ->title('Procesamiento de Fotos Completado')
                ->body($message)
                ->success()
                ->persistent()
                ->sendToDatabase(\App\Models\User::find($this->userId));

        } catch (\Exception $e) {
            // Send error notification
            Notification::make()
                ->title('Error en Procesamiento de Fotos')
                ->body('Ocurrió un error: '.$e->getMessage())
                ->danger()
                ->persistent()
                ->sendToDatabase(\App\Models\User::find($this->userId));

            throw $e;
        }
    }
}
