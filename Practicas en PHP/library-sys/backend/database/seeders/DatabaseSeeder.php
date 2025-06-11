<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 5 authors
        $authors = Author::factory(5)->create();

        // Create 5 books and attach random authors to each
        Book::factory(5)->create()->each(function ($book) use ($authors) {
            // Attach 1-3 random authors to each book
            $book->authors()->attach($authors->random(rand(1, 3))->pluck('id')->toArray());
        });

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
