<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Playlist>
 */
class PlaylistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'profile_id' => $this->faker->randomElement(Profile::all()->pluck('id')->toArray()),
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->text(255),
        ];
    }
}
