<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Throwable;
use Illuminate\Support\Facades\DB;
class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @throws Throwable
     */
    public function run(): void
    {
        $data = [
            [
                'auth_id' => 1,
                'title' => 'Post 1',
                'content' => 'Post 1 content',
            ],
            [
                'auth_id' => 2,
                'title' => 'Post 2',
                'content' => 'Post 2 content',
            ],
            [
                'auth_id' => 1,
                'title' => 'Post 3',
                'content' => 'Post 3 content',
            ]
        ];
        foreach($data as $post){
            Post::create($post);
        }
    }
}
