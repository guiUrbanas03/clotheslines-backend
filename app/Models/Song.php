<?php

namespace App\Models;

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
}
