<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Student;

class StudentCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Sample Courses
        $webDev = Course::create([
            'name' => 'Web Programming III',
            'code' => 'CS303',
            'description' => 'Advanced server-side web application development using modern frameworks like Laravel.',
        ]);

        $database = Course::create([
            'name' => 'Database Management Systems',
            'code' => 'CS202',
            'description' => 'Relational database systems design, SQL programming, normalization, and optimization.',
        ]);

        $ai = Course::create([
            'name' => 'Artificial Intelligence',
            'code' => 'CS404',
            'description' => 'Introduction to machine learning, search algorithms, neural networks, and problem solving.',
        ]);

        $se = Course::create([
            'name' => 'Software Engineering',
            'code' => 'CS305',
            'description' => 'Software lifecycle, development methodologies, architectures, and design patterns.',
        ]);

        // 2. Create Sample Students and assign primary course (One-to-Many)
        $student1 = Student::create([
            'first_name' => 'Ahmed',
            'last_name' => 'Ali',
            'email' => 'ahmed.ali@example.com',
            'course_id' => $webDev->id, // Primary Major Course
        ]);

        $student2 = Student::create([
            'first_name' => 'Sara',
            'last_name' => 'Hassan',
            'email' => 'sara.hassan@example.com',
            'course_id' => $se->id,
        ]);

        $student3 = Student::create([
            'first_name' => 'Mohammed',
            'last_name' => 'Abu-Omar',
            'email' => 'mohammed.ao@example.com',
            'course_id' => $database->id,
        ]);

        $student4 = Student::create([
            'first_name' => 'Fatima',
            'last_name' => 'Mansour',
            'email' => 'fatima.m@example.com',
            'course_id' => $ai->id,
        ]);

        $student5 = Student::create([
            'first_name' => 'Khalid',
            'last_name' => 'Naim',
            'email' => 'khalid.naim@example.com',
            'course_id' => $webDev->id,
        ]);

        // 3. Populate many-to-many enrollments (pivot table course_student)
        // Student 1 (Ahmed Ali) enrolled in Web Dev, Databases, and Software Engineering
        $student1->courses()->sync([$webDev->id, $database->id, $se->id]);

        // Student 2 (Sara Hassan) enrolled in Software Engineering and Web Dev
        $student2->courses()->sync([$se->id, $webDev->id]);

        // Student 3 (Mohammed Abu-Omar) enrolled in Databases and AI
        $student3->courses()->sync([$database->id, $ai->id]);

        // Student 4 (Fatima Mansour) enrolled in AI, Software Engineering, and Databases
        $student4->courses()->sync([$ai->id, $se->id, $database->id]);

        // Student 5 (Khalid Naim) enrolled in Web Dev and AI
        $student5->courses()->sync([$webDev->id, $ai->id]);
    }
}
