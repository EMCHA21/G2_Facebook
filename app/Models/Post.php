<?php

namespace App\Models;

use App\Models\Like;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'img',
        'content',
        'auth_id',
        'comment',
        'tags',
    ];
    // relationships post and comments
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    // relationships post and user
    public function user()
    {
        return $this->belongsTo(User::class, 'auth_id', 'id');
    }
    // relationship post with likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    // get all posts 
    public static function list()
    {
        return Post::all();
    }
    // create a new post or update a post
    public static function store($request, $id = null)
    {
        $data = $request->only('auth_id', 'title', 'content', 'tags', 'img');
        $data = self::updateOrCreate(["id" => $id], $data);
        return $data;
    }
}
