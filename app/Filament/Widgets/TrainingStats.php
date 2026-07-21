<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Instructor;
use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TrainingStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('الطلاب', Student::count())->icon('heroicon-o-academic-cap'),
            Stat::make('الطلاب النشطون', Student::where('status', true)->count())->color('success'),
            Stat::make('الدورات', Course::count()),
            Stat::make('الدورات الجارية', Course::where('status', 'ongoing')->count())->color('warning'),
            Stat::make('المدربون', Instructor::count()),
            Stat::make('التسجيلات', Enrollment::count()),
            Stat::make('التسجيلات المكتملة', Enrollment::where('status', 'completed')->count())->color('success'),
        ];
    }
}
