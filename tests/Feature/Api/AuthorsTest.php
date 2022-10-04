<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Author;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorsTest extends TestCase
{

    use RefreshDatabase;
    
    private string $routePrefix = 'api.authors.';  
    
     /**  @test */  
    public function name_must_not_exceed_50_characters()  
    {  
        $validatedField = 'name';  
        $brokenRule = Str::random(51);  
        
        $author = Author::factory()->make([  
            $validatedField => $brokenRule  
        ]);  

        $this->postJson(  
            route($this->routePrefix . 'store'),  
            $author->toArray()  
        )->assertJsonValidationErrors($validatedField);  
    }
    
    /** @test */
	public function can_get_all_authors()
	{
		$author = Author::factory()->create();
		
		$response = $this->getJson(route($this->routePrefix.'index'));

		$response->assertOk(); 
		
		$response->assertJson([
			'data' => [
				[
					'id' => $author->id,
					'name' => $author->name,  
				]
			]
		]);
	}

    /** @test */
    public function can_store_an_author()
    {
        $newAuthor = Author::factory()->make();

        $response = $this->postJson(
            route(($this->routePrefix.'store'), $newAuthor->toArray()));

        $response->assertCreated();

        $response->assertJson([
             'data' => ['name' => $newAuthor->name]
         ]);

        $this->assertDatabaseHas(
             'authors', 
             $newAuthor->toArray()
         );
    }

    /** @test */
	public function can_update_an_author() 
	{
		$existingAuthor = Author::factory()->create();  
		$newAuthor = Author::factory()->make();  
		  
		$response = $this->putJson(  
			route($this->routePrefix . 'update', $existingAuthor),  
			$newAuthor->toArray() 
		);  
		$response->assertJson([  
			'data' => [  
				'id' => $existingAuthor->id,  
				'name' => $newAuthor->name
			]
		]);  
		  
		$this->assertDatabaseHas(  
			'authors',  
			$newAuthor->toArray()  
		);
	}

    /** @test */
	public function can_delete_an_author() 
	{
		$existingAuthor = Author::factory()->create();

        $response = $this->deleteJson(route($this->routePrefix.'destroy', $existingAuthor));

		$response->assertNoContent(); 
	}
}
