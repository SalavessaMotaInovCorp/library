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
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@library.com',
            'password' => Hash::make('Library1!'),
            'role' => 'admin',
        ]);
        $admin->assignRole('admin');

        $citizen = User::factory()->create([
            'name' => 'Citizen',
            'email' => 'citizen@library.com',
            'password' => Hash::make('Library1!'),
            'role' => 'citizen',
        ]);
        $citizen->assignRole('citizen');

        $teste1 = User::factory()->create([
            'name' => 'Teste 1',
            'email' => 'teste@teste.pt',
            'password' => Hash::make('Library1!'),
            'role' => 'citizen',
        ]);
        $teste1->assignRole('citizen');

        $teste2 = User::factory()->create([
            'name' => 'Teste 2',
            'email' => 'teste2@teste.pt',
            'password' => Hash::make('Library1!'),
            'role' => 'citizen',
        ]);
        $teste2->assignRole('citizen');

        // Create 50 books
        $books = Book::factory(8)->create();

        // Create 30 authors
        $authors = Author::factory(10)->create();

        // Attach 1 to 3 random authors to each book
        $books->each(function ($book) use ($authors) {
            $book->authors()->attach(
                $authors->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
