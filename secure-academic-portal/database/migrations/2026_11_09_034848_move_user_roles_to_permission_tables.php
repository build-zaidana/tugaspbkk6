<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\PermissionRegistrar;

return new class () extends Migration {
    /**
     * Peta jabatan lama pada kolom users.role (Tugas P5) ke peran Spatie (Tugas P10).
     *
     * @var array<string, string>
     */
    private const ROLE_MAP = [
        'dosen' => 'admin',
        'asdos' => 'staf',
        'mahasiswa' => 'mahasiswa',
    ];

    private const GUARD = 'web';

    /**
     * Pindahkan peran pengguna ke tabel otorisasi Spatie, lalu hapus kolom role
     * agar hak akses hanya punya satu sumber kebenaran.
     */
    public function up(): void
    {
        $roleIds = $this->ensureRolesExist();

        if (Schema::hasColumn('users', 'role')) {
            $tables = config('permission.table_names');
            $rolePivotKey = config('permission.column_names.role_pivot_key') ?? 'role_id';
            $morphKey = config('permission.column_names.model_morph_key');
            $morphClass = (new User())->getMorphClass();

            DB::table('users')->select(['id', 'role'])->orderBy('id')
                ->chunkById(500, function ($users) use ($tables, $rolePivotKey, $morphKey, $morphClass, $roleIds): void {
                    $rows = $users->map(fn (object $user): array => [
                        $rolePivotKey => $roleIds[self::ROLE_MAP[$user->role] ?? 'mahasiswa'],
                        'model_type' => $morphClass,
                        $morphKey => $user->id,
                    ])->all();

                    DB::table($tables['model_has_roles'])->insertOrIgnore($rows);
                });

            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    /**
     * Kembalikan kolom role dan isi ulang nilainya dari tabel Spatie.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', array_keys(self::ROLE_MAP))
                ->default('mahasiswa')
                ->after('email');
        });

        $tables = config('permission.table_names');
        $rolePivotKey = config('permission.column_names.role_pivot_key') ?? 'role_id';
        $morphKey = config('permission.column_names.model_morph_key');
        $morphClass = (new User())->getMorphClass();

        foreach (self::ROLE_MAP as $legacyRole => $spatieRole) {
            $roleId = DB::table($tables['roles'])
                ->where(['name' => $spatieRole, 'guard_name' => self::GUARD])
                ->value('id');

            if ($roleId === null) {
                continue;
            }

            $userIds = DB::table($tables['model_has_roles'])
                ->where([$rolePivotKey => $roleId, 'model_type' => $morphClass])
                ->pluck($morphKey);

            DB::table('users')->whereIn('id', $userIds)->update(['role' => $legacyRole]);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    /**
     * Buat peran admin, staf, dan mahasiswa bila belum ada.
     *
     * @return array<string, int>
     */
    private function ensureRolesExist(): array
    {
        $rolesTable = config('permission.table_names.roles');

        foreach (array_unique(self::ROLE_MAP) as $role) {
            $exists = DB::table($rolesTable)
                ->where(['name' => $role, 'guard_name' => self::GUARD])
                ->exists();

            if (! $exists) {
                DB::table($rolesTable)->insert([
                    'name' => $role,
                    'guard_name' => self::GUARD,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return DB::table($rolesTable)
            ->where('guard_name', self::GUARD)
            ->pluck('id', 'name')
            ->map(fn (mixed $id): int => (int) $id)
            ->all();
    }
};
