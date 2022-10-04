<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentsTest extends TestCase
{

    use RefreshDatabase;
    
    private string $routePrefix = 'api.comments.'; 


     /**  @test */  
    public function message_must_not_exceed_250_characters()  
    {  
        $validatedField = 'message';  
        $brokenRule = Str::random(251);  
        
        $comment = Comment::factory()->make([  
            $validatedField => $brokenRule  
        ]);  

        $this->postJson(  
            route($this->routePrefix . 'store'),  
            $comment->toArray()  
        )->assertJsonValidationErrors($validatedField);  
    }
    
     /** @test */
	public function can_get_all_comments()
	{
		$comment = Comment::factory()->create();
		
		$response = $this->getJson(route($this->routePrefix.'index'));

		$response->assertOk(); 
		
		$response->assertJson([
			'data' => [
				[
					'id' => $comment->id,
					'message' => $comment->message,  
				]
			]
		]);
	}

    /** @test */
    public function can_store_a_comment()
    {
        $newComment = Comment::factory()->make();

        $response = $this->postJson(
            route(($this->routePrefix.'store'), $newComment->toArray()));

        $response->assertCreated();

        $response->assertJson([
             'data' => ['message' => $newComment->message]
         ]);

        $this->assertDatabaseHas(
             'comments', 
             $newComment->toArray()
         );
    }

    /** @test */
	public function can_update_a_comment() 
	{
		$existingComment = Comment::factory()->create();  
		$newComment = Comment::factory()->make();  
		  
		$response = $this->putJson(  
			route($this->routePrefix . 'update', $existingComment),  
			$newComment->toArray() 
		);  
		$response->assertJson([  
			'data' => [  
				'id' => $existingComment->id,  
				'message' => $newComment->message
			]
		]);  
		  
		$this->assertDatabaseHas(  
			'comments',  
			$newComment->toArray()  
		);
	}

    /** @test */
	public function can_delete_a_comment() 
	{
		$existingComment = Comment::factory()->create();

        $response = $this->deleteJson(route($this->routePrefix.'destroy', $existingComment));

		$response->assertNoContent(); 
	}
}
