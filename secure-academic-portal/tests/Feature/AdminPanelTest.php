<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('loginDestinations')]
    public function test_login_redirects_each_role_to_its_home(string $role, string $routeName): void
    {
        $user = User::factory()->withRole($role)->create();

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect(route($routeName, absolute: false));
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function loginDestinations(): array
    {
        return [
            'admin ke panel admin' => [User::ROLE_ADMIN, 'admin.dashboard'],
            'staf ke panel admin' => [User::ROLE_STAF, 'admin.dashboard'],
            'mahasiswa ke dashboard portofolio' => [User::ROLE_MAHASISWA, 'dashboard'],
        ];
    }

    public function test_dashboard_uses_adminlte_layout_and_counts_widgets_from_database(): void
    {
        $admin = User::factory()->admin()->create();
        User::factory()->staf()->create();
        $mahasiswas = User::factory()->count(3)->create();
        Project::factory()->for($mahasiswas[0])->create(['nilai' => null]);
        Project::factory()->for($mahasiswas[1])->create(['nilai' => 90]);

        $this->actingAs($admin)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('app-wrapper', false)
            ->assertSee('small-box', false)
            ->assertViewHas('stats', [
                'mahasiswa' => 3,
                'pengajar' => 2,
                'proposal' => 2,
                'belumDinilai' => 1,
            ]);
    }

    public function test_admin_sidebar_shows_role_management_menu(): void
    {
        $this->actingAs(User::factory()->admin()->create())->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Kelola Peran Pengguna');
    }

    public function test_staf_sidebar_hides_role_management_menu(): void
    {
        $this->actingAs(User::factory()->staf()->create())->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Data Mahasiswa')
            ->assertDontSee('Kelola Peran Pengguna');
    }

    #[DataProvider('dataTables')]
    public function test_hapus_data_button_is_rendered_only_for_admin(string $routeName): void
    {
        Project::factory()->create();

        $this->actingAs(User::factory()->admin()->create())->get(route($routeName))
            ->assertOk()
            ->assertSee('Hapus Data');

        $this->actingAs(User::factory()->staf()->create())->get(route($routeName))
            ->assertOk()
            ->assertDontSee('Hapus Data');
    }

    /**
     * @return array<string, array{string}>
     */
    public static function dataTables(): array
    {
        return [
            'tabel mahasiswa' => ['admin.mahasiswa.index'],
            'tabel proposal' => ['admin.proposals.index'],
        ];
    }

    public function test_staf_cannot_delete_data_with_a_direct_request(): void
    {
        $mahasiswa = User::factory()->create();
        $project = Project::factory()->for($mahasiswa)->create();
        $staf = User::factory()->staf()->create();

        $this->actingAs($staf)->delete(route('admin.proposals.destroy', $project))
            ->assertForbidden()
            ->assertSee('Aksi ini membutuhkan izin: hapus-data');
        $this->actingAs($staf)->delete(route('admin.mahasiswa.destroy', $mahasiswa))
            ->assertForbidden();

        $this->assertModelExists($project);
        $this->assertModelExists($mahasiswa);
    }

    public function test_admin_can_delete_proposal_and_mahasiswa(): void
    {
        $admin = User::factory()->admin()->create();
        $mahasiswa = User::factory()->has(Project::factory()->count(2))->create();
        $proposal = Project::factory()->create();

        $this->actingAs($admin)->delete(route('admin.proposals.destroy', $proposal))
            ->assertRedirect(route('admin.proposals.index'))
            ->assertSessionHas('status');
        $this->assertModelMissing($proposal);

        $this->actingAs($admin)->delete(route('admin.mahasiswa.destroy', $mahasiswa))
            ->assertRedirect(route('admin.mahasiswa.index'));
        $this->assertModelMissing($mahasiswa);
        $this->assertSame(0, Project::where('user_id', $mahasiswa->id)->count());
    }

    public function test_mahasiswa_delete_endpoint_cannot_remove_staf_or_admin(): void
    {
        $admin = User::factory()->admin()->create();
        $staf = User::factory()->staf()->create();

        $this->actingAs($admin)->delete(route('admin.mahasiswa.destroy', $staf))->assertNotFound();

        $this->assertModelExists($staf);
    }

    public function test_mahasiswa_search_matches_name_or_nrp_within_the_mahasiswa_role(): void
    {
        $admin = User::factory()->admin()->create(['name' => 'Budi Admin']);
        $budi = User::factory()->create(['name' => 'Budi Santoso', 'nrp' => '5025221001']);
        $siti = User::factory()->create(['name' => 'Siti Aminah', 'nrp' => '5026221002']);
        User::factory()->create(['name' => 'Joko Susilo', 'nrp' => '5027221003']);

        $this->actingAs($admin)->get(route('admin.mahasiswa.index', ['search' => 'Budi']))
            ->assertOk()
            ->assertViewHas('mahasiswas', fn (LengthAwarePaginator $page): bool => $page->pluck('id')->all() === [$budi->id]);

        $this->actingAs($admin)->get(route('admin.mahasiswa.index', ['search' => '5026']))
            ->assertViewHas('mahasiswas', fn (LengthAwarePaginator $page): bool => $page->pluck('id')->all() === [$siti->id]);
    }

    public function test_mahasiswa_department_filter_combines_with_search(): void
    {
        $admin = User::factory()->admin()->create();
        $budi = User::factory()->create(['name' => 'Budi Santoso', 'department' => 'Sistem Informasi']);
        User::factory()->create(['name' => 'Budi Hartono', 'department' => 'Teknik Elektro']);
        User::factory()->create(['name' => 'Siti Aminah', 'department' => 'Sistem Informasi']);

        $this->actingAs($admin)
            ->get(route('admin.mahasiswa.index', ['search' => 'Budi', 'department' => 'Sistem Informasi']))
            ->assertOk()
            ->assertViewHas('mahasiswas', fn (LengthAwarePaginator $page): bool => $page->pluck('id')->all() === [$budi->id]);
    }

    public function test_pagination_links_keep_active_filters(): void
    {
        $admin = User::factory()->admin()->create();
        User::factory()->count(12)->create(['department' => 'Sistem Informasi']);
        User::factory()->count(3)->create(['department' => 'Teknik Elektro']);

        $this->actingAs($admin)
            ->get(route('admin.mahasiswa.index', ['department' => 'Sistem Informasi']))
            ->assertOk()
            ->assertViewHas('mahasiswas', fn (LengthAwarePaginator $page): bool => $page->total() === 12
                && $page->count() === 10)
            ->assertSee('department=Sistem%20Informasi&amp;page=2', false);
    }

    public function test_proposals_can_be_filtered_by_keyword_tema_and_status(): void
    {
        $admin = User::factory()->admin()->create();
        $rina = User::factory()->create(['name' => 'Rina Kartika']);
        $target = Project::factory()->for($rina)->create(['tema_agent' => 'CrewAI', 'nilai' => null]);
        Project::factory()->for($rina)->create(['tema_agent' => 'CrewAI', 'nilai' => 88]);
        Project::factory()->for($rina)->create(['tema_agent' => 'Ollama', 'nilai' => null]);
        Project::factory()->create(['tema_agent' => 'CrewAI', 'nilai' => null]);

        $this->actingAs($admin)
            ->get(route('admin.proposals.index', ['search' => 'Rina', 'tema' => 'CrewAI', 'status' => 'belum']))
            ->assertOk()
            ->assertViewHas('projects', fn (LengthAwarePaginator $page): bool => $page->pluck('id')->all() === [$target->id]);
    }

    public function test_only_admin_can_change_user_roles(): void
    {
        $admin = User::factory()->admin()->create();
        $staf = User::factory()->staf()->create();
        $mahasiswa = User::factory()->create();

        $this->actingAs($staf)->get(route('admin.users.index'))->assertForbidden();
        $this->actingAs($staf)->put(route('admin.users.role.update', $mahasiswa), ['role' => User::ROLE_ADMIN])
            ->assertForbidden();
        $this->assertSame([User::ROLE_MAHASISWA], $mahasiswa->fresh()->getRoleNames()->all());

        $this->actingAs($admin)->put(route('admin.users.role.update', $mahasiswa), ['role' => User::ROLE_STAF])
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHasNoErrors();
        $this->assertSame([User::ROLE_STAF], $mahasiswa->fresh()->getRoleNames()->all());
    }

    public function test_admin_cannot_change_own_role(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->put(route('admin.users.role.update', $admin), ['role' => User::ROLE_MAHASISWA])
            ->assertSessionHasErrors('role');

        $this->assertTrue($admin->fresh()->hasRole(User::ROLE_ADMIN));
    }

    public function test_role_update_rejects_unknown_roles(): void
    {
        $admin = User::factory()->admin()->create();
        $mahasiswa = User::factory()->create();

        $this->actingAs($admin)->put(route('admin.users.role.update', $mahasiswa), ['role' => 'superadmin'])
            ->assertSessionHasErrors('role');

        $this->assertSame([User::ROLE_MAHASISWA], $mahasiswa->fresh()->getRoleNames()->all());
    }
}
