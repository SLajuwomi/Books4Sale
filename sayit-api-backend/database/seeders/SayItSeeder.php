<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SayItSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create sample users
        $user1Id = DB::table('sayit_users')->insertGetId([
            'email' => 'john@example.com',
            'name' => 'John Doe',
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $user2Id = DB::table('sayit_users')->insertGetId([
            'email' => 'jane@example.com',
            'name' => 'Jane Smith',
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Create sample messages with topics
        $messages = [
            [
                'user_id' => $user1Id,
                'topic' => 'Books',
                'message' => 'Just finished reading an amazing novel!',
                'ts' => now()->subMinutes(30)
            ],
            [
                'user_id' => $user2Id,
                'topic' => 'Books',
                'message' => 'Looking for book recommendations.',
                'ts' => now()->subMinutes(25)
            ],
            [
                'user_id' => $user1Id,
                'topic' => 'Movies',
                'message' => 'Great new sci-fi movie out this weekend!',
                'ts' => now()->subMinutes(20)
            ],
            [
                'user_id' => $user2Id,
                'topic' => 'Movies',
                'message' => 'Anyone want to discuss classic films?',
                'ts' => now()->subMinutes(15)
            ],
            [
                'user_id' => $user1Id,
                'topic' => 'Technology',
                'message' => 'Check out this cool new gadget!',
                'ts' => now()->subMinutes(10)
            ]
        ];

        foreach ($messages as $message) {
            DB::table('sayit_messages')->insert($message);
        }
    }
} 