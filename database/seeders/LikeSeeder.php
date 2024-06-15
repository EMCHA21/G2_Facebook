<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Like;
class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            [
                'user_id' => 1,
                'post_id' => 1,
            ],
            [
                'user_id' => 2,
                'post_id' => 2,
            ],
            [
                'user_id' => 1,
                'post_id' => 3,
            ]
        ];
        foreach ($data as $like){
            Like::create($like);
        }
    }
}
