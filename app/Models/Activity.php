<?php

namespace App\Models;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Activity as SpatieActivity;

class Activity extends SpatieActivity
{
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get the human-readable label for a subject type.
     */
    public static function getSubjectTypeLabel(?string $subjectType): string
    {
        if (!$subjectType) {
            return '-';
        }

        return config("model_labels.{$subjectType}") ?? class_basename($subjectType);
    }

    /**
     * Get the human-readable label for a causer type.
     */
    public static function getCauserTypeLabel(?string $causerType): string
    {
        return self::getSubjectTypeLabel($causerType);
    }
}
