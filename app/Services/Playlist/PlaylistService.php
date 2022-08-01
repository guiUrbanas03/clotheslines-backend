<?php

namespace App\Services\Playlist;

use App\Models\Playlist;

class PlaylistService
{
    public function getAllPlaylists()
    {
        return Playlist::orderBy('created_at', 'DESC')
            ->orderBy('id')
            ->cursorPaginate(3);
    }

    public function getPlaylist($playlistId)
    {
        return Playlist::findOrFail($playlistId);
    }

    public  function createPlaylist($playlistData)
    {
        $playlist = Playlist::create($playlistData);

        return $playlist;
    }

    public function updatePlaylist($playlistId, $playlistData)
    {
        $playlist = Playlist::findOrFail($playlistId);

        $playlist->update($playlistData);

        return $playlist;
    }

    public function deletePlaylist($playlistId)
    {
        $playlist = Playlist::findOrFail($playlistId);

        $playlist->delete();

        return $playlist;
    }

    public function getSongsfromPlaylist($playlist_id)
    {
        $songs = Playlist::find($playlist_id)->songs;

        return $songs;
    }

    public function addSongsToPlaylist($playlist_id, $songs)
    {
        $playlist = Playlist::find($playlist_id);

        $playlist->songs()->createMany($songs);

        return $playlist;
    }
}
