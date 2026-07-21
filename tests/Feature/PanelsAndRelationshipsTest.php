<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Instructor;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PanelsAndRelationshipsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_dashboard_and_student_details(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $student = Student::create(['name' => 'طالب التفاصيل', 'email' => 'details@example.test', 'gender' => 'male']);

        $this->actingAs($admin)->get('/admin')->assertOk();
        $this->actingAs($admin)->get('/admin/students')->assertOk();
        $this->actingAs($admin)->get("/admin/students/{$student->id}")->assertOk()->assertSee('طالب التفاصيل');
        $this->actingAs($admin)->get('/student-import-template.xlsx')->assertOk()->assertHeader('content-disposition');
    }

    public function test_instructor_sees_only_their_courses_and_enrollments(): void
    {
        $user = User::factory()->create(['role' => 'instructor']);
        $instructor = Instructor::create(['user_id' => $user->id, 'name' => 'المدرب', 'email' => 'coach@example.test']);
        $other = Instructor::create(['name' => 'مدرب آخر', 'email' => 'other@example.test']);
        $ownCourse = Course::create(['instructor_id' => $instructor->id, 'name' => 'دورتي', 'code' => 'OWN']);
        Course::create(['instructor_id' => $other->id, 'name' => 'دورة أخرى', 'code' => 'OTHER']);
        $student = Student::create(['name' => 'طالب', 'email' => 'student@example.test', 'gender' => 'male']);
        Enrollment::create(['student_id' => $student->id, 'course_id' => $ownCourse->id, 'enrollment_date' => now()]);

        $this->actingAs($user)->get('/instructor')->assertOk();
        $this->actingAs($user)->get('/instructor/courses')->assertOk()->assertSee('دورتي')->assertDontSee('دورة أخرى');
        $this->actingAs($user)->get('/instructor/courses/create')->assertOk();
        $this->actingAs($user)->get("/instructor/courses/{$ownCourse->id}/edit")->assertOk();
        $this->actingAs($user)->get('/instructor/enrollments/create')->assertOk();
        $this->actingAs($user)->get('/admin')->assertForbidden();
    }

    public function test_admin_cannot_access_instructor_panel(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->get('/instructor')->assertForbidden();
    }
}
