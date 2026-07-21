<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('instructor_id')
                    ->relationship('instructor', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->default(fn () => auth()->user()?->instructor?->id)
                    ->disabled(fn () => auth()->user()?->role === 'instructor')
                    ->dehydrated(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('code')
                    ->required()->unique(ignoreRecord: true),
                Textarea::make('description')
                    ->columnSpanFull(),
                DatePicker::make('start_date'),
                DatePicker::make('end_date')->afterOrEqual('start_date'),
                Select::make('status')->options(['draft' => 'مسودة', 'ongoing' => 'جارية', 'completed' => 'مكتملة', 'cancelled' => 'ملغاة'])->required()->default('draft'),
            ]);
    }
}
