<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\Profile\ProfileService;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function getAllUsers()
    {
        return User::all();
    }

    public function getUser($userId)
    {
        return User::findOrFail($userId);
    }

    public function createUser($userData, $profileData)
    {
        $user = User::create([
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
            'status' => $userData['status'],
            'role' => $userData['role'],
        ]);

        $this->profileService->createProfile($user->id, $profileData);

        return $user;
    }


    public function updateUser($userId, $userData, $profileData)
    {
        $user = User::findOrFail($userId);

        $user->update($userData);

        $this->profileService->updateProfile($user->profile->id, $profileData);

        return $user;
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);

        $user->delete();

        $this->profileService->deleteProfile($user->profile->id);

        return $user;
    }

    public function restoreUser($userId)
    {
        $user = User::withTrashed()->findOrFail($userId);
        $profileId = $user->profile()->withTrashed()->pluck('id')->first();

        $user->restore();

        $this->profileService->restoreProfile($profileId);

        return $user;
    }
}
