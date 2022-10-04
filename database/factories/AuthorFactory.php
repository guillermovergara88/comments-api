<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    
     /**  
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [  
            'name' => Str::random(10)
        ];
    }
}
