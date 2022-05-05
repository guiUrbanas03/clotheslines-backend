<?php

namespace Database\Seeders;

use App\Enums\UserRoles;
use App\Enums\UserStatus;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomUserWithProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usersWithProfile = [
            [
                'email' => 'urbanas@email.com',
                'role' => UserRoles::ADMIN_USER,
                'nickname' => 'urbanas',
                'first_name' => 'Guilherme',
                'last_name' => 'Urbanas',
                'country' => 'Brazil',
            ],
        ];

        foreach ($usersWithProfile as $userWithProfile) {
            $created_user = User::factory()->create([
                'email' => $userWithProfile['email'],
                'password' => Hash::make('123123123'),
                'role' => $userWithProfile['role'],
                'status' => UserStatus::ACTIVE,
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);

            Profile::factory()->create([
                'user_id' => $created_user->id,
                'nickname' => $userWithProfile['nickname'],
                'first_name' => $userWithProfile['first_name'],
                'last_name' => $userWithProfile['last_name'],
                'country' => $userWithProfile['country'],
            ]);
        }
    }
}
