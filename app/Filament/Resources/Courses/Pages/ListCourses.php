<?php

namespace App\Filament\Resources\Courses\Pages;

use App\Filament\Exports\CourseExporter;
use App\Filament\Resources\Courses\CourseResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Resources\Pages\ListRecords;

class ListCourses extends ListRecords
{
    protected static string $resource = CourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            ExportAction::make()->exporter(CourseExporter::class)->formats([ExportFormat::Xlsx])->label('تصدير Excel'),
        ];
    }
}
