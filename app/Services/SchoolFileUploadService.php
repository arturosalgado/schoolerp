<?php

namespace App\Services;

use App\Models\School;

class SchoolFileUploadService
{
    /**
     * Get the upload directory for student photos based on school
     * Format: schoolname/students/photos
     */
    public static function getStudentPhotoDirectory(): string
    {
        $school = self::getCurrentSchool();
        $schoolName = $school ? self::sanitizeSchoolName($school->name) : 'default';

        return "{$schoolName}/students/photos";
    }

    /**
     * Get the upload directory for teacher photos based on school
     * Format: schoolname/teachers/photos
     */
    public static function getTeacherPhotoDirectory(): string
    {
        $school = self::getCurrentSchool();
        $schoolName = $school ? self::sanitizeSchoolName($school->name) : 'default';

        return "{$schoolName}/teachers/photos";
    }

    /**
     * Get the upload directory for prospect photos based on school
     * Format: schoolname/prospects/photos
     */
    public static function getProspectPhotoDirectory(): string
    {
        $school = self::getCurrentSchool();
        $schoolName = $school ? self::sanitizeSchoolName($school->name) : 'default';

        return "{$schoolName}/prospects/photos";
    }

    /**
     * Get the upload directory for documents based on school
     * Format: schoolname/documents
     */
    public static function getDocumentDirectory(): string
    {
        $school = self::getCurrentSchool();
        $schoolName = $school ? self::sanitizeSchoolName($school->name) : 'default';

        return "{$schoolName}/documents";
    }

    /**
     * Get the upload directory for subject files based on school, subject name and code
     * Format: schoolname/subjects/subjectname_subjectcode
     */
    public static function getSubjectSyllabusDirectory(?string $subjectName = null, ?string $subjectCode = null): string
    {
        $school = self::getCurrentSchool();
        $schoolName = $school ? self::sanitizeSchoolName($school->name) : 'default';

        if ($subjectName && $subjectCode) {
            $sanitizedSubjectName = self::sanitizeSchoolName($subjectName);
            $sanitizedSubjectCode = self::sanitizeSchoolName($subjectCode);
            return "{$schoolName}/subjects/{$sanitizedSubjectName}_{$sanitizedSubjectCode}";
        }

        return "{$schoolName}/subjects/default";
    }

    /**
     * Get current school using the helper function
     */
    private static function getCurrentSchool(): ?School
    {
        $schoolId = school_id();
        return School::find($schoolId);
    }

    /**
     * Sanitize school name for use in file paths
     * Remove special characters and spaces, convert to lowercase
     */
    private static function sanitizeSchoolName(string $schoolName): string
    {
        // Remove accents and special characters
        $schoolName = iconv('UTF-8', 'ASCII//TRANSLIT', $schoolName);

        // Convert to lowercase and replace spaces with hyphens
        $schoolName = strtolower($schoolName);
        $schoolName = preg_replace('/[^a-z0-9\-_]/', '-', $schoolName);
        $schoolName = preg_replace('/-+/', '-', $schoolName);
        $schoolName = trim($schoolName, '-');

        return $schoolName ?: 'default';
    }
}
