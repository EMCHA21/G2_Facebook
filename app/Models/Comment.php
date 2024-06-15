<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'auth_id',
        'post_id'
    ];
    // relationship comment and post
    public function posts():BelongsTo
    {
        return $this->belongsTo(Post::class,'post_id','id');
    }
    // relationship comment and user
    public function users():BelongsTo
    {
        return $this->belongsTo(User::class,'auth_id','id');
    }
    // create a new comment or undate comment
    public static function store($request , $id = null){
        $data = $request->only("text", "auth_id", "post_id");
        $data = self::updateOrCreate(["id"=>$id], $data);
        return $data;
    }
    // delete a comment
    function deleteComment ($id){
        $post = Comment::where('id',$id)->first();
        try{
            $post->delete();
        }catch(Exception $error){
            return $error;
        }
    }
}

