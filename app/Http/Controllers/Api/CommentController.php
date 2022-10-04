<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CommentsRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
	{
        return response()->json([  
		    'data' => Comment::all()  
		]);
	}

    public function store(CommentsRequest $request) : JsonResponse
    {
        $comment = Comment::create($request->validated());

        return response()->json([
            'data' => $comment
        ], 201);
    }

    public function update(CommentsRequest $request, Comment $comment) : JsonResponse
    {
        $comment->update($request->all());

        return response()->json([
            'data' => $comment
        ]);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json(null, 204);
    }
}
