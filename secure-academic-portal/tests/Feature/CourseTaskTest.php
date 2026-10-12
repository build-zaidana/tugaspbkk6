<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\CourseTask;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CourseTaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_add_tasks(): void
    {
        $this->post('/course-tasks', [])->assertRedirect('/login');

        $this->assertDatabaseCount('course_tasks', 0);
    }

    public function test_task_is_saved_for_logged_in_user_and_ignores_injected_owner(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        $this->actingAs($user)->post('/course-tasks', [
            'judul' => 'Tugas Basis Data', 'mata_kuliah' => 'PBKK',
            'deskripsi' => 'Membuat migration.', 'tanggal_pengumpulan' => '2026-10-12',
            'user_id' => $other->id,
        ])->assertSessionHasNoErrors()->assertRedirect('/dashboard');

        $this->assertDatabaseHas('course_tasks', [
            'user_id' => $user->id, 'judul' => 'Tugas Basis Data',
            'mata_kuliah' => 'PBKK', 'deskripsi' => 'Membuat migration.',
        ]);
        $this->assertSame('2026-10-12', CourseTask::firstOrFail()->tanggal_pengumpulan->format('Y-m-d'));
        $this->assertSame(0, $other->courseTasks()->count());
    }

    public function test_required_task_fields_show_validation_errors_and_save_nothing(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/course-tasks', [])->assertSessionHasErrors([
            'judul' => 'Judul tugas wajib diisi.',
            'mata_kuliah' => 'Mata kuliah wajib diisi.',
            'tanggal_pengumpulan' => 'Tanggal pengumpulan wajib diisi.',
        ]);

        $this->assertDatabaseCount('course_tasks', 0);
    }

    public function test_invalid_calendar_date_is_rejected(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/course-tasks', [
            'judul' => 'Tugas', 'mata_kuliah' => 'PBKK', 'tanggal_pengumpulan' => '2026-02-30',
        ])->assertSessionHasErrors([
            'tanggal_pengumpulan' => 'Tanggal pengumpulan harus berupa tanggal yang valid.',
        ]);

        $this->assertDatabaseCount('course_tasks', 0);
    }

    public function test_dashboard_only_shows_own_tasks_in_latest_date_order_and_escapes_content(): void
    {
        $user = User::factory()->create();
        CourseTask::factory()->for($user)->create(['judul' => 'Tugas Lama', 'tanggal_pengumpulan' => '2026-10-01']);
        CourseTask::factory()->for($user)->create([
            'judul' => 'Tugas Baru', 'tanggal_pengumpulan' => '2026-10-12',
            'deskripsi' => '<script>alert("task")</script>',
        ]);
        CourseTask::factory()->create(['judul' => 'Tugas Orang Lain']);

        $this->actingAs($user)->get('/dashboard')->assertOk()
            ->assertSeeInOrder(['Tugas Baru', 'Tugas Lama'])
            ->assertDontSee('Tugas Orang Lain')
            ->assertSee('<script>alert("task")</script>')
            ->assertDontSee('<script>alert("task")</script>', false);
    }

    public function test_only_owner_can_delete_a_task_through_the_endpoint(): void
    {
        $task = CourseTask::factory()->create();

        $this->actingAs(User::factory()->create())->delete(route('course-tasks.destroy', $task))->assertForbidden();

        $this->assertModelExists($task);
    }

    public function test_owner_can_delete_a_task(): void
    {
        $task = CourseTask::factory()->create();

        $this->actingAs($task->user)->delete(route('course-tasks.destroy', $task))->assertRedirect('/dashboard');

        $this->assertModelMissing($task);
    }

    #[DataProvider('roles')]
    public function test_delete_policy_checks_ownership_for_every_role(string $role): void
    {
        $owner = User::factory()->create(['role' => $role]);
        $other = User::factory()->create(['role' => $role]);
        $task = CourseTask::factory()->for($owner)->create();

        $this->assertTrue(Gate::forUser($owner)->allows('delete', $task));
        $this->assertFalse(Gate::forUser($other)->allows('delete', $task));
    }

    public static function roles(): array
    {
        return ['mahasiswa' => ['mahasiswa'], 'asdos' => ['asdos'], 'dosen' => ['dosen']];
    }

    public function test_deleting_user_removes_their_task_history(): void
    {
        $user = User::factory()->has(CourseTask::factory()->count(2))->create();

        $user->delete();

        $this->assertDatabaseCount('course_tasks', 0);
    }
}
