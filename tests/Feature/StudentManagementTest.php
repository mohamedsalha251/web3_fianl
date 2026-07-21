<?php

namespace Tests\Feature;

use App\Filament\Resources\Students\Pages\CreateStudent;
use App\Filament\Resources\Students\Pages\EditStudent;
use App\Models\Student;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class StudentManagementTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
        Filament::setCurrentPanel(Filament::getPanel('admin'));
    }

    public function test_filament_wizard_creates_a_valid_student(): void
    {
        Livewire::test(CreateStudent::class)
            ->fillForm([
                'name' => 'ليان خالد',
                'email' => 'layan@example.test',
                'phone' => '+970 598 555 555',
                'date_of_birth' => '2001-05-10',
                'gender' => 'female',
                'address' => 'رام الله',
                'status' => true,
                'notes' => 'تم إنشاؤها من اختبار Filament.',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('students', [
            'name' => 'ليان خالد',
            'email' => 'layan@example.test',
        ]);
    }

    public function test_filament_validates_required_student_fields(): void
    {
        Livewire::test(CreateStudent::class)
            ->fillForm([
                'name' => '',
                'email' => 'not-an-email',
                'gender' => null,
            ])
            ->call('create')
            ->assertHasFormErrors([
                'name' => 'required',
                'email' => 'email',
                'gender' => 'required',
            ]);
    }

    public function test_filament_can_edit_and_soft_delete_a_student(): void
    {
        $student = Student::create([
            'name' => 'اسم قديم',
            'email' => 'edit@example.test',
            'gender' => 'male',
        ]);

        Livewire::test(EditStudent::class, ['record' => $student->getRouteKey()])
            ->fillForm(['name' => 'اسم محدث'])
            ->call('save')
            ->assertHasNoFormErrors()
            ->callAction('delete');

        $this->assertSoftDeleted($student);
        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => 'اسم محدث',
        ]);
    }

    public function test_student_can_be_created_with_profile_fields(): void
    {
        $student = Student::create([
            'name' => 'أحمد محمود',
            'email' => 'ahmad@example.test',
            'phone' => '+970 599 123 456',
            'date_of_birth' => '2000-01-15',
            'gender' => 'male',
            'address' => 'القدس',
            'status' => true,
            'notes' => 'طالب تجريبي',
        ]);

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => 'أحمد محمود',
            'email' => 'ahmad@example.test',
            'status' => 1,
        ]);

        $this->assertTrue($student->status);
        $this->assertSame('2000-01-15', $student->date_of_birth->toDateString());
    }

    public function test_student_email_must_be_unique_in_database(): void
    {
        Student::create([
            'name' => 'الطالب الأول',
            'email' => 'unique@example.test',
            'gender' => 'male',
        ]);

        $this->expectException(UniqueConstraintViolationException::class);

        Student::create([
            'name' => 'الطالب الثاني',
            'email' => 'unique@example.test',
            'gender' => 'female',
        ]);
    }
}
