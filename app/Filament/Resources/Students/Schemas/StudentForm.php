<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('البيانات الشخصية')
                        ->icon('heroicon-o-user')
                        ->schema([
                            TextInput::make('name')
                                ->label('الاسم الكامل')
                                ->required()
                                ->minLength(3)
                                ->maxLength(255)
                                ->autofocus(),
                            DatePicker::make('date_of_birth')
                                ->label('تاريخ الميلاد')
                                ->native(false)
                                ->maxDate(now()->subYears(5))
                                ->displayFormat('Y-m-d'),
                            Select::make('gender')
                                ->label('الجنس')
                                ->options([
                                    'male' => 'ذكر',
                                    'female' => 'أنثى',
                                ])
                                ->required()
                                ->native(false),
                            FileUpload::make('photo')
                                ->label('الصورة')
                                ->image()
                                ->imageEditor()
                                ->disk('public')
                                ->directory('students')
                                ->maxSize(2048),
                        ])
                        ->columns(2),
                    Step::make('بيانات التواصل')
                        ->icon('heroicon-o-envelope')
                        ->schema([
                            TextInput::make('email')
                                ->label('البريد الإلكتروني')
                                ->email()
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(255),
                            TextInput::make('phone')
                                ->label('رقم الهاتف')
                                ->tel()
                                ->maxLength(30)
                                ->regex('/^[0-9+()\-\s]+$/'),
                            Textarea::make('address')
                                ->label('العنوان')
                                ->rows(3)
                                ->columnSpanFull(),
                        ])
                        ->columns(2),
                    Step::make('معلومات إضافية ومراجعة')
                        ->icon('heroicon-o-clipboard-document-check')
                        ->schema([
                            Toggle::make('status')
                                ->label('طالب نشط')
                                ->default(true)
                                ->inline(false),
                            Textarea::make('notes')
                                ->label('الملاحظات')
                                ->rows(4)
                                ->maxLength(2000)
                                ->columnSpanFull(),
                            Text::make('راجع البيانات في الخطوات السابقة قبل الضغط على إنشاء.')
                                ->columnSpanFull(),
                        ]),
                ])
                    ->columnSpanFull()
                    ->skippable(false),
            ]);
    }
}
