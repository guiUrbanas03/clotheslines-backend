<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\Profile\ProfileService;

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

    public function createUser($userDTO, $profileDTO)
    {
        $user = User::create($userDTO);
        $this->profileService->createProfile($profileDTO);

        return $user;
    }

    public function updateUser($userId, $userDTO, $profileDTO)
    {
        $user = User::findOrFail($userId);
        $user->update($userDTO);
        $this->profileService->updateProfile($user->profile->id, $profileDTO);

        return $user;
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);

        $user->delete();

        return $user;
    }
}
