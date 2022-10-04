<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = ['message', 'author_id'];  

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }
}
