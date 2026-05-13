<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int|null $student_id
 * @property int|null $school_id
 * @property string|null $level
 * @property string|null $log_name
 * @property string $description
 * @property string|null $subject_type
 * @property string|null $event
 * @property int|null $subject_id
 * @property string|null $causer_type
 * @property int|null $causer_id
 * @property \Illuminate\Support\Collection<array-key, mixed>|null $properties
 * @property string|null $batch_uuid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|null $causer
 * @property-read \Illuminate\Support\Collection $changes
 * @property-read \App\Models\School|null $school
 * @property-read \Illuminate\Database\Eloquent\Model|null $subject
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity causedBy(\Illuminate\Database\Eloquent\Model $causer)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity forBatch(string $batchUuid)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity forEvent(string $event)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity forSubject(\Illuminate\Database\Eloquent\Model $subject)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity hasBatch()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity inLog(...$logNames)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereBatchUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereCauserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereCauserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereLogName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereProperties($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereSubjectType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereUpdatedAt($value)
 */
	class Activity extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Student> $students
 * @property-read int|null $students_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BloodType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BloodType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BloodType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BloodType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BloodType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BloodType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BloodType whereUpdatedAt($value)
 */
	class BloodType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property bool $is_active
 * @property string|null $description
 * @property int $school_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\School $school
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Term> $terms
 * @property-read int|null $terms_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle withoutTrashed()
 */
	class Cycle extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property bool $active
 * @property int $school_id
 * @property bool $required
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\School $school
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Student> $students
 * @property-read int|null $students_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereUpdatedAt($value)
 */
	class Document extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $school_id
 * @property int $cycle_id
 * @property string|null $name
 * @property \Illuminate\Support\Carbon $opens_at
 * @property \Illuminate\Support\Carbon $closes_at
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Prospect> $convertedProspects
 * @property-read int|null $converted_prospects_count
 * @property-read \App\Models\Cycle|null $cycle
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Program> $programs
 * @property-read int|null $programs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Prospect> $prospects
 * @property-read int|null $prospects_count
 * @property-read \App\Models\School $school
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Term> $terms
 * @property-read int|null $terms_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentPeriod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentPeriod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentPeriod onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentPeriod query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentPeriod whereClosesAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentPeriod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentPeriod whereCycleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentPeriod whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentPeriod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentPeriod whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentPeriod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentPeriod whereOpensAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentPeriod whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentPeriod whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentPeriod withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnrollmentPeriod withoutTrashed()
 */
	class EnrollmentPeriod extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $school_id
 * @property string|null $name
 * @property string|null $front_path
 * @property string|null $back_path
 * @property int $photo_x
 * @property int $photo_y
 * @property int $photo_width
 * @property int $photo_height
 * @property int $name_x
 * @property int $name_y
 * @property int $enrollment_x
 * @property int $enrollment_y
 * @property int $career_x
 * @property int $career_y
 * @property int $back_top
 * @property string|null $color
 * @property string|null $font
 * @property string|null $size
 * @property bool $showEnrollment
 * @property bool $showProgram
 * @property bool $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\School|null $school
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig whereBackPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig whereBackTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig whereCareerX($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig whereCareerY($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig whereEnrollmentX($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig whereEnrollmentY($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig whereFont($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig whereFrontPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig whereNameX($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig whereNameY($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig wherePhotoHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig wherePhotoWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig wherePhotoX($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig wherePhotoY($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig whereShowEnrollment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig whereShowProgram($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdCardConfig whereUpdatedAt($value)
 */
	class IdCardConfig extends \Eloquent {}
}

namespace App\Models{
/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Panel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Panel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Panel query()
 */
	class Panel extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $resource
 * @property string $action
 * @property string|null $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\Panel|null $panel
 * @property string|null $resource_es
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission wherePanel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereResource($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereResourceEs($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property bool $active
 * @property int $school_id
 * @property int|null $program_level_id
 * @property string|null $plan_de_estudios_pdf
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProgramLevel|null $programLevel
 * @property-read \App\Models\School|null $school
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Student> $students
 * @property-read int|null $students_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Program newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Program newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Program query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Program whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Program whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Program whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Program whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Program wherePlanDeEstudiosPdf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Program whereProgramLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Program whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Program whereUpdatedAt($value)
 */
	class Program extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property bool $active
 * @property int $school_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Program> $programs
 * @property-read int|null $programs_count
 * @property-read \App\Models\School $school
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramLevel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramLevel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramLevel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramLevel whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramLevel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramLevel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramLevel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramLevel whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProgramLevel whereUpdatedAt($value)
 */
	class ProgramLevel extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $school_id
 * @property int|null $enrollment_period_id
 * @property string $name
 * @property string $last_name
 * @property string|null $second_last_name
 * @property string|null $email
 * @property string|null $mobile
 * @property \Illuminate\Support\Carbon|null $dob
 * @property string|null $sex
 * @property string|null $curp
 * @property int|null $state_id
 * @property int|null $program_id
 * @property string|null $photo
 * @property string|null $source
 * @property string $status
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\EnrollmentPeriod|null $enrollmentPeriod
 * @property-read \App\Models\Program|null $program
 * @property-read \App\Models\School $school
 * @property-read \App\Models\State|null $state
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect whereCurp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect whereEnrollmentPeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect whereSecondLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prospect withoutTrashed()
 */
	class Prospect extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $label_es
 * @property bool $system
 * @property string|null $description
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $school_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Panel> $panels
 * @property-read int|null $panels_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Models\School|null $school
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereLabelEs($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $slug
 * @property string|null $rfc
 * @property string|null $address
 * @property string|null $image
 * @property string|null $full_name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $website
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Student> $students
 * @property-read int|null $students_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Teacher> $teachers
 * @property-read int|null $teachers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereRfc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereWebsite($value)
 */
	class School extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Student> $students
 * @property-read int|null $students_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|State whereUpdatedAt($value)
 */
	class State extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $last_name
 * @property string|null $second_last_name
 * @property string|null $enrollment
 * @property string|null $photo
 * @property \Illuminate\Support\Carbon|null $dob
 * @property string|null $sex
 * @property string|null $curp
 * @property string|null $email
 * @property string|null $password
 * @property string|null $mobile
 * @property string|null $notes
 * @property int $user_id
 * @property int|null $state_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $full_name
 * @property string|null $extra_field_1
 * @property string|null $extra_field_2
 * @property string|null $extra_field_3
 * @property string|null $extra_field_4
 * @property string|null $extra_field_5
 * @property int|null $blood_type_id
 * @property string|null $emergency_phone
 * @property string|null $emergency_name
 * @property-read \App\Models\BloodType|null $bloodType
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Program> $programs
 * @property-read int|null $programs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\School> $schools
 * @property-read int|null $schools_count
 * @property-read \App\Models\State|null $state
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StudyPlan> $studyPlans
 * @property-read int|null $study_plans_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Terminal> $terminals
 * @property-read int|null $terminals_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereBloodTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereCurp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereEmergencyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereEmergencyPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereEnrollment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereExtraField1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereExtraField2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereExtraField3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereExtraField4($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereExtraField5($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereSecondLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student withoutTrashed()
 */
	class Student extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property bool $active
 * @property bool $is_system
 * @property int $school_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\School $school
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Student> $students
 * @property-read int|null $students_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentStatus systemOnly()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentStatus userEditable()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentStatus whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentStatus whereIsSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentStatus whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentStatus whereUpdatedAt($value)
 */
	class StudentStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property int $program_id
 * @property int $school_id
 * @property int $effective_year
 * @property int|null $total_credits
 * @property int|null $duration_periods
 * @property string|null $rvoe
 * @property int|null $duration_years
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Program $program
 * @property-read \App\Models\School $school
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyPlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyPlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyPlan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyPlan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyPlan whereDurationPeriods($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyPlan whereDurationYears($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyPlan whereEffectiveYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyPlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyPlan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyPlan whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyPlan whereRvoe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyPlan whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyPlan whereTotalCredits($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyPlan whereUpdatedAt($value)
 */
	class StudyPlan extends \Eloquent {}
}

namespace App\Models{
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
 * @property int $user_id Foreign key to User model
 * @property int $id
 * @property string|null $picture
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\School> $schools
 * @property-read int|null $schools_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher wherePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereSecondLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher withoutTrashed()
 */
	class Teacher extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property bool $is_active
 * @property string|null $description
 * @property int $order
 * @property int $cycle_id
 * @property int $school_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Cycle|null $cycle
 * @property-read \App\Models\School $school
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Term newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Term newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Term onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Term query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Term whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Term whereCycleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Term whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Term whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Term whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Term whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Term whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Term whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Term whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Term whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Term withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Term withoutTrashed()
 */
	class Term extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $school_id
 * @property string $name
 * @property bool $active
 * @property int $study_plan_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\School $school
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Student> $students
 * @property-read int|null $students_count
 * @property-read \App\Models\StudyPlan $studyPlan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Terminal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Terminal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Terminal query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Terminal whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Terminal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Terminal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Terminal whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Terminal whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Terminal whereStudyPlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Terminal whereUpdatedAt($value)
 */
	class Terminal extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $last_name
 * @property string|null $second_last_name
 * @property string|null $curp
 * @property string|null $rfc
 * @property string|null $dob
 * @property string|null $sex
 * @property string|null $mobile
 * @property string|null $photo
 * @property string|null $emergency_name
 * @property string|null $emergency_phone
 * @property int|null $blood_type_id
 * @property int|null $state_id
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property int $active
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\School> $schools
 * @property-read int|null $schools_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Student> $students
 * @property-read int|null $students_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBloodTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCurp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmergencyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmergencyPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRfc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSecondLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTrashed()
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser, \Filament\Models\Contracts\HasTenants {}
}

