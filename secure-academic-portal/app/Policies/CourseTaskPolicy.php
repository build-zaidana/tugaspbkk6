<?php

namespace App\Policies;

use App\Models\CourseTask;
use App\Models\User;

class CourseTaskPolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CourseTask $courseTask): bool
    {
        return $user->id === $courseTask->user_id;
    }
}
