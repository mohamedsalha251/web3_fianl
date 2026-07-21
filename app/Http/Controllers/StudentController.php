<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Support\Facades\Schema;

class StudentController extends Controller
{
    /**
     * Display a listing of students (Week 2 simple page).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $students = collect();
        $source = 'Hardcoded Fallback Array';

        try {
            if (Schema::hasTable('students')) {
                // Fetch only active records (Soft deletes are automatically excluded by Eloquent)
                $students = Student::all();
                if ($students->isNotEmpty()) {
                    $source = 'Database (Eloquent Model)';
                }
            }
        } catch (\Exception $e) {
            // Fallback to array if DB not migrated/ready
        }

        // If no records in database, use fallback data
        if ($students->isEmpty() && !request()->has('empty')) {
            $students = collect([
                (object) [
                    'id' => 1,
                    'first_name' => 'Ahmed',
                    'last_name' => 'Ali',
                    'email' => 'ahmed.ali@example.com',
                    'fullName' => 'Ahmed Ali' // Simulate accessor for fallback
                ],
                (object) [
                    'id' => 2,
                    'first_name' => 'Sara',
                    'last_name' => 'Hassan',
                    'email' => 'sara.hassan@example.com',
                    'fullName' => 'Sara Hassan'
                ],
                (object) [
                    'id' => 3,
                    'first_name' => 'Mohammed',
                    'last_name' => 'Abu-Omar',
                    'email' => 'mohammed.ao@example.com',
                    'fullName' => 'Mohammed Abu-Omar'
                ],
                (object) [
                    'id' => 4,
                    'first_name' => 'Fatima',
                    'last_name' => 'Mansour',
                    'email' => 'fatima.m@example.com',
                    'fullName' => 'Fatima Mansour'
                ]
            ]);
        }

        // Force empty collection if empty query parameter is present (for testing empty state requirement)
        if (request()->has('empty')) {
            $students = collect();
        }

        return view('students.index', compact('students', 'source'));
    }

    /**
     * Display relationships and soft deletes dashboard (Week 3 & 4).
     */
    public function relationships()
    {
        // Eager loading: load primaryCourse (One-to-Many) and courses (Many-to-Many) for active students
        $students = Student::with(['primaryCourse', 'courses'])->get();
        
        // Eager loading: load primary students for active courses
        $courses = Course::with('students')->get();

        // Load soft-deleted records for manual testing of restore
        $deletedStudents = Student::onlyTrashed()->get();
        $deletedCourses = Course::onlyTrashed()->get();

        return view('students.relationship', compact('students', 'courses', 'deletedStudents', 'deletedCourses'));
    }

    /**
     * Soft delete a student (Week 4).
     */
    public function deleteStudent($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->back()->with('success', "Student '{$student->fullName}' soft-deleted successfully.");
    }

    /**
     * Restore a soft deleted student (Week 4).
     */
    public function restoreStudent($id)
    {
        $student = Student::onlyTrashed()->findOrFail($id);
        $student->restore();

        return redirect()->back()->with('success', "Student '{$student->fullName}' restored successfully.");
    }

    /**
     * Soft delete a course (Week 4).
     */
    public function deleteCourse($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->back()->with('success', "Course '{$course->name}' soft-deleted successfully.");
    }

    /**
     * Restore a soft deleted course (Week 4).
     */
    public function restoreCourse($id)
    {
        $course = Course::onlyTrashed()->findOrFail($id);
        $course->restore();

        return redirect()->back()->with('success', "Course '{$course->name}' restored successfully.");
    }
}
