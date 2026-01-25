<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test seller user
        $seller = User::firstOrCreate(
            ['email' => 'seller@boipoka.com'],
            [
                'name' => 'Book Seller',
                'password' => Hash::make('password'),
                'role' => 'seller',
                'phone' => '123-456-7890',
                'address' => '123 Book Street, Book City',
            ]
        );

        // Create a test buyer user
        $buyer = User::firstOrCreate(
            ['email' => 'buyer@boipoka.com'],
            [
                'name' => 'Book Buyer',
                'password' => Hash::make('password'),
                'role' => 'buyer',
                'phone' => '098-765-4321',
                'address' => '456 Reader Avenue, Book Town',
            ]
        );

        // Sample books
        $books = [
            [
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'description' => 'A classic American novel set in the Jazz Age that explores themes of decadence, idealism, resistance to change, social upheaval, and excess.',
                'isbn' => '9780743273565',
                'price' => 12.99,
                'condition' => 'very_good',
                'listing_type' => 'both',
                'category' => 'Fiction',
                'publication_year' => 1925,
                'language' => 'english',
            ],
            [
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'description' => 'A gripping, heart-wrenching, and wholly remarkable tale of coming-of-age in a South poisoned by virulent prejudice.',
                'isbn' => '9780061120084',
                'price' => 14.99,
                'condition' => 'like_new',
                'listing_type' => 'sell',
                'category' => 'Fiction',
                'publication_year' => 1960,
                'language' => 'english',
            ],
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'description' => 'A dystopian social science fiction novel and cautionary tale about the dangers of totalitarianism.',
                'isbn' => '9780451524935',
                'price' => 13.99,
                'condition' => 'good',
                'listing_type' => 'exchange',
                'category' => 'Science Fiction',
                'publication_year' => 1949,
                'language' => 'english',
            ],
            [
                'title' => 'Pride and Prejudice',
                'author' => 'Jane Austen',
                'description' => 'A romantic novel of manners that follows the character development of Elizabeth Bennet.',
                'isbn' => '9780141439518',
                'price' => 11.99,
                'condition' => 'very_good',
                'listing_type' => 'both',
                'category' => 'Romance',
                'publication_year' => 1813,
                'language' => 'english',
            ],
            [
                'title' => 'The Catcher in the Rye',
                'author' => 'J.D. Salinger',
                'description' => 'A story about teenage rebellion and angst, narrated by Holden Caulfield.',
                'isbn' => '9780316769488',
                'price' => 10.99,
                'condition' => 'good',
                'listing_type' => 'sell',
                'category' => 'Fiction',
                'publication_year' => 1951,
                'language' => 'english',
            ],
            [
                'title' => 'Harry Potter and the Philosopher\'s Stone',
                'author' => 'J.K. Rowling',
                'description' => 'The first novel in the Harry Potter series follows Harry Potter as he discovers his magical heritage.',
                'isbn' => '9780439708180',
                'price' => 15.99,
                'condition' => 'like_new',
                'listing_type' => 'both',
                'category' => 'Fantasy',
                'publication_year' => 1997,
                'language' => 'english',
            ],
        ];

        foreach ($books as $bookData) {
            $bookData['user_id'] = $seller->id;
            $bookData['status'] = 'available';
            Book::create($bookData);
        }

        // Create some books for the buyer to exchange
        $buyerBooks = [
            [
                'title' => 'The Hobbit',
                'author' => 'J.R.R. Tolkien',
                'description' => 'A fantasy novel about the quest of home-loving Bilbo Baggins to win a share of the treasure guarded by a dragon.',
                'isbn' => '9780547928227',
                'price' => 14.99,
                'condition' => 'very_good',
                'listing_type' => 'exchange',
                'category' => 'Fantasy',
                'publication_year' => 1937,
                'language' => 'english',
                'user_id' => $buyer->id,
                'status' => 'available',
            ],
            [
                'title' => 'The Lord of the Rings',
                'author' => 'J.R.R. Tolkien',
                'description' => 'An epic high-fantasy novel that is the sequel to The Hobbit.',
                'isbn' => '9780544003415',
                'price' => 25.99,
                'condition' => 'good',
                'listing_type' => 'both',
                'category' => 'Fantasy',
                'publication_year' => 1954,
                'language' => 'english',
                'user_id' => $buyer->id,
                'status' => 'available',
            ],
        ];

        foreach ($buyerBooks as $bookData) {
            Book::create($bookData);
        }
    }
}
