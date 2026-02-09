<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

/**
 * Teacher Model
 *
 * IMPORTANT ARCHITECTURAL DECISION: EMAIL DUPLICATION
 * ================================================
 *
 * This model stores teacher-specific information including a duplicated email field.
 * The email is stored in BOTH `teachers.email` AND `users.email` for the following reasons:
 *
 * 1. AUTHENTICATION: users.email is required for Laravel's authentication system
 * 2. PERFORMANCE: teachers.email allows direct queries without joins
 * 3. DATA INTEGRITY: Ensures teacher records are complete even if user relationship changes
 * 4. BUSINESS LOGIC: Teacher email might differ from login email in some cases
 *
 * SYNCHRONIZATION MECHANISM:
 * ========================
 * - When creating a Teacher via TeacherResource, a User is automatically created
 * - Both emails are set to the same value initially
 * - Updates to Teacher email are synchronized to User email via TeacherResource
 * - See: app/Filament/Resources/TeacherResource/Pages/CreateTeacher.php
 * - See: app/Filament/Resources/TeacherResource/Pages/EditTeacher.php
 *
 * MAINTENANCE GUIDELINES:
 * ======================
 * 1. NEVER update Teacher email without updating User email
 * 2. NEVER create Teacher without creating associated User
 * 3. TeacherResource handles synchronization - use it for CRUD operations
 * 4. If updating Teacher directly, ensure User.email is updated too
 *
 * DATABASE SCHEMA:
 * ===============
 * - teachers.email: NOT NULL (required field)
 * - teachers.mobile: NOT NULL (required field)
 * - teachers.user_id: Foreign key to users table
 * - teachers.schools: Many-to-many relationship via school_teacher pivot table
 *
 * @property string $email Duplicated email field (also in users.email)
 * @property string $mobile Teacher's mobile number
 * @property string $name Teacher's first name
 * @property string $last_name Teacher's paternal last name
 * @property string $second_last_name Teacher's maternal last name (nullable)
 * @property string $password Hashed password
 * @property int $user_id Foreign key to User model
 */
class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'last_name',
        'second_last_name',
        'email',
        'mobile',
        'password',
        'picture',
        'user_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Only run this when creating a new teacher
            $u = User::firstOrCreate([
                'email' => $model->email
            ],
                [
                    'name'=>$model->name,
                    'password' => Hash::make($model->password),
                    'email' => $model->email
                ]);
            $model->user_id = $u->id;
            
            // Get school_id from request or use current school context
            $schoolId = request()->input('school_id') ?? school_id();
            
            if ($schoolId) {
                $u->assignRole('Docente', $schoolId);
                $u->schools()->syncWithoutDetaching([$schoolId]);
            }
        });
        
        static::created(function ($model) {
            // Attach teacher to schools after creation
            $schoolId = request()->input('school_id') ?? school_id();
            
            if ($schoolId) {
                $model->schools()->syncWithoutDetaching([$schoolId]);
            }
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
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function schools(): BelongsToMany
    {
        return $this->belongsToMany(School::class, 'school_teacher');
    }




}
