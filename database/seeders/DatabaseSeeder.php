<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1 Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@library.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 1 Librarian user
        User::create([
            'name' => 'Librarian User',
            'email' => 'librarian@library.com',
            'password' => Hash::make('password'),
            'role' => 'librarian',
        ]);

        // 1 Standard Member user
        User::create([
            'name' => 'Standard Member',
            'email' => 'member@library.com',
            'password' => Hash::make('password'),
            'role' => 'member',
        ]);

        // 3 sample Books, including one out of stock to test edge cases.
        Book::create([
            'title' => 'Mastering Laravel Security',
            'author' => 'Jane Doe',
            'isbn' => '978-1-2345-6789-0',
            'copies' => 5,
        ]);

        Book::create([
            'title' => 'Clean Architecture',
            'author' => 'Robert C. Martin',
            'isbn' => '978-0-1344-9416-6',
            'copies' => 2,
        ]);

        Book::create([
            'title' => 'The Pragmatic Programmer',
            'author' => 'Andrew Hunt',
            'isbn' => '978-0-2016-1622-4',
            'copies' => 0, // Intentionally 0 to test "Book Currently Unavailable" logic
        ]);
    }
}
