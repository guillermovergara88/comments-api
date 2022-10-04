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
        $comment = DB::table('comments')->insert($request->validated());

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
