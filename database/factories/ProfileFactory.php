<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nickname' => $this->faker->unique()->text(20),
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->lastName(),
            'country' => $this->faker->country(),
            'user_id' => $this->faker->unique()->randomElement(User::all()->pluck('id')->toArray()),
        ];
    }
}
