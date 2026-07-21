<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use Filament\Widgets\ChartWidget;

class StudentsStatusChart extends ChartWidget
{
    protected ?string $heading = 'الطلاب حسب الحالة';

    protected function getData(): array
    {
        return ['datasets' => [['label' => 'الطلاب', 'data' => [Student::where('status', true)->count(), Student::where('status', false)->count()], 'backgroundColor' => ['#10b981', '#ef4444']]], 'labels' => ['نشط', 'غير نشط']];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
