<?php

namespace Tests\Unit\Http\Requests;

use Tests\TestCase;
use App\Models\Author;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentsRequestTest extends TestCase
{

    use RefreshDatabase;  
  
    private string $routePrefix = 'api.comments.';  

    /**  
     * @test  
     * @throws \Throwable  
     */  
    public function author_and_message_is_required()  
    {  
        $comment = Comment::factory()->make([  
            'author_id' => null,  
            'message' => null,  
        ]);  
 
        $this->postJson(  
            route($this->routePrefix . 'store'),  
            $comment->toArray()  
        )->assertJsonValidationErrors(['author_id', 'message']);  
    }
}
