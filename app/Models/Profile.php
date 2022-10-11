<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nickname',
        'first_name',
        'last_name',
        'country'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function playlists()
    {
        return $this->hasMany(Playlist::class);
    }

    public function hearts()
    {
        return $this->hasMany(Heart::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getPlaylistsHeartsAttribute()
    {
        return $this->hearts()->where('hearteable_type', Playlist::class);
    }

    public function getCommentsHeartsAttribute()
    {
        return $this->hearts()->where('hearteable_type', Comment::class);
    }
}
