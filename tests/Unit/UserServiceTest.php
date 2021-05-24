<?php

namespace Tests\Unit;

use App\Interfaces\Services\IUserService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;


class UserServiceTest extends TestCase
{
    protected IUserService $userService;

    public function setUp(): void
    {
        parent::setUp();
        $this->userService = $this->app->make('App\Interfaces\Services\IUserService');
    }

    public function test_findOrCreateExistingUser()
    {
        $existingUser = User::factory()->create();
        $user = $this->userService->findOrCreate(
            $existingUser->email,
            [
                'name' => $this->faker()->name(),
                'provider_name' => Str::random(),
                'provider_id' => Str::random()
            ]
        );
        $this->assertDatabaseCount('users', 1);
        $this->assertTrue($existingUser->is($user));
    }

    public function test_findOrCreateNewUser()
    {
        $user = $this->userService->findOrCreate(
            $this->faker()->email,
            [
                'name' => $this->faker()->name(),
                'provider_name' => Str::random(),
                'provider_id' => Str::random()
            ]
        );
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', ['email' => $user->email]);
    }
}
