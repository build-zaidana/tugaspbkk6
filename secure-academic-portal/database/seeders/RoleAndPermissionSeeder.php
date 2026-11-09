<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Daftar izin (permission) beserta keterangannya.
     *
     * @var array<string, string>
     */
    public const PERMISSIONS = [
        'lihat-data' => 'Melihat data mahasiswa & proposal di panel admin',
        'kelola-nilai' => 'Mengisi nilai dan catatan review proposal',
        'hapus-data' => 'Menghapus data mahasiswa & proposal',
        'kelola-pengguna' => 'Mengubah peran pengguna',
    ];

    /**
     * Matriks hak akses: peran => izin yang dimiliki.
     *
     * @var array<string, list<string>>
     */
    public const ROLE_PERMISSIONS = [
        User::ROLE_ADMIN => ['lihat-data', 'kelola-nilai', 'hapus-data', 'kelola-pengguna'],
        User::ROLE_STAF => ['lihat-data', 'kelola-nilai'],
        User::ROLE_MAHASISWA => [],
    ];

    /**
     * Daftarkan peran & izin ke tabel Spatie. Aman dijalankan berulang kali.
     */
    public function run(): void
    {
        $registrar = app(PermissionRegistrar::class);
        $registrar->forgetCachedPermissions();

        foreach (array_keys(self::PERMISSIONS) as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $registrar->forgetCachedPermissions();

        foreach (self::ROLE_PERMISSIONS as $role => $permissions) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web'])
                ->syncPermissions($permissions);
        }

        $registrar->forgetCachedPermissions();
    }
}
