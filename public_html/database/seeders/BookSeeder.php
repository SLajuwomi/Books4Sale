<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->truncate();
        DB::table('book_users')->truncate();

        DB::table('book_users')->insert([
            [
                'user_id' => 1,
                'name' => 'Alice Wonderland',
                'email' => 'alice@example.com',
                'password' => Hash::make('alicePass123'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 2,
                'name' => 'Bob The Builder',
                'email' => 'bob@example.com',
                'password' => Hash::make('bobSecureP@ss'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 3,
                'name' => 'Charlie Brown',
                'email' => 'charlie@example.com',
                'password' => Hash::make('charlieR0cks!'),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Insert Books
        DB::table('books')->insert([
            // Books for Alice (user_id = 1)
            ['title' => 'The Great Gatsby', 'book_condition' => '3', 'price' => 10.99, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'To Kill a Mockingbird', 'book_condition' => '4', 'price' => 15.50, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Adventures in Wonderland', 'book_condition' => '2', 'price' => 8.75, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Dune', 'book_condition' => '4', 'price' => 18.50, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'War and Peace', 'book_condition' => '2', 'price' => 14.30, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Books for Bob (user_id = 2)
            ['title' => '1984', 'book_condition' => '4', 'price' => 7.25, 'user_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Brave New World', 'book_condition' => '3', 'price' => 9.00, 'user_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Building for Dummies', 'book_condition' => '1', 'price' => 19.99, 'user_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'The Hobbit', 'book_condition' => '3', 'price' => 11.20, 'user_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'The Lord of the Rings', 'book_condition' => '4', 'price' => 29.99, 'user_id' => 2, 'created_at' => now(), 'updated_at' => now()],

            // Books for Charlie (user_id = 3)
            ['title' => 'Pride and Prejudice', 'book_condition' => '3', 'price' => 22.00, 'user_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'The Catcher in the Rye', 'book_condition' => '2', 'price' => 12.75, 'user_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Peanuts Collection', 'book_condition' => '4', 'price' => 25.00, 'user_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Moby Dick', 'book_condition' => '1', 'price' => 5.99, 'user_id' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}