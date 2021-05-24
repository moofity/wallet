<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

class WalletFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Wallet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word(),
            'type' => $this->faker->randomElement(config('enum.wallet_types')),
            'user_id' => User::factory()->create()->id
        ];
    }

    public function positiveBalance()
    {
        return $this->state(function (array $attributes) {
            return [
                'balance' => $this->faker->randomNumber(4)
            ];
        });
    }
}
