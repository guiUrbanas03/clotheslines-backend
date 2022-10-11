<?php

namespace App\Models;

use App\Enums\HearteableType;
use App\Http\Resources\Heart\HeartResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Heart extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'hearteable_id',
        'hearteable_type',
    ];

    public function hearteable()
    {
        return $this->morphTo();
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function getParsedHearteableAttribute()
    {
        $type = array_search($this->hearteable_type, HearteableType::MODEL);

        return (object) [
            'type' => $type,
            'model' => $this->hearteable
        ];
    }

    public function getResourceAttribute()
    {
        return new HeartResource($this);
    }

    public function scopeWhereProfileId($query, $profileId)
    {
        return $query->where('profile_id', $profileId);
    }

    public function scopeWhereHearteableId($query, $hearteableId)
    {
        return $query->where([
            'hearteable_id' => $hearteableId
        ]);
    }

    public function scopeWhereHearteableType($query, $hearteableType)
    {
        return $query->where([
            'hearteable_type' => $hearteableType
        ]);
    }
}
