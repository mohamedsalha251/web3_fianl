<?php

use App\Models\Course;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function (): void {
    Course::whereDate('start_date', now()->addDays(3))->each(function (Course $course): void {
        Notification::make()->title('دورة ستبدأ قريبًا')->body($course->name.' تبدأ في '.$course->start_date->format('Y-m-d'))->warning()->sendToDatabase(User::where('role', 'admin')->get());
    });
})->dailyAt('08:00')->name('notify-upcoming-courses')->withoutOverlapping();
