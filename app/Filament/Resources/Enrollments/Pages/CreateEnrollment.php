<?php

namespace App\Filament\Resources\Enrollments\Pages;

use App\Filament\Resources\Enrollments\EnrollmentResource;
use App\Models\Course;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateEnrollment extends CreateRecord
{
    protected static string $resource = EnrollmentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (auth()->user()?->role === 'instructor') {
            $ownsCourse = Course::query()
                ->whereKey($data['course_id'] ?? null)
                ->where('instructor_id', auth()->user()->instructor?->id ?? 0)
                ->exists();

            if (! $ownsCourse) {
                throw ValidationException::withMessages([
                    'data.course_id' => 'يمكنك تسجيل الطلاب في دوراتك فقط.',
                ]);
            }
        }

        return $data;
    }
}
