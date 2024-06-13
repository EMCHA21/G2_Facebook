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
    public function comments():HasMany
    {
        return $this->hasMany(Comment::class);
    }
    public function user(){
        return $this->belongsTo(User::class,'auth_id','id');
    }

    public static function list(){
        return Post::all();
    }
    function updatePost($id, $title,$img, $content,$auth_id,$tags){
        $post = Post::where('id',$id)->first();
        $post->title = $title;
        $post->img = $img;
        $post->content = $content;
        $post->auth_id = $auth_id;
        $post->tags = $tags;
        try{
            $post->save();
        }catch(Exception $error){
            return $error;
        }
    }

    function deletePost($id){
        $post = Post::where('id',$id)->first();
        try{
            $post->delete();
        }catch(Exception $error){
            return $error;
        }
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
