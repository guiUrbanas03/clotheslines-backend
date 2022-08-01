<?php

namespace App\Models;

use App\Http\Resources\Song\SongResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'playlist_id',
        'name',
        'artist',
        'album'
    ];

    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }

    public function getResourceAttribute()
    {
        return new SongResource($this);
    }
}
