<?php

namespace App\Http\Controllers\Api\v1\Comment;

use App\Http\Controllers\Controller;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Playlist;
use App\Services\Comment\CommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function storeComment(Request $request)
    {
        $playlistId = $request->playlist_id;
        $commentText = $request->get('text');

        $comment = $this->commentService->storePlaylistComment($playlistId, $commentText);

        return $this->jsonResponse([
            'message' => 'Comment created successfully',
            'comment' => $comment->resource
        ]);
    }

    public function getPlaylistComments(Request $request)
    {
        $playlistId = $request->playlist_id;

        $comments = $this->commentService->getPlaylistComments($playlistId);

        return $this->jsonResponse([
            'message' => 'Comments found successfully',
            'comments' => CommentResource::collection($comments)
        ]);
    }
}
