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
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'auth_id', 'id');
    }

    public static function list()
    {
        return Post::all();
    }

    public static function store($request, $id = null)
    {
        $data = $request->only('auth_id', 'title', 'content', 'tags', 'img');
        $data = self::updateOrCreate(["id" => $id], $data);
        return $data;
    }
    function deletePost($id)
    {
        $post = Post::where('id', $id)->first();
        try {
            $post->delete();
        } catch (Exception $error) {
            return $error;
        }
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
