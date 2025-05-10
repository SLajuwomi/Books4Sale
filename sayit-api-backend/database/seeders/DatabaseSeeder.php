<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create test users
        $johnDoeId = DB::table('users')->insertGetId([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $janeSmithId = DB::table('users')->insertGetId([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $barronId = DB::table('users')->insertGetId([
            'name' => 'Barron Trump',
            'email' => 'barontrump@gmail.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create sample messages
        $messages = [
            // Books category
            [
                'user_id' => $johnDoeId,
                'ts' => Carbon::now()->subMinutes(50),
                'topic' => 'Books',
                'message' => 'Just finished reading an amazing novel!'
            ],
            [
                'user_id' => $janeSmithId,
                'ts' => Carbon::now()->subMinutes(45),
                'topic' => 'Books',
                'message' => 'Looking for book recommendations.'
            ],
            [
                'user_id' => $johnDoeId,
                'ts' => Carbon::now()->subMinutes(30),
                'topic' => 'Books',
                'message' => 'Wheel of time is great!'
            ],
            
            // Movies category
            [
                'user_id' => $johnDoeId,
                'ts' => Carbon::now()->subMinutes(40),
                'topic' => 'Movies',
                'message' => 'Great new sci-fi movie out this weekend'
            ],
            [
                'user_id' => $janeSmithId,
                'ts' => Carbon::now()->subMinutes(35),
                'topic' => 'Movies',
                'message' => 'Anyone want to discuss classic films?'
            ],
            
            // Technology category
            [
                'user_id' => $johnDoeId,
                'ts' => Carbon::now()->subMinutes(25),
                'topic' => 'Technology',
                'message' => 'Check out this cool new gadget!'
            ],
            [
                'user_id' => $barronId,
                'ts' => Carbon::now()->subMinutes(20),
                'topic' => 'Technology',
                'message' => 'AI is really changing the world!'
            ],
            [
                'user_id' => $johnDoeId,
                'ts' => Carbon::now()->subMinutes(15),
                'topic' => 'Technology',
                'message' => 'Gemini 2.5 Pro is SOTA GODLY'
            ]
        ];

        // Insert messages
        foreach ($messages as $message) {
            DB::table('sayit_messages')->insert($message);
        }
    }
}
