<?php

namespace App\Models;

use Database\Factories\EnrollmentFactory;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
    /** @use HasFactory<EnrollmentFactory> */
    use HasFactory;

    protected static function booted(): void
    {
        static::created(fn (Enrollment $enrollment) => Notification::make()->title('تسجيل طالب في دورة')->body($enrollment->student?->name.' - '.$enrollment->course?->name)->success()->sendToDatabase(User::where('role', 'admin')->get()));
        static::updated(function (Enrollment $enrollment): void {
            if ($enrollment->wasChanged('grade')) {
                Notification::make()->title('تم تعديل درجة طالب')->body($enrollment->student?->name.' : '.$enrollment->grade)->success()->sendToDatabase(User::where('role', 'admin')->get());
            }
        });
    }

    protected $fillable = ['student_id', 'course_id', 'enrollment_date', 'status', 'grade', 'notes'];

    protected function casts(): array
    {
        return ['enrollment_date' => 'date', 'grade' => 'decimal:2'];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
