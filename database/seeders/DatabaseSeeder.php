<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        switch (strtolower(config('app.env'))) {
            case 'local':
                $this->call([
                    CustomUserWithProfileSeeder::class,
                    UserSeeder::class,
                    ProfileSeeder::class,
                ]);
                break;

            case 'homolog':
                $this->call([
                    CustomUserWithProfileSeeder::class,
                    UserSeeder::class,
                    ProfileSeeder::class,
                ]);
                break;

            case 'production':
                $this->call([
                    CustomUserWithProfileSeeder::class,
                    UserSeeder::class,
                    ProfileSeeder::class,
                ]);
                break;
        }
    }
}
