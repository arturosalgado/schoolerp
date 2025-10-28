<?php

namespace App\Http\Controllers;

use App\Models\IdCardConfig;
use App\Models\Student;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class CredentialsController extends Controller
{
    public function show(School $school, Student $student)
    {
        // Verify student belongs to the school
        if ($student->school_id !== $school->id) {
            abort(403, 'El estudiante no pertenece a esta escuela');
        }

        // Get the ID card configuration for this school
        $idCardConfig = IdCardConfig::where('school_id', $school->id)->where('active',1)->first();

        if (!$idCardConfig) {
            abort(404, 'No se encontró configuración de credencial para esta escuela');
        }

        // Get signed URLs for the images from S3
        $frontImageUrl = $idCardConfig->front_path ?
            Storage::disk('s3')->temporaryUrl($idCardConfig->front_path, now()->addMinutes(60)) :
            null;

        $backImageUrl = $idCardConfig->back_path ?
            Storage::disk('s3')->temporaryUrl($idCardConfig->back_path, now()->addMinutes(60)) :
            null;

        $studentPhotoUrl = $student->photo ?
            Storage::disk('s3')->temporaryUrl($student->photo, now()->addMinutes(60)) :
            null;

        return view('credentials.show', compact(
            'school',
            'student',
            'idCardConfig',
            'frontImageUrl',
            'backImageUrl',
            'studentPhotoUrl'
        ));
    }

    public function updatePhotoPosition(Request $request, School $school): JsonResponse
    {
        $request->validate([
            'x' => 'required|numeric|min:0',
            'y' => 'required|numeric|min:0',
        ]);

        // Get the ID card configuration for this school
        $idCardConfig = IdCardConfig::where('school_id', $school->id)->first();

        if (!$idCardConfig) {
            return response()->json(['error' => 'No se encontró configuración de credencial para esta escuela'], 404);
        }

        // Update the photo position
        $idCardConfig->update([
            'photo_x' => $request->input('x'),
            'photo_y' => $request->input('y'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Posición de foto actualizada correctamente',
            'x' => $idCardConfig->photo_x,
            'y' => $idCardConfig->photo_y,
        ]);
    }

    public function updateTextPosition(Request $request, School $school): JsonResponse
    {
        $request->validate([
            'type' => 'required|in:name,enrollment,career',
            'x' => 'required|numeric|min:0',
            'y' => 'required|numeric|min:0',
        ]);

        // Get the ID card configuration for this school
        $idCardConfig = IdCardConfig::where('school_id', $school->id)->first();

        if (!$idCardConfig) {
            return response()->json(['error' => 'No se encontró configuración de credencial para esta escuela'], 404);
        }

        $type = $request->input('type');

        // Update the text position based on type
        $idCardConfig->update([
            $type . '_x' => $request->input('x'),
            $type . '_y' => $request->input('y'),
        ]);

        return response()->json([
            'success' => true,
            'message' => "Posición de {$type} actualizada correctamente",
            'x' => $idCardConfig->{$type . '_x'},
            'y' => $idCardConfig->{$type . '_y'},
        ]);
    }

    public function updateBackPosition(Request $request, School $school): JsonResponse
    {
        $request->validate([
            'top' => 'required|numeric|min:0',
        ]);

        // Get the ID card configuration for this school
        $idCardConfig = IdCardConfig::where('school_id', $school->id)->first();

        if (!$idCardConfig) {
            return response()->json(['error' => 'No se encontró configuración de credencial para esta escuela'], 404);
        }

        // Update the back position
        $idCardConfig->update([
            'back_top' => $request->input('top'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Posición del reverso actualizada correctamente',
            'top' => $idCardConfig->back_top,
        ]);
    }

    public function resetAllPositions(Request $request, School $school): JsonResponse
    {
        // Get the ID card configuration for this school
        $idCardConfig = IdCardConfig::where('school_id', $school->id)->first();

        if (!$idCardConfig) {
            return response()->json(['error' => 'No se encontró configuración de credencial para esta escuela'], 404);
        }

        // Reset all positions to default values
        $idCardConfig->update([
            'photo_x' => 0,
            'photo_y' => 0,
            'name_x' => 50,
            'name_y' => 100,
            'enrollment_x' => 50,
            'enrollment_y' => 130,
            'career_x' => 50,
            'career_y' => 160,
            'back_top' => 300,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Todas las posiciones han sido reseteadas',
            'positions' => [
                'photo' => ['x' => 0, 'y' => 0],
                'name' => ['x' => 50, 'y' => 100],
                'enrollment' => ['x' => 50, 'y' => 130],
                'career' => ['x' => 50, 'y' => 160],
                'back_top' => 300,
            ],
        ]);
    }
}
