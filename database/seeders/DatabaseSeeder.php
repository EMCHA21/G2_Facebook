<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Model::unguard();
        if ($this->isLocal()) {
            Schema::disableForeignKeyConstraints();
            $this->call(RoleAndPermissionSeeder::class);
            $this->call(UserSeeder::class);
            Schema::enableForeignKeyConstraints();
        } else {
            $this->call(DefaultUsersSeeder::class);
        }
        Model::reguard();
        $this->call(PostSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(LikeSeeder::class);
        $this->call(FriendSeeder::class);
    }

    private function isLocal(): bool
    {
        return app()->environment('local');
    }
}
