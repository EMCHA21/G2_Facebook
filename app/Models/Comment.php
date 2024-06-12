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
    public function posts():BelongsTo
    {
        return $this->belongsTo(Post::class,'post_id','id');
    }

    public function users():BelongsTo
    {
        return $this->belongsTo(User::class,'auth_id','id');
    }
    
    function deleteComment ($id){
        $post = Comment::where('id',$id)->first();
        try{
            $post->delete();
        }catch(Exception $error){
            return $error;
        }
    }
}

