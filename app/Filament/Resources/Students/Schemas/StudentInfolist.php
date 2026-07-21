<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StudentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('البيانات الشخصية')->schema([
                ImageEntry::make('photo')->label('الصورة')->disk('public')->circular(),
                TextEntry::make('name')->label('الاسم'),
                TextEntry::make('date_of_birth')->label('تاريخ الميلاد')->date('Y-m-d'),
                TextEntry::make('gender')->label('الجنس')->formatStateUsing(fn (?string $state) => $state === 'male' ? 'ذكر' : 'أنثى'),
                TextEntry::make('status')->label('الحالة')->badge()->formatStateUsing(fn (bool $state) => $state ? 'نشط' : 'غير نشط')->color(fn (bool $state) => $state ? 'success' : 'danger'),
            ])->columns(3),
            Section::make('التواصل')->schema([
                TextEntry::make('email')->label('البريد'), TextEntry::make('phone')->label('الهاتف'), TextEntry::make('address')->label('العنوان'),
            ])->columns(2),
            Section::make('معلومات إضافية')->schema([
                TextEntry::make('notes')->label('الملاحظات')->columnSpanFull(), TextEntry::make('created_at')->label('تاريخ الإنشاء')->dateTime('Y-m-d H:i'),
            ]),
        ]);
    }
}
