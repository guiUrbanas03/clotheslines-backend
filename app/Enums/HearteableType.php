<?php

namespace App\Enums;

use App\Models\Comment;
use App\Models\Playlist;

class HearteableType
{
    const MODEL = [
        'comment' => Comment::class,
        'playlist' => Playlist::class
    ];
}
