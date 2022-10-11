<?php

namespace App\Services\Heart;

use App\Models\Heart;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class HeartService
{
    protected Profile $profile;
    protected $hearteable;

    public function __construct($hearteable)
    {
        $this->profile = Auth::user()->profile;
        $this->hearteable = $hearteable;
    }

    public function heart()
    {
        $heart = Heart::create([
            'profile_id' => $this->profile->id,
            'hearteable_id' => $this->hearteable->id,
            'hearteable_type' => $this->hearteable->type,
        ]);

        return $heart;
    }

    public function unheart()
    {
        $heart = Heart::whereProfileId($this->profile->id)
            ->whereHearteableId($this->hearteable->id)
            ->whereHearteableType($this->hearteable->type);

        $heartToDelete = $heart->first();


        $heart->delete();

        return $heartToDelete;
    }

    public function getProfileHeartedIds()
    {
        $profileHeartedIds = Heart::whereProfileId($this->profile->id)
            ->whereHearteableType($this->hearteable->type)
            ->pluck('hearteable_id');

        return $profileHeartedIds;
    }

    public function getHeartsCount()
    {
        $heartsCount = Heart::whereHearteableId($this->hearteable->id)
            ->whereHearteableType($this->hearteable->type)
            ->count();

        return $heartsCount;
    }
}
