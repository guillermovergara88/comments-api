<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = ['message', 'author_id'];  

    protected $hidden = ['parent_id'];

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'id');
    }

    public static function parseNestedComments($comments, $parent_id = null) : array
     {
        $result = [];
        foreach ($comments as $comment) {
            if ($comment->parent_id == $parent_id) {
                $comment->comments = self::parseNestedComments($comments, $comment->id);
                $result[] = $comment;
            }
        }
        return $result;
     }

    public static function removeAuthorIdAndParentId($comments)
    {
        foreach ($comments as $comment) {
            unset($comment->author_id);
            unset($comment->parent_id);
            if (count($comment->comments) > 0) {
                self::removeAuthorIdAndParentId($comment->comments);
            }
        }
        return $comments;
    }
}
