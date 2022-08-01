<?php

namespace App\Http\Controllers\Api\v1\Song;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Song\CreateSongRequest;
use App\Http\Requests\Api\v1\Song\UpdateSongRequest;
use App\Models\Playlist;
use App\Models\Song;
use App\Services\Song\SongService;
use Illuminate\Http\Request;

class SongController extends Controller
{
    protected $songService;

    public function __construct(SongService $songService)
    {
        $this->songService = $songService;
    }

    public function index()
    {
        $songs = $this->songService->getAllSongs();

        return $this->jsonResponse([
            'message' => 'Songs found successfully',
            'songs' => $songs
        ]);
    }

    public function find(Request $request)
    {
        $songId = $request->song_id;

        return $this->jsonResponse([
            'message' => 'Song found successfully',
            'song' => $this->songService->getSong($songId)->resource
        ]);
    }

    public function store(CreateSongRequest $request)
    {
        $songDTO = $request->get('song');

        $song = $this->songService->createSong($songDTO);

        return $this->jsonResponse([
            'message' => 'Song created successfully',
            'song' => $song->resource
        ]);
    }

    public function update(UpdateSongRequest $request)
    {
        $songId = $request->song_id;
        $songDTO = $request->get('song');

        $updatedSong = $this->songService->updateSong($songId, $songDTO);

        return $this->jsonResponse([
            'message' => 'Song updated successfully',
            'song' => $updatedSong->resource
        ]);
    }

    public function destroy(Request $request)
    {
        $songId = $request->song_id;

        $deletedSong = $this->songService->deleteSong($songId);

        return $this->jsonResponse([
            'message' => 'Song deleted successfully',
            'song' => $deletedSong->resource
        ]);
    }
}
