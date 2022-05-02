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

    public function playlistComments()
    {
        return $this->hasMany(PlaylistComment::class, 'profile_id');
    }

    public function hearts()
    {
        return $this->hasMany(Heart::class);
    }
}