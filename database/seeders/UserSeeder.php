<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Normal User 1
        $user1 = User::create([
            'name' => 'User One',
            'email' => 'user1@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // Normal User 2
        $user2 = User::create([
            'name' => 'User Two',
            'email' => 'user2@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // Posts
        Post::create([
            'user_id' => $user1->id,
            'title' => 'User1 Post',
            'content' => 'Content by user1',
        ]);

        Post::create([
            'user_id' => $user2->id,
            'title' => 'User2 Post',
            'content' => 'Content by user2',
        ]);
    }
}
