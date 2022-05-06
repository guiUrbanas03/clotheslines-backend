<?php

namespace App\Services\Profile;

use App\Models\Profile;

class ProfileService
{
    public function getAllProfiles()
    {
        return Profile::all();
    }

    public function getProfile($profile_id)
    {
        return Profile::find($profile_id);
    }

    public function createProfile($userId, $profileData)
    {
        return Profile::create([
            'user_id' => $userId,
            'nickname' => $profileData['nickname'],
            'first_name' => $profileData['first_name'],
            'last_name' => $profileData['last_name'],
            'country' => $profileData['country'],
        ]);
    }

    public function updateProfile($profileId, $profileData)
    {
        $profile = Profile::find($profileId);

        $profile->update($profileData);

        return $profile;
    }

    public function deleteProfile($profileId)
    {
        $profile = Profile::find($profileId);

        return $profile->delete();
    }

    public function restoreProfile($profileId)
    {
        $profile = Profile::withTrashed()->findOrFail($profileId);

        $profile->restore();

        return $profile;
    }
}
