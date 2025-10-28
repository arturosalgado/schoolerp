<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IdCardConfig extends Model
{
    protected $fillable = [
        'school_id',
        'active',
        'front_path',
        'back_path',
        'photo_x',
        'photo_y',
        'photo_width',
        'photo_height',
        'name_x',
        'name_y',
        'enrollment_x',
        'enrollment_y',
        'career_x',
        'career_y',
        'back_top',
        'color',
        'font',
        'size',
        'showEnrollment',
        'showProgram',
        'name'
    ];

    protected $casts = [
        'active' => 'boolean',
        'showEnrollment' => 'boolean',
        'showProgram' => 'boolean',
        'photo_x' => 'integer',
        'photo_y' => 'integer',
        'photo_width' => 'integer',
        'photo_height' => 'integer',
        'name_x' => 'integer',
        'name_y' => 'integer',
        'enrollment_x' => 'integer',
        'enrollment_y' => 'integer',
        'career_x' => 'integer',
        'career_y' => 'integer',
        'back_top' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            static::activate($model);
        });
    }

    public static function activate($model)
    {
        // If the active field is being set to true, deactivate all other configs for this school
        if ($model->active && $model->isDirty('active')) {
            static::where('school_id',1)
                ->where('id', '!=', $model->id)
                ->update(['active' => false]);
        }
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
