<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaylistComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'playlist_id',
        'text'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }

    public function hearts()
    {
        return $this->morphMany(Heart::class, 'hearteable');
    }
}
