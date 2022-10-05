<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentsRequest;

class CommentController extends Controller
{
    public function index()
	{
        $comments = DB::table('comments')->get();
        return response()->json([  
		    'data' => $comments 
		]);
	}

    public function store(CommentsRequest $request) : JsonResponse
    {
        $parent = Comment::find($request->parent_id);
        if ($parent) {
            $parent = Comment::find($parent->parent_id);
            if ($parent) {
                $parent = Comment::find($parent->parent_id);
                if ($parent) {
                    return response()->json([
                        'message' => 'Only can be three layers'
                    ], 400);
                }
            }
        }

        $comment = DB::table('comments')->insert($request->validated());

        return response()->json([
            'data' => $comment
        ], 201);
    }

    public function update(CommentsRequest $request, Comment $comment) : JsonResponse
    {
        $checkLevels = Comment::verifyNoMoreThanTwoLevels($comment);
        if (!$checkLevels) {
            return response()->json([
                'message' => 'Only can be three layers'
            ], 400);
        }

        $comment->update($request->all());
        return response()->json([
            'data' => $comment
        ]);
    }

    public function destroy(Comment $comment) : JsonResponse
    {
        $comment->delete();

        return response()->json(null, 204);
    }

    public function nested() : JsonResponse
    {
        $comments = DB::table('comments')
            ->join('authors', 'comments.author_id', '=', 'authors.id')
            ->select('comments.*', 'authors.name')
            ->get();

        $comments = Comment::parseNestedComments($comments);
        $comments = Comment::removeAuthorIdAndParentId($comments);
        
        return response()->json($comments);
    }

}
