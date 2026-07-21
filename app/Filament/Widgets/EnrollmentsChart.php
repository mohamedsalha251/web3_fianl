<?php

namespace App\Filament\Widgets;

use App\Models\Enrollment;
use Filament\Widgets\ChartWidget;

class EnrollmentsChart extends ChartWidget
{
    protected ?string $heading = 'التسجيلات حسب الشهر';

    protected function getData(): array
    {
        $months = collect(range(5, 0))->map(fn ($offset) => now()->subMonths($offset));

        return ['datasets' => [['label' => 'التسجيلات', 'data' => $months->map(fn ($month) => Enrollment::whereYear('enrollment_date', $month->year)->whereMonth('enrollment_date', $month->month)->count())->all(), 'borderColor' => '#f59e0b']], 'labels' => $months->map->format('Y-m')->all()];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
