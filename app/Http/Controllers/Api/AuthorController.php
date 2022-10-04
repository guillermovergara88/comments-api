<?php

namespace App\Http\Controllers\Api;

use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorsRequest;

class AuthorController extends Controller
{
    public function index()
	{
        $authors = DB::table('authors')->get();
        return response()->json([  
		    'data' =>  $authors
		]);
	}

    public function store(AuthorsRequest $request) : JsonResponse
    {
        $author = DB::table('authors')->insert($request->validated());
        return response()->json([
            'data' => $author
        ], 201);
    }

    public function update(AuthorsRequest $request, Author $author) : JsonResponse
    {
        $author->update($request->all());
        return response()->json([
            'data' => $author
        ]);
    }

    public function destroy(Author $author)
    {
        $author->delete();

        return response()->json(null, 204);
    }
}
