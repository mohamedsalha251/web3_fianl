<?php

namespace App\Filament\Widgets;

use App\Models\Enrollment;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestEnrollments extends TableWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Enrollment::query()->with(['student', 'course'])->latest()->limit(5))
            ->columns([
                TextColumn::make('student.name')->label('الطالب'), TextColumn::make('course.name')->label('الدورة'), TextColumn::make('status')->label('الحالة')->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ]);
    }
}
