<?php

namespace App\Interfaces\Services;

use App\Models\User;
use Laravel\Socialite\Contracts\User as ContractsUser;

interface IUserService
{
    /**
     * @param array $attributes
     * @return User
     */
    function findOrCreate(string $email, array $attributes): User;
}