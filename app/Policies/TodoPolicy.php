<?php

namespace App\Policies;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TodoPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param User $user
     * @param Todo $todo
     * @return bool
     */
    public function show(User $user, Todo $todo): bool
    {
        return $user->id === $todo->user_id;
    }

    /**
     * @param User $user
     * @param Todo $todo
     * @return bool
     */
    public function createTask(User $user, Todo $todo): bool
    {
        return $user->id === $todo->user_id;
    }

    /**
     * @param User $user
     * @param Todo $todo
     * @return bool
     */
    public function update(User $user, Todo $todo): bool
    {
        return $user->id === $todo->user_id;
    }

    /**
     * @param User $user
     * @param Todo $todo
     * @return bool
     */
    public function destroy(User $user, Todo $todo): bool
    {
        return $user->id === $todo->user_id;
    }

}
