<?php

namespace App\Services\Song;

use App\Models\Song;

class SongService
{

    public function getAllSongs()
    {
        return Song::all();
    }

    public function getSong($songId)
    {
        return Song::findOrFail($songId);
    }

    public function createSong($songData)
    {
        $song = Song::create($songData);

        return $song;
    }

    public function updateSong($songId, $songData)
    {
        $song = Song::findOrFail($songId);

        $song->update($songData);

        return $song;
    }

    public function deleteSong($songId)
    {
        $song = Song::findOrFail($songId);

        $song->delete();

        return $song;
    }
}
