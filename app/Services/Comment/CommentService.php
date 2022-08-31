<?php

namespace App\Services\Comment;

use App\Models\Playlist;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    public function storePlaylistComment($playlistId, $commentText)
    {
        $profile = Auth::user()->profile;

        $playlist = Playlist::findOrFail($playlistId);

        $comment = $playlist->comments()->create([
            'profile_id' => $profile->id,
            'text' => $commentText
        ]);

        return $comment;
    }

    public function getPlaylistComments($playlistId)
    {
        $playlist = Playlist::findOrFail($playlistId);

        $comments = $playlist->comments;

        return $comments;
    }
}
