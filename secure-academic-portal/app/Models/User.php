<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

// Peran disimpan di tabel Spatie (bukan kolom fillable), jadi pendaftar
// tidak bisa menaikkan perannya sendiri lewat form.
#[Fillable(['name', 'email', 'password', 'nrp', 'nip', 'department', 'bio'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use HasRoles;
    use Notifiable;

    /** Akses penuh panel admin (diberikan ke dosen pengampu). */
    public const ROLE_ADMIN = 'admin';

    /** Akses terbatas panel admin (diberikan ke asisten dosen). */
    public const ROLE_STAF = 'staf';

    public const ROLE_MAHASISWA = 'mahasiswa';

    /**
     * Label tampilan setiap peran.
     *
     * @var array<string, string>
     */
    public const ROLE_LABELS = [
        self::ROLE_ADMIN => 'Admin (Dosen)',
        self::ROLE_STAF => 'Staf (Asisten Dosen)',
        self::ROLE_MAHASISWA => 'Mahasiswa',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * @return HasMany<Project, $this>
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /** @return HasMany<CourseTask, $this> */
    public function courseTasks(): HasMany
    {
        return $this->hasMany(CourseTask::class);
    }

    /**
     * Admin (dosen) memakai NIP, sedangkan staf (asdos) dan mahasiswa memakai NRP.
     */
    public function academicIdentifierField(): string
    {
        return $this->hasRole(self::ROLE_ADMIN) ? 'nip' : 'nrp';
    }

    public function canAccessAdminPanel(): bool
    {
        return $this->hasAnyRole([self::ROLE_ADMIN, self::ROLE_STAF]);
    }

    /**
     * Rute tujuan setelah login: admin & staf ke panel admin, mahasiswa ke dashboard portofolio.
     */
    public function homeRouteName(): string
    {
        return $this->canAccessAdminPanel() ? 'admin.dashboard' : 'dashboard';
    }

    public function roleName(): string
    {
        return $this->getRoleNames()->first() ?? self::ROLE_MAHASISWA;
    }

    public function roleLabel(): string
    {
        return self::ROLE_LABELS[$this->roleName()] ?? ucfirst($this->roleName());
    }

    /**
     * Deskripsi pada user menu AdminLTE (opsi usermenu_desc).
     */
    public function adminlte_desc(): string
    {
        return $this->roleLabel();
    }
}
