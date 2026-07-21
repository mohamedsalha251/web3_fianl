<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'instructor_id', 'start_date', 'end_date', 'status',
    ];

    protected function casts(): array
    {
        return ['start_date' => 'date', 'end_date' => 'date'];
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get the primary students associated with the course (One-to-Many).
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Get the students enrolled in this course (Many-to-Many).
     */
    public function enrolledStudents(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'course_student');
    }

    public function trainingStudents(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'enrollments')->withPivot(['enrollment_date', 'status', 'grade', 'notes'])->withTimestamps();
    }
}
