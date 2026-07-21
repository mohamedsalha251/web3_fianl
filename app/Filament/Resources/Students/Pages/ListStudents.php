<?php

namespace App\Filament\Resources\Students\Pages;

use App\Filament\Exports\StudentExporter;
use App\Filament\Resources\Students\StudentResource;
use App\Models\Student;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use OpenSpout\Reader\XLSX\Reader;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('importExcel')->label('استيراد Excel')->schema([
                FileUpload::make('file')->label('ملف XLSX')->disk('local')->directory('imports')->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])->required(),
            ])->action(function (array $data): void {
                $reader = new Reader;
                $reader->open(Storage::disk('local')->path($data['file']));
                $success = 0;
                $failed = 0;
                $headers = [];
                foreach ($reader->getSheetIterator() as $sheet) {
                    foreach ($sheet->getRowIterator() as $index => $row) {
                        $values = $row->toArray();
                        if ($index === 1) {
                            $headers = array_map(fn ($value) => trim((string) $value), $values);

                            continue;
                        }
                        $record = array_combine($headers, array_pad($values, count($headers), null));
                        $validator = Validator::make($record, ['name' => ['required'], 'email' => ['required', 'email', 'unique:students,email'], 'gender' => ['required', 'in:male,female']]);
                        if ($validator->fails()) {
                            $failed++;

                            continue;
                        }
                        Student::create(collect($record)->only(['name', 'email', 'phone', 'date_of_birth', 'gender', 'address', 'status', 'notes'])->all());
                        $success++;
                    }
                    break;
                }
                $reader->close();
                Storage::disk('local')->delete($data['file']);
                Notification::make()->title('اكتمل استيراد Excel')->body("ناجح: {$success}، فاشل: {$failed}")->success()->send();
            }),
            Action::make('template')->label('ملف Excel نموذجي')->url(route('students.excel-template'))->openUrlInNewTab(),
            ExportAction::make()->exporter(StudentExporter::class)->formats([ExportFormat::Xlsx])->label('تصدير Excel'),
        ];
    }
}
