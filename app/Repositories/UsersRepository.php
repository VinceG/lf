<?php

namespace App\Repositories;

use App\Models\User;

class UsersRepository
{
    public function paginate()
    {
        return User::paginate();
    }

    public function create(array $attributes)
    {
        return User::create($attributes);
    }

    public function update(User $user, array $attributes)
    {
        $user->update($attributes);

        return $user;
    }
}
