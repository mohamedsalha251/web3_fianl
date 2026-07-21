<?php

namespace App\Models;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected static function booted(): void
    {
        static::created(fn (Student $student) => Notification::make()->title('تمت إضافة طالب جديد')->body($student->name)->success()->sendToDatabase(User::where('role', 'admin')->get()));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'address',
        'photo',
        'status',
        'notes',
        'course_id',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'status' => 'boolean',
        ];
    }

    /**
     * Accessor for full name (Week 3 task requirement).
     * Usage in Blade: $student->fullName
     */
    public function getFullNameAttribute(): string
    {
        return $this->name ?: trim($this->first_name.' '.$this->last_name);
    }

    /**
     * Get the primary course the student belongs to (One-to-Many).
     */
    public function primaryCourse(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * Get the courses the student is enrolled in (Many-to-Many).
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'enrollments')->withPivot(['enrollment_date', 'status', 'grade', 'notes'])->withTimestamps();
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }
}
