<?php

namespace App\Filament\Resources\Enrollments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class EnrollmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('student_id')
                    ->relationship('student', 'name')
                    ->required()->searchable()->preload(),
                Select::make('course_id')
                    ->relationship(
                        'course',
                        'name',
                        modifyQueryUsing: fn (Builder $query) => $query->when(
                            auth()->user()?->role === 'instructor',
                            fn (Builder $query) => $query->where('instructor_id', auth()->user()->instructor?->id ?? 0),
                        ),
                    )
                    ->required()->searchable()->preload(),
                DatePicker::make('enrollment_date')
                    ->required()->default(now()),
                Select::make('status')->options(['active' => 'نشط', 'completed' => 'مكتمل', 'cancelled' => 'ملغي'])->required()->default('active'),
                TextInput::make('grade')
                    ->numeric()->minValue(0)->maxValue(100),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
