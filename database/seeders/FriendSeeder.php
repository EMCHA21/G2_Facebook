<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Friend;
class FriendSeeder extends Seeder
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
                'friend_id' => 2,
                'confirm' => 1
            ],
            [
                'user_id' => 2,
                'friend_id' => 1,
                'confirm' => 1
            ]
        ];
        foreach ($data as $friend){
            Friend::create($friend);
        }
    }
}
