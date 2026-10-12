<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurePortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_are_accessible_to_guests(): void
    {
        $this->get('/')->assertOk()->assertSee('Secure Academic Portal');
        $this->get('/about')->assertOk();
        $this->get('/project-idea')->assertOk();
    }

    public function test_new_registered_user_gets_mahasiswa_role(): void
    {
        $this->post('/register', [
            'name' => 'Budi',
            'email' => 'budi@student.its.ac.id',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'dosen',
        ])->assertRedirect(route('dashboard'));

        $this->assertSame('mahasiswa', User::where('email', 'budi@student.its.ac.id')->value('role'));
    }

    public function test_guest_is_redirected_from_dashboard_and_admin(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/admin')->assertRedirect('/login');
    }

    public function test_mahasiswa_is_forbidden_from_admin_area(): void
    {
        $mahasiswa = User::factory()->create();

        $this->actingAs($mahasiswa)->get('/admin')
            ->assertForbidden()
            ->assertSee('Izin akses ditolak');
    }

    public function test_dosen_and_asdos_can_open_admin_area(): void
    {
        $this->actingAs(User::factory()->dosen()->create())->get('/admin')->assertOk();
        $this->actingAs(User::factory()->asdos()->create())->get('/admin')->assertOk();
    }

    public function test_dashboard_only_lists_own_projects(): void
    {
        $saya = User::factory()->create();
        Project::factory()->for($saya)->create(['judul' => 'Proyek Milik Saya']);
        Project::factory()->create(['judul' => 'Proyek Orang Lain']);

        $this->actingAs($saya)->get('/dashboard')
            ->assertOk()
            ->assertSee('Proyek Milik Saya')
            ->assertDontSee('Proyek Orang Lain');
    }

    public function test_input_nilai_link_is_hidden_for_mahasiswa(): void
    {
        $this->actingAs(User::factory()->create())->get('/dashboard')
            ->assertDontSee('Input Nilai');

        $this->actingAs(User::factory()->dosen()->create())->get('/dashboard')
            ->assertSee('Input Nilai');
    }

    public function test_store_project_ignores_mass_assigned_fields_and_applies_default_theme(): void
    {
        $mahasiswa = User::factory()->create();
        $lain = User::factory()->create();

        $this->actingAs($mahasiswa)->post('/projects', [
            'judul' => 'Agent Penjadwal',
            'user_id' => $lain->id,
            'nilai' => 100,
        ])->assertRedirect(route('dashboard'));

        $project = Project::firstOrFail();
        $this->assertSame($mahasiswa->id, $project->user_id);
        $this->assertNull($project->nilai);
        $this->assertSame('Ollama', $project->tema_agent);
    }

    public function test_only_owner_can_edit_project_title(): void
    {
        $pemilik = User::factory()->create();
        $project = Project::factory()->for($pemilik)->create();

        $this->actingAs(User::factory()->create())
            ->put(route('projects.update', $project), ['judul' => 'Dibajak'])
            ->assertForbidden();

        $this->actingAs(User::factory()->dosen()->create())
            ->get(route('projects.edit', $project))
            ->assertForbidden();

        $this->actingAs($pemilik)
            ->put(route('projects.update', $project), ['judul' => 'Judul Baru'])
            ->assertRedirect(route('dashboard'));

        $this->assertSame('Judul Baru', $project->fresh()->judul);
    }

    public function test_only_dosen_or_asdos_can_input_nilai(): void
    {
        $project = Project::factory()->create();

        $this->actingAs(User::factory()->create())
            ->put(route('admin.nilai.update', $project), ['nilai' => 90])
            ->assertForbidden();

        $this->actingAs(User::factory()->asdos()->create())
            ->put(route('admin.nilai.update', $project), ['nilai' => 87.5, 'catatan_review' => 'Bagus'])
            ->assertRedirect(route('admin.index'));

        $this->assertEquals(87.5, $project->fresh()->nilai);
    }

    public function test_proposal_submission_is_limited_to_three_per_minute(): void
    {
        $mahasiswa = User::factory()->create();

        for ($i = 1; $i <= 3; $i++) {
            $this->actingAs($mahasiswa)->post('/projects', ['judul' => "Proposal {$i}"])
                ->assertSessionHasNoErrors();
        }

        $this->actingAs($mahasiswa)->post('/projects', ['judul' => 'Proposal 4'])
            ->assertSessionHasErrors('judul');

        $this->assertSame(3, $mahasiswa->projects()->count());
    }

    public function test_deleting_user_cascades_projects(): void
    {
        $user = User::factory()->has(Project::factory()->count(2))->create();

        $user->delete();

        $this->assertSame(0, Project::count());
    }

    public function test_api_key_is_encrypted_at_rest(): void
    {
        $project = Project::factory()->create(['api_key_secure' => 'sk-rahasia']);

        $raw = \DB::table('projects')->where('id', $project->id)->value('api_key_secure');

        $this->assertNotSame('sk-rahasia', $raw);
        $this->assertSame('sk-rahasia', $project->fresh()->api_key_secure);
    }
}
