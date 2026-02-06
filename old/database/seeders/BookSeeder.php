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
            // Fiction
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

            // Romance
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
                'title' => 'The Notebook',
                'author' => 'Nicholas Sparks',
                'description' => 'A timeless love story of Noah and Allie, spanning over five decades.',
                'isbn' => '9780446605236',
                'price' => 9.99,
                'condition' => 'good',
                'listing_type' => 'sell',
                'category' => 'Romance',
                'publication_year' => 1996,
                'language' => 'english',
            ],

            // Fantasy
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
            [
                'title' => 'The Hobbit',
                'author' => 'J.R.R. Tolkien',
                'description' => 'A fantasy novel about the quest of home-loving Bilbo Baggins to win a share of the treasure guarded by a dragon.',
                'isbn' => '9780547928227',
                'price' => 14.99,
                'condition' => 'very_good',
                'listing_type' => 'both',
                'category' => 'Fantasy',
                'publication_year' => 1937,
                'language' => 'english',
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
            ],

            // Mystery & Thriller
            [
                'title' => 'The Da Vinci Code',
                'author' => 'Dan Brown',
                'description' => 'A mystery thriller novel following symbologist Robert Langdon on a quest to solve a murder.',
                'isbn' => '9780307474278',
                'price' => 16.99,
                'condition' => 'like_new',
                'listing_type' => 'sell',
                'category' => 'Mystery',
                'publication_year' => 2003,
                'language' => 'english',
            ],
            [
                'title' => 'Gone Girl',
                'author' => 'Gillian Flynn',
                'description' => 'A psychological thriller about a woman who disappears on her fifth wedding anniversary.',
                'isbn' => '9780307588371',
                'price' => 13.99,
                'condition' => 'very_good',
                'listing_type' => 'sell',
                'category' => 'Mystery',
                'publication_year' => 2012,
                'language' => 'english',
            ],
            [
                'title' => 'Sherlock Holmes: Complete Collection',
                'author' => 'Arthur Conan Doyle',
                'description' => 'The complete collection of Sherlock Holmes stories featuring the legendary detective.',
                'isbn' => '9781435159549',
                'price' => 18.99,
                'condition' => 'new',
                'listing_type' => 'sell',
                'category' => 'Mystery',
                'publication_year' => 1887,
                'language' => 'english',
            ],

            // Non-Fiction
            [
                'title' => 'Sapiens: A Brief History of Humankind',
                'author' => 'Yuval Noah Harari',
                'description' => 'An exploration of the history of the human species from the Stone Age to the modern age.',
                'isbn' => '9780062316097',
                'price' => 17.99,
                'condition' => 'like_new',
                'listing_type' => 'sell',
                'category' => 'Non-Fiction',
                'publication_year' => 2011,
                'language' => 'english',
            ],
            [
                'title' => 'Educated',
                'author' => 'Tara Westover',
                'description' => 'A memoir about a young woman who leaves her survivalist family and goes on to earn a PhD from Cambridge University.',
                'isbn' => '9780399590504',
                'price' => 15.99,
                'condition' => 'very_good',
                'listing_type' => 'sell',
                'category' => 'Non-Fiction',
                'publication_year' => 2018,
                'language' => 'english',
            ],

            // Self-Help
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'description' => 'A practical guide to breaking bad habits and building good ones through small changes.',
                'isbn' => '9780735211292',
                'price' => 19.99,
                'condition' => 'new',
                'listing_type' => 'sell',
                'category' => 'Self-Help',
                'publication_year' => 2018,
                'language' => 'english',
            ],
            [
                'title' => 'The 7 Habits of Highly Effective People',
                'author' => 'Stephen R. Covey',
                'description' => 'A self-improvement book outlining seven key principles for personal and professional effectiveness.',
                'isbn' => '9781451639619',
                'price' => 14.99,
                'condition' => 'good',
                'listing_type' => 'sell',
                'category' => 'Self-Help',
                'publication_year' => 1989,
                'language' => 'english',
            ],

            // Biography
            [
                'title' => 'Steve Jobs',
                'author' => 'Walter Isaacson',
                'description' => 'The authorized biography of Steve Jobs, co-founder of Apple Inc.',
                'isbn' => '9781451648539',
                'price' => 16.99,
                'condition' => 'like_new',
                'listing_type' => 'sell',
                'category' => 'Biography',
                'publication_year' => 2011,
                'language' => 'english',
            ],
            [
                'title' => 'The Diary of a Young Girl',
                'author' => 'Anne Frank',
                'description' => 'The diary of a Jewish girl hiding from the Nazis during World War II.',
                'isbn' => '9780553296983',
                'price' => 11.99,
                'condition' => 'very_good',
                'listing_type' => 'both',
                'category' => 'Biography',
                'publication_year' => 1947,
                'language' => 'english',
            ],

            // Business & Economics
            [
                'title' => 'Think and Grow Rich',
                'author' => 'Napoleon Hill',
                'description' => 'A classic book on wealth creation and success principles.',
                'isbn' => '9781585424337',
                'price' => 12.99,
                'condition' => 'good',
                'listing_type' => 'sell',
                'category' => 'Business',
                'publication_year' => 1937,
                'language' => 'english',
            ],
            [
                'title' => 'Rich Dad Poor Dad',
                'author' => 'Robert Kiyosaki',
                'description' => 'A personal finance book that advocates financial independence through investing and entrepreneurship.',
                'isbn' => '9781612680194',
                'price' => 13.99,
                'condition' => 'like_new',
                'listing_type' => 'sell',
                'category' => 'Business',
                'publication_year' => 1997,
                'language' => 'english',
            ],

            // Children's Books
            [
                'title' => 'The Lion, the Witch and the Wardrobe',
                'author' => 'C.S. Lewis',
                'description' => 'A fantasy novel for children about four siblings who discover a magical wardrobe.',
                'isbn' => '9780064471046',
                'price' => 9.99,
                'condition' => 'very_good',
                'listing_type' => 'both',
                'category' => 'Children',
                'publication_year' => 1950,
                'language' => 'english',
            ],
            [
                'title' => 'Charlotte\'s Web',
                'author' => 'E.B. White',
                'description' => 'A beloved children\'s novel about a pig named Wilbur and his friendship with a spider named Charlotte.',
                'isbn' => '9780064400558',
                'price' => 8.99,
                'condition' => 'good',
                'listing_type' => 'sell',
                'category' => 'Children',
                'publication_year' => 1952,
                'language' => 'english',
            ],

            // Academic
            [
                'title' => 'Introduction to Algorithms',
                'author' => 'Thomas H. Cormen',
                'description' => 'A comprehensive textbook on computer algorithms covering a broad range of topics.',
                'isbn' => '9780262033848',
                'price' => 89.99,
                'condition' => 'like_new',
                'listing_type' => 'sell',
                'category' => 'Academic',
                'publication_year' => 1990,
                'language' => 'english',
            ],
            [
                'title' => 'Campbell Biology',
                'author' => 'Jane B. Reece',
                'description' => 'The leading college biology textbook covering essential concepts in biology.',
                'isbn' => '9780321558237',
                'price' => 79.99,
                'condition' => 'good',
                'listing_type' => 'both',
                'category' => 'Academic',
                'publication_year' => 2008,
                'language' => 'english',
            ],
        ];

        foreach ($books as $bookData) {
            $bookData['user_id'] = $seller->id;
            $bookData['status'] = 'available';
            Book::create($bookData);
        }

        // Create some additional books for the buyer
        $additionalBooks = [
            [
                'title' => 'The Alchemist',
                'author' => 'Paulo Coelho',
                'description' => 'A mystical story about Santiago, an Andalusian shepherd boy who yearns to travel in search of treasure.',
                'isbn' => '9780062315007',
                'price' => 12.99,
                'condition' => 'like_new',
                'listing_type' => 'exchange',
                'category' => 'Fiction',
                'publication_year' => 1988,
                'language' => 'english',
                'user_id' => $buyer->id,
                'status' => 'available',
            ],
            [
                'title' => 'The Kite Runner',
                'author' => 'Khaled Hosseini',
                'description' => 'A powerful story of friendship, betrayal, and redemption set in Afghanistan.',
                'isbn' => '9781594631931',
                'price' => 14.99,
                'condition' => 'very_good',
                'listing_type' => 'both',
                'category' => 'Fiction',
                'publication_year' => 2003,
                'language' => 'english',
                'user_id' => $buyer->id,
                'status' => 'available',
            ],
        ];

        foreach ($additionalBooks as $bookData) {
            Book::create($bookData);
        }
    }
}
