<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;
class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            [
                'id' => 1,
                'post_id' => 1,
                'auth_id' => 1,
                'text' => 'This is a comment'
            ],
            [
                'id' => 2,
                'post_id' => 1,
                'auth_id' => 2,
                'text' => 'This is a comment'
            ],
            [
                'id' => 3,
                'post_id' => 1,
                'auth_id' => 1,
                'text' => 'This is a comment'
            ]
        ];
        foreach ($data as $comment){
            Comment::create($comment);
        }
    }
}
