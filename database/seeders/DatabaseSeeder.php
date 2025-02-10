<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the RolesSeeder
        $this->call([
            RolesSeeder::class,
        ]);

        // Create a test user
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@library.com',
            'password' => Hash::make('password')
        ]);
        $user->assignRole('admin');

        // Create 50 books
        $books = Book::factory(50)->create();

        // Create 30 authors
        $authors = Author::factory(30)->create();

        // Attach 1 to 3 random authors to each book
        $books->each(function ($book) use ($authors) {
            $book->authors()->attach(
                $authors->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
