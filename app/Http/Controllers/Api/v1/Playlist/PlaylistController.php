<?php

namespace App\Http\Controllers\Api\v1\Playlist;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Playlist\AddSongsToPlaylistRequest;
use App\Http\Requests\Api\v1\Playlist\CreatePlaylistRequest;
use App\Http\Requests\Api\v1\Playlist\UpdatePlaylistRequest;
use App\Http\Resources\Playlist\PlaylistResource;
use App\Http\Resources\Song\SongResource;
use App\Services\Playlist\PlaylistService;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    protected $playlistService;

    public function __construct(PlaylistService $playlistService)
    {
        $this->playlistService = $playlistService;
    }

    public function index()
    {
        $paginated_playlists = $this->playlistService->getAllPlaylists();

        return $this->jsonResponse([
            'message' => 'Playlists found successfully',
            'playlists' => PlaylistResource::collection($paginated_playlists)->response()->getData(true),
        ]);
    }

    public function find(Request $request)
    {
        $playlistId =  $request->playlist_id;

        return $this->jsonResponse([
            'message' => 'Playlist found successfully',
            'playlist' => $this->playlistService->getPlaylist($playlistId)->resource
        ]);
    }

    public function store(CreatePlaylistRequest $request)
    {
        $playlistDTO = $request->get('playlist');

        $playlist = $this->playlistService->createPlaylist($playlistDTO);

        return $this->jsonResponse([
            'message' => 'Playlist created successfully',
            'playlist' => $playlist->resource
        ]);
    }

    public function update(UpdatePlaylistRequest $request)
    {
        $playlistId = $request->playlist_id;
        $playlistDTO = $request->playlist;

        $updatedPlaylist = $this->playlistService->updatePlaylist($playlistId, $playlistDTO);

        return $this->jsonResponse([
            'message' => 'Playlist updated successfully',
            'playlist' => $updatedPlaylist->resource
        ]);
    }

    public function destroy(Request $request)
    {
        $playlistId = $request->playlist_id;

        $deletedPlaylist = $this->playlistService->deletePlaylist($playlistId);

        return $this->jsonResponse([
            'message' => 'Playlist deleted successfully',
            'playlist' => $deletedPlaylist->resource
        ]);
    }

    public function getSongs(Request $request)
    {
        $playlist_id = $request->playlist_id;

        $songs = $this->playlistService->getSongsfromPlaylist($playlist_id);

        return $this->jsonResponse([
            'message' => 'Songs found succesfully',
            'songs' => SongResource::collection($songs)
        ]);
    }

    public function storeManySongs(AddSongsToPlaylistRequest $request)
    {
        $playlist_id = $request->playlist_id;
        $songs = $request->get('songs');

        $playlist = $this->playlistService->addSongsToPlaylist($playlist_id, $songs);

        return $this->jsonResponse([
            'message' => 'Songs created successfully',
            'songs' => SongResource::collection($playlist->songs)
        ]);
    }
}
