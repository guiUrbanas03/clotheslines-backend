<?php

namespace Database\Factories;

use App\Models\Playlist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Song>
 */
class SongFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'playlist_id' => $this->faker->randomElement(Playlist::all()->pluck('id')->toArray()),
            'name' => $this->faker->words(5, true),
            'artist' => $this->faker->name(),
            'album' => $this->faker->words(5, true),
        ];
    }
}
