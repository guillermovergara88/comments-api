<?php

namespace Tests\Unit\Http\Requests;

use App\Models\Author;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorsRequestTest extends TestCase
{

    use RefreshDatabase;  
  
    private string $routePrefix = 'api.authors.';  

    /**  
     * @test  
     * @throws \Throwable  
     */  
    public function name_is_required()  
    {  

        $validatedField = 'name';  
        $brokenRule = null;  
        
        $author = Author::factory()->make([  
            $validatedField => $brokenRule  
        ]);  
        $this->postJson(  
            route($this->routePrefix . 'store'),  
            $author->toArray()  
        )->assertJsonValidationErrors($validatedField);  
    }
}
