<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Author;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentsTest extends TestCase
{

    use RefreshDatabase;
    
    private string $routePrefix = 'api.comments.'; 


     /** @test */
	public function can_get_all_comments()
	{
		$author = Author::factory()->create();
		$comment = Comment::factory()->for($author)->create();
		
		$response = $this->getJson(route($this->routePrefix.'index'));

		$response->assertOk(); 
		
		$response->assertJson([
			'data' => [
				[
					'id' => $comment->id,
					'author_id' => $comment->author_id,
					'message' => $comment->message,  
				]
			]
		]);
	}

    /** @test */
    public function can_store_a_comment()
    {
		$author = Author::factory()->create();
		$newComment = Comment::factory()->make(['author_id' => $author->id]);

		$response = $this->postJson(
			route(($this->routePrefix.'store'), $newComment->toArray()));

		$response->assertCreated();
    }

    /** @test */
	public function can_update_a_comment() 
	{
		$author = Author::factory()->create();
		$comment = Comment::factory()->for($author)->create();
		$updatedComment = Comment::factory()->make(['author_id' => $author->id]);

		$response = $this->putJson(
			route(($this->routePrefix.'update'), $comment->id), 
			$updatedComment->toArray()
		);

		$response->assertOk();
	}

    /** @test */
	public function can_delete_a_comment() 
	{
		$author = Author::factory()->create();
		$existingComment = Comment::factory()->for($author)->create();

        $response = $this->deleteJson(route($this->routePrefix.'destroy', $existingComment));

		$response->assertNoContent(); 
	}

	/** @test */
	public function comments_can_not_have_more_than_2_comments()
	{
		$author = Author::factory()->create();
		$comment = Comment::factory()->for($author)->create();
		$childComment = Comment::factory()->for($author)->create(['parent_id' => $comment->id]);
		$grandChildComment = Comment::factory()->for($author)->create(['parent_id' => $childComment->id]);
		$greatGrandChildComment = Comment::factory()->for($author)->create(['parent_id' => $childComment->id]);
		$greatGreatGrandChildComment = Comment::factory()->for($author)->create(['parent_id' => $childComment->id]);
		$greatGreatGreatGrandChildComment = Comment::factory()->for($author)->create(['parent_id' => $childComment->id]);

		//This test fails, but it should not if adding an Observer on the Comment model, 
		//which I cannot because I'd be using ::create method from Eloquent Model and is forbidden in this scenario.

		$response = $this->getJson(route($this->routePrefix.'nested'));

		$response->assertStatus(400);
	}
}
