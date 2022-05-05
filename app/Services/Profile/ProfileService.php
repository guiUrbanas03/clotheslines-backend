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

        $profile->update($profileDTO);

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
