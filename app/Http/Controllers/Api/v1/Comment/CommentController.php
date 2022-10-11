<?php

namespace App\Http\Controllers\Api\v1\Comment;

use App\Http\Controllers\Controller;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use App\Services\Comment\CommentService;
use Illuminate\Http\Request;

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

    public function getHeartsCount(Request $request)
    {
        $commentId = $request->comment_id;

        $comment = Comment::withCount('hearts')->find($commentId);

        return $this->jsonResponse([
            'message' => 'Hearts found successfully',
            'hearts' => $comment->hearts_count
        ]);
    }
}
