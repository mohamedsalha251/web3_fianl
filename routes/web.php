<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Writer;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/student-import-template.xlsx', function () {
    abort_unless(auth()->check(), 403);
    $path = storage_path('app/student-import-template.xlsx');
    $writer = new Writer;
    $writer->openToFile($path);
    $writer->addRow(Row::fromValues(['name', 'email', 'phone', 'date_of_birth', 'gender', 'address', 'status', 'notes']));
    $writer->addRow(Row::fromValues(['أحمد محمد', 'student@example.com', '+970599000000', '2000-01-01', 'male', 'القدس', 1, 'طالب جديد']));
    $writer->close();

    return response()->download($path, 'student-import-template.xlsx')->deleteFileAfterSend();
})->name('students.excel-template');

Route::get('/about', [PageController::class, 'about']);
Route::get('/students', [StudentController::class, 'index']);

// Week 3 & 4 Routes: Relationships & Soft Deletes
Route::get('/students-relationships', [StudentController::class, 'relationships']);
Route::post('/students/{id}/delete', [StudentController::class, 'deleteStudent']);
Route::post('/students/{id}/restore', [StudentController::class, 'restoreStudent']);
Route::post('/courses/{id}/delete', [StudentController::class, 'deleteCourse']);
Route::post('/courses/{id}/restore', [StudentController::class, 'restoreCourse']);
