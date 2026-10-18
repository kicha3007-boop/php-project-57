<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Task $task): bool
    {
        return true;
    }

    /**
     * Удалить задачу может только её автор.
     */
    public function delete(User $user, Task $task): bool
    {
        return $task->created_by_id === $user->id;
    }
}
