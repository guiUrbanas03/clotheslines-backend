<?php

namespace App\Services\Playlist;

use App\Models\Playlist;
use Illuminate\Support\Facades\Auth;

class PlaylistService
{
    public function getAllPlaylists()
    {
        return Playlist::withCount('hearts')
            ->orderBy('created_at', 'DESC')
            ->orderBy('id')
            ->cursorPaginate(3);
    }

    public function getPlaylist($playlistId)
    {
        return Playlist::findOrFail($playlistId);
    }

    public  function createPlaylist($playlistData)
    {
        $profileId = Auth::user()->profile->id;

        $playlist = Playlist::create([
            'profile_id' => $profileId,
            'title' => $playlistData['title'],
            'description' => $playlistData['description']
        ]);

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

    public function getOwnerUser($playlistId)
    {
        $playlist = Playlist::findOrFail($playlistId);

        return $playlist->profile->user;
    }

    public function heart($playlistId)
    {
        $profileId = Auth::user()->profile->id;

        $playlist = Playlist::findOrFail($playlistId);

        $heart = $playlist->hearts()->create([
            'profile_id' => $profileId,
        ]);

        return $heart;
    }

    public function unheart($playlistId)
    {
        $profile = Auth::user()->profile;

        $profile->playlistsHearts->firstWhere('hearteable_id', $playlistId)->delete();
    }
}
