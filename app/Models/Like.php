<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post;

class Like extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'post_id',
    ];
    use HasFactory;
    // relationship like and post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    // relationship like and user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
