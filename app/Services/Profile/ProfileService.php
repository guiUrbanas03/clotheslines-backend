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

    public function createProfile($profileDTO)
    {
        return Profile::create($profileDTO);
    }

    public function updateProfile($profileId, $profileDTO)
    {
        $profile = Profile::find($profileId);

        return $profile->update($profileDTO);
    }

    public function deleteProfile($profileId)
    {
        $profile = Profile::find($profileId);

        return $profile->delete();
    }
}
