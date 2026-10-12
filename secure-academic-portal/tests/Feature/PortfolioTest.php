<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Project;
use App\Models\User;
use Database\Seeders\PortfolioSeeder;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_profile_displays_database_values(): void
    {
        config(['portfolio.public_email' => 'portfolio@student.its.ac.id']);
        User::factory()->create([
            'email' => 'portfolio@student.its.ac.id',
            'name' => 'Pemilik Portofolio',
            'nrp' => '5025241999',
            'department' => 'Departemen Contoh',
            'bio' => 'Profil dari database.',
        ]);

        $this->get('/')->assertOk()
            ->assertSee('Pemilik Portofolio')
            ->assertSee('5025241999')
            ->assertSee('Departemen Contoh')
            ->assertSee('Profil dari database.');
    }

    public function test_about_page_escapes_profile_content(): void
    {
        config(['portfolio.public_email' => 'portfolio@student.its.ac.id']);
        User::factory()->create([
            'email' => 'portfolio@student.its.ac.id',
            'bio' => '<script>alert("profile")</script>',
        ]);

        $this->get('/about')->assertOk()
            ->assertSee('<script>alert("profile")</script>')
            ->assertDontSee('<script>alert("profile")</script>', false);
    }

    public function test_public_projects_only_show_configured_portfolio_and_hide_secrets(): void
    {
        config(['portfolio.public_email' => 'portfolio@student.its.ac.id']);
        $owner = User::factory()->create(['email' => 'portfolio@student.its.ac.id']);
        Project::factory()->for($owner)->create([
            'judul' => 'Proposal Publik', 'api_key_secure' => 'sk-private-portfolio',
        ]);
        Project::factory()->create(['judul' => 'Proposal Pengguna Lain']);

        $this->get('/project-idea')->assertOk()
            ->assertSee('Proposal Publik')
            ->assertDontSee('Proposal Pengguna Lain')
            ->assertDontSee('sk-private-portfolio');
    }

    public function test_logged_in_public_pages_use_the_current_users_portfolio(): void
    {
        $user = User::factory()->create();
        Project::factory()->for($user)->create(['judul' => 'Proposal Saya']);
        $demo = User::factory()->create(['email' => config('portfolio.public_email')]);
        Project::factory()->for($demo)->create(['judul' => 'Proposal Demo']);

        $this->actingAs($user)->get('/project-idea')->assertOk()
            ->assertSee('Proposal Saya')->assertDontSee('Proposal Demo');
    }

    public function test_missing_public_portfolio_displays_empty_state(): void
    {
        $this->get('/project-idea')->assertOk()->assertSee('Belum ada proposal proyek.');
    }

    public function test_portfolio_fields_can_be_updated_without_changing_role(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->patch('/profile', [
            'name' => $user->name, 'email' => $user->email,
            'nrp' => '5025241999', 'department' => 'Teknik Informatika',
            'bio' => 'Profil yang diperbarui.', 'role' => 'dosen',
        ])->assertSessionHasNoErrors()->assertRedirect('/profile');

        $this->assertDatabaseHas('users', [
            'id' => $user->id, 'nrp' => '5025241999',
            'bio' => 'Profil yang diperbarui.', 'role' => 'mahasiswa',
        ]);
    }

    public function test_duplicate_nrp_is_rejected_without_modifying_profile(): void
    {
        User::factory()->create(['nrp' => '5025241999']);
        $user = User::factory()->create();

        $this->actingAs($user)->patch('/profile', [
            'name' => $user->name, 'email' => $user->email, 'nrp' => '5025241999',
        ])->assertSessionHasErrors('nrp');

        $this->assertNull($user->fresh()->nrp);
    }

    #[DataProvider('academicIdentifiers')]
    public function test_profile_form_shows_only_identifier_for_current_role(string $role, string $field, string $otherField): void
    {
        $user = User::factory()->create(['role' => $role]);

        $this->actingAs($user)->get('/profile')->assertOk()
            ->assertSee('for="'.$field.'"', false)
            ->assertSee('name="'.$field.'"', false)
            ->assertDontSee('name="'.$otherField.'"', false);
    }

    #[DataProvider('academicIdentifiers')]
    public function test_academic_identifier_is_saved_for_current_role(string $role, string $field, string $otherField): void
    {
        $user = User::factory()->create(['role' => $role]);

        $this->actingAs($user)->patch('/profile', [
            'name' => $user->name, 'email' => $user->email, $field => '198001012005011001',
        ])->assertSessionHasNoErrors()->assertRedirect('/profile');

        $this->assertDatabaseHas('users', [
            'id' => $user->id, $field => '198001012005011001', $otherField => null,
        ]);
    }

    #[DataProvider('academicIdentifiers')]
    public function test_identifier_for_another_role_cannot_be_submitted(string $role, string $field, string $otherField): void
    {
        $user = User::factory()->create(['role' => $role]);

        $this->actingAs($user)->patch('/profile', [
            'name' => $user->name, 'email' => $user->email, $otherField => '198001012005011001',
        ])->assertSessionHasErrors($otherField);

        $this->assertNull($user->fresh()->getAttribute($otherField));
    }

    #[DataProvider('identifierPages')]
    public function test_portfolio_pages_display_identifier_matching_role(string $role, string $field, string $path): void
    {
        $user = User::factory()->create(['role' => $role, $field => '198001012005011001']);

        $this->actingAs($user)->get($path)->assertOk()
            ->assertSee(strtoupper($field))
            ->assertDontSee($field === 'nip' ? 'NRP' : 'NIP')
            ->assertSee('198001012005011001');
    }

    public static function academicIdentifiers(): array
    {
        return [
            'dosen memakai NIP' => ['dosen', 'nip', 'nrp'],
            'mahasiswa memakai NRP' => ['mahasiswa', 'nrp', 'nip'],
            'asdos memakai NRP' => ['asdos', 'nrp', 'nip'],
        ];
    }

    public static function identifierPages(): array
    {
        return [
            'home dosen' => ['dosen', 'nip', '/'],
            'dashboard dosen' => ['dosen', 'nip', '/dashboard'],
            'home mahasiswa' => ['mahasiswa', 'nrp', '/'],
            'dashboard mahasiswa' => ['mahasiswa', 'nrp', '/dashboard'],
            'home asdos' => ['asdos', 'nrp', '/'],
            'dashboard asdos' => ['asdos', 'nrp', '/dashboard'],
        ];
    }

    public function test_duplicate_nip_is_rejected_without_modifying_profile(): void
    {
        User::factory()->dosen()->create(['nip' => '198001012005011001']);
        $user = User::factory()->dosen()->create();

        $this->actingAs($user)->patch('/profile', [
            'name' => $user->name, 'email' => $user->email, 'nip' => '198001012005011001',
        ])->assertSessionHasErrors('nip');

        $this->assertNull($user->fresh()->nip);
    }

    public function test_seeder_creates_required_demo_data_and_portfolio_seeding_is_repeatable(): void
    {
        $this->seed();

        $this->assertSame(18, User::count());
        $this->assertSame(34, Project::count());
        $this->assertSame(54, \App\Models\CourseTask::count());
        $students = User::where('role', 'mahasiswa')->where('email', '!=', 'mahasiswa@student.its.ac.id')->get();
        $this->assertCount(15, $students);
        foreach ($students as $student) {
            $this->assertSame(2, $student->projects()->count());
        }
        $this->assertSame(2, User::where('email', 'dosenpbkk@its.ac.id')->firstOrFail()->projects()->count());

        $demo = User::where('email', 'mahasiswa@student.its.ac.id')->firstOrFail();
        $demo->update(['bio' => 'Biodata pribadi yang harus dipertahankan.']);
        $this->seed(PortfolioSeeder::class);

        $this->assertSame(54, \App\Models\CourseTask::count());
        $this->assertSame('Biodata pribadi yang harus dipertahankan.', $demo->fresh()->bio);
    }
}
