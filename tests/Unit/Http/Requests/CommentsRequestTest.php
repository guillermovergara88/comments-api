<?php

namespace Tests\Unit\Http\Requests;

use Tests\TestCase;
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
    public function message_is_required()  
    {  

        $validatedField = 'message';  
        $brokenRule = null;  
        
        $comment = Comment::factory()->make([  
            $validatedField => $brokenRule  
        ]);  
        $this->postJson(  
            route($this->routePrefix . 'store'),  
            $comment->toArray()  
        )->assertJsonValidationErrors($validatedField);  
    }
}
