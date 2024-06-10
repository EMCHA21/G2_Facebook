<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'auth_id',
        'tags',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public static function list(){
        return Post::all();
    }
    function updatePost($id, $title, $content,$auth_id,$tags){
        $post = Post::where('id',$id)->first();
        $post->title = $title;
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
}
