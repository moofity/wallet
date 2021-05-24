<?php

namespace App\Services;

use App\Interfaces\Services\IUserService;
use App\Models\User;

final class UserService implements IUserService
{
    /**
     * @inheritDoc
     */
    public function findOrCreate(string $email, array $attributes): User
    {
        return User::firstOrCreate(['email' => $email], $attributes);
    }
}
