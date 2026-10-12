<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Hanya mahasiswa pembuat proposal yang boleh menyunting judul proyeknya.
     */
    public function update(User $user, Project $project): bool
    {
        return $user->id === $project->user_id;
    }

    /**
     * Penghapusan mengikuti aturan yang sama dengan penyuntingan.
     */
    public function delete(User $user, Project $project): bool
    {
        return $this->update($user, $project);
    }
}
