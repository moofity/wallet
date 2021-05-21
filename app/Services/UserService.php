<?php

namespace App\Services;

use App\Interfaces\Services\IUserService;
use App\Models\User;
use Laravel\Socialite\Contracts\User as ContractsUser;

class UserService implements IUserService
{
    /**
     * @inheritDoc
     */
    public function findOrCreate(string $email, array $attributes): User
    {
        return User::firstOrCreate(['email' => $email], $attributes);
    }
}
