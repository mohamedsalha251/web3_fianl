<?php

namespace App\Filament\Resources\Enrollments\Pages;

use App\Filament\Resources\Enrollments\EnrollmentResource;
use App\Models\Course;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;

class EditEnrollment extends EditRecord
{
    protected static string $resource = EnrollmentResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (auth()->user()?->role === 'instructor') {
            $ownsCourse = Course::query()
                ->whereKey($data['course_id'] ?? null)
                ->where('instructor_id', auth()->user()->instructor?->id ?? 0)
                ->exists();

            if (! $ownsCourse) {
                throw ValidationException::withMessages([
                    'data.course_id' => 'يمكنك تعديل التسجيلات التابعة لدوراتك فقط.',
                ]);
            }
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
