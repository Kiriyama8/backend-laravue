<?php

namespace App\Services;

use App\Exceptions\UserHasBeenTakenException;
use App\Models\User;

class UserService
{
    public function update(User $user, array $array)
    {
        $userEmail = User::where('email', $array['email'])->exists();

        if (!empty($array['email']) && $userEmail) {
            throw new UserHasBeenTakenException();
        }

        if (!empty($array['password'])) {
            $array['password'] = bcrypt($array['password']);
        }

        $user->fill($array);
        $user->save();

        return $user->fresh();
    }
}
