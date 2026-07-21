<?php

namespace App\Filament\Resources\Enrollments\Pages;

use App\Filament\Exports\EnrollmentExporter;
use App\Filament\Resources\Enrollments\EnrollmentResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Resources\Pages\ListRecords;

class ListEnrollments extends ListRecords
{
    protected static string $resource = EnrollmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            ExportAction::make()->exporter(EnrollmentExporter::class)->formats([ExportFormat::Xlsx])->label('تصدير Excel'),
        ];
    }
}
