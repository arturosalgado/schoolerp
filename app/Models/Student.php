<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'last_name',
        'second_last_name',
        'enrollment',
        'photo',
        'dob',
        'sex',
        'curp',
        'email',
        'password',
        'mobile',
        'notes',
        'student_status_id',
        'school_id',
        'user_id',
        'state_id',
        'extra_field_1',
        'extra_field_2',
        'extra_field_3',
        'extra_field_4',
        'extra_field_5',
        'blood_type_id',
        'emergency_phone',
        'emergency_name',
    ];

    protected $casts = [
        'dob' => 'date',
        'password' => 'hashed',
    ];

    protected $hidden = [
        'password',
    ];



    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Only run this when creating a new student

           // dd($model->email);

            $u = User::firstOrCreate([
                'email' => $model->email
            ],
                [
                    'name'=>$model->name,
                    'password' => Hash::make($model->password),
                    'email' => $model->email
                ]);
            $model->user_id = $u->id;

            //$u->assignRole('Alumno',$model->school_id);

            if ($model->school_id){
                $u->schools()->syncWithoutDetaching([$model->school_id]);
            }

            aLog($model->school_id,'Alumno creado',auth()->getUser(),$model,'student.created');

        });

        static::updating(function ($model) {
            // Handle user updates when student is being updated
            if ($model->user_id && ($model->isDirty('email') || $model->isDirty('name') || (!empty($model->password) && $model->isDirty('password')))) {
                $user = User::find($model->user_id);
                if ($user) {
                    $updateData = [];

                    // Update name if it changed
                    if ($model->isDirty('name')) {
                        $updateData['name'] = $model->name;
                    }

                    // Update email if it changed
                    if ($model->isDirty('email')) {
                        $updateData['email'] = $model->email;
                    }

                    // Only update password if it was provided (not empty) and changed
                    if (!empty($model->password) && $model->isDirty('password')) {
                        $updateData['password'] = Hash::make($model->password);
                    }

                    if (!empty($updateData)) {
                        $user->update($updateData);
                    }
                }
            }
        });
    }



    /**
     * Get the school that owns the student.
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get the user that owns the student.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the state that owns the student.
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Get the student status that owns the student.
     */
    public function studentStatus(): BelongsTo
    {
        return $this->belongsTo(StudentStatus::class);
    }

    /**
     * Get the blood type that owns the student.
     */
    public function bloodType(): BelongsTo
    {
        return $this->belongsTo(BloodType::class);
    }


    public function getImageUrl()
    {
        if ($this->photo==null)
            return null;
        $imageUrl = Storage::disk('s3')->url($this->photo);
        return $imageUrl;

    }

    /**
     * Get the programs the student is enrolled in.
     */
    public function programs(): BelongsToMany
    {
        return $this->belongsToMany(Program::class, 'program_student')
                    ->withPivot('is_current', 'enrolled_at', 'completed_at')
                    ->withTimestamps();
    }

    /**
     * Get the current program the student is enrolled in.
     */
    public function latestProgram()
    {
        return $this->programs()
                    ->wherePivot('is_current', true)
                    ->orderBy('program_student.enrolled_at', 'desc')
                    ->first();
    }

    public function studyPlans(): BelongsToMany
    {
        return $this->belongsToMany(StudyPlan::class)
            ->withPivot(['program_id', 'is_active', 'assigned_at', 'completed_at', 'progress_percentage', 'completed_subjects'])
            ->withTimestamps();
    }

    public function terminals(): BelongsToMany
    {
        return $this->belongsToMany(Terminal::class)
            ->withPivot(['study_plan_id'])
            ->withTimestamps();
    }

}
