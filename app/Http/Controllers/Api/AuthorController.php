<?php

namespace App\Http\Controllers\Api;

use App\Models\Author;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorsRequest;

class AuthorController extends Controller
{
    public function index()
	{
        return response()->json([  
		    'data' => Author::all()  
		]);
	}

    public function store(AuthorsRequest $request) : JsonResponse
    {
        $author = Author::create($request->validated());

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
