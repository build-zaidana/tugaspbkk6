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

// 'role' sengaja tidak fillable agar user tidak bisa menaikkan perannya sendiri.
#[Fillable(['name', 'email', 'password', 'nrp', 'nip', 'department', 'bio'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use Notifiable;

    public const ROLE_DOSEN = 'dosen';

    public const ROLE_ASDOS = 'asdos';

    public const ROLE_MAHASISWA = 'mahasiswa';

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

    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role, $roles, true);
    }

    public function academicIdentifierField(): string
    {
        return $this->hasRole(self::ROLE_DOSEN) ? 'nip' : 'nrp';
    }
}
