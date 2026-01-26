<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Boipoka - Buy, Sell & Exchange Books Online</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50">
    <!-- Top Header -->
    <div class="bg-gradient-to-r from-orange-500 to-red-500 text-white text-sm py-2">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex space-x-4">
                <span>📞 +880 123-456-789</span>
                <span>📧 support@boipoka.com</span>
            </div>
            <div class="flex space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
                    <a href="{{ route('books.my-books') }}" class="hover:underline">My Books</a>
                @else
                    <a href="{{ route('login') }}" class="hover:underline">Login</a>
                    <a href="{{ route('register') }}" class="hover:underline">Register</a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between gap-6">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-500 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                        B
                    </div>
                    <span class="text-2xl font-bold text-gray-800">Boipoka</span>
                </a>

                <!-- Search Bar -->
                <form method="GET" action="{{ route('books.index') }}" class="flex-1 max-w-2xl">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search for books, authors, ISBN..."
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-orange-500 focus:outline-none">
                        <button type="submit"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-md font-medium transition">
                            Search
                        </button>
                    </div>
                </form>

                <!-- Right Actions -->
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('books.create') }}"
                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-medium transition">
                            + List Book
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-500 font-medium">Login</a>
                        <a href="{{ route('register') }}"
                            class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-medium transition">
                            Sign Up
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Navigation -->
            <nav class="mt-4 border-t pt-3">
                <ul class="flex space-x-6 text-sm font-medium text-gray-700">
                    <li><a href="{{ route('books.index') }}" class="hover:text-orange-500 transition">All Books</a>
                    </li>
                    @foreach ($categories->take(8) as $cat)
                        <li><a href="{{ route('books.index', ['category' => $cat]) }}"
                                class="hover:text-orange-500 transition">{{ $cat }}</a></li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </header>

    @if (session('success'))
        <div class="container mx-auto px-4 mt-4">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Hero Banner -->
    <section class="bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <h1 class="text-5xl font-bold mb-4">Bangladesh's Largest Online Bookstore</h1>
                    <p class="text-xl mb-6 text-orange-100">Buy, Sell & Exchange Books with Thousands of Readers</p>
                    <div class="flex space-x-4">
                        <a href="{{ route('books.index', ['type' => 'sell']) }}"
                            class="bg-white text-orange-500 px-8 py-3 rounded-lg font-bold hover:bg-gray-100 transition">
                            Buy Books
                        </a>
                        <a href="{{ route('books.create') }}"
                            class="bg-orange-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-orange-700 transition border-2 border-white">
                            Sell Books
                        </a>
                    </div>
                    <div class="mt-8 grid grid-cols-3 gap-4 text-center">
                        <div>
                            <div class="text-3xl font-bold">{{ \App\Models\Book::count() }}+</div>
                            <div class="text-sm text-orange-100">Books Available</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold">{{ \App\Models\User::count() }}+</div>
                            <div class="text-sm text-orange-100">Happy Readers</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold">{{ $categories->count() }}+</div>
                            <div class="text-sm text-orange-100">Categories</div>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="grid grid-cols-2 gap-4">
                        @foreach ($featured->take(4) as $book)
                            <a href="{{ route('books.show', $book) }}"
                                class="bg-white rounded-lg overflow-hidden shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition">
                                @if ($book->image)
                                    <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                                        class="w-full h-48 object-cover">
                                @else
                                    <div
                                        class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="p-3 text-gray-800">
                                    <div class="font-semibold text-sm line-clamp-1">{{ $book->title }}</div>
                                    <div class="text-xs text-gray-600 mt-1">{{ $book->author }}</div>
                                    <div class="text-orange-600 font-bold mt-2">${{ number_format($book->price, 2) }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Categories -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Shop by Category</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach ($categories as $category)
                    <a href="{{ route('books.index', ['category' => $category]) }}"
                        class="bg-gradient-to-br from-orange-50 to-red-50 hover:from-orange-100 hover:to-red-100 rounded-lg p-6 text-center transition transform hover:-translate-y-1 shadow-sm hover:shadow-md">
                        <div class="text-4xl mb-2">📚</div>
                        <div class="font-semibold text-gray-800">{{ $category }}</div>
                        <div class="text-xs text-gray-600 mt-1">
                            {{ \App\Models\Book::where('category', $category)->count() }} books
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Books -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-gray-800">Featured Books</h2>
                <a href="{{ route('books.index') }}" class="text-orange-500 hover:text-orange-600 font-medium">View
                    All →</a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                @foreach ($featured as $book)
                    <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition group">
                        <a href="{{ route('books.show', $book) }}" class="block">
                            @if ($book->image)
                                <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                                    class="w-full h-64 object-cover group-hover:opacity-90 transition">
                            @else
                                <div
                                    class="w-full h-64 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center group-hover:from-gray-200 group-hover:to-gray-300 transition">
                                    <svg class="w-20 h-20 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-800 line-clamp-2 mb-1">{{ $book->title }}</h3>
                                <p class="text-xs text-gray-600 mb-2">{{ $book->author }}</p>
                                <div class="flex items-center justify-between">
                                    <span
                                        class="text-orange-600 font-bold">${{ number_format($book->price, 2) }}</span>
                                    <span
                                        class="text-xs px-2 py-1 rounded {{ $book->listing_type === 'sell' ? 'bg-green-100 text-green-800' : ($book->listing_type === 'exchange' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800') }}">
                                        {{ ucfirst($book->listing_type) }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- New Arrivals -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-gray-800">New Arrivals</h2>
                <a href="{{ route('books.index') }}" class="text-orange-500 hover:text-orange-600 font-medium">View
                    All →</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($books->take(8) as $book)
                    <div
                        class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition group">
                        <a href="{{ route('books.show', $book) }}" class="block">
                            <div class="relative">
                                @if ($book->image)
                                    <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                                        class="w-full h-72 object-cover group-hover:opacity-90 transition">
                                @else
                                    <div
                                        class="w-full h-72 bg-gradient-to-br from-blue-50 to-purple-50 flex items-center justify-center">
                                        <svg class="w-24 h-24 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                        </svg>
                                    </div>
                                @endif
                                <span
                                    class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full font-semibold">NEW</span>
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold text-gray-800 line-clamp-2 mb-1">{{ $book->title }}</h3>
                                <p class="text-sm text-gray-600 mb-2">by {{ $book->author }}</p>
                                <div class="flex items-center justify-between mb-2">
                                    <span
                                        class="text-orange-600 font-bold text-lg">${{ number_format($book->price, 2) }}</span>
                                    <span
                                        class="text-xs px-2 py-1 rounded {{ $book->condition === 'new' || $book->condition === 'like_new' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst(str_replace('_', ' ', $book->condition)) }}
                                    </span>
                                </div>
                                <button
                                    class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-lg font-medium transition">
                                    View Details
                                </button>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Categories Rows (like carousel sections) -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            @foreach ($categoryBooks as $cat => $items)
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-2xl font-bold text-gray-800">{{ $cat }}</h3>
                        <a href="{{ route('books.index', ['category' => $cat]) }}"
                            class="text-orange-500 hover:text-orange-600">See More</a>
                    </div>

                    <div class="overflow-x-auto no-scrollbar -mx-4 px-4">
                        <div class="flex space-x-4">
                            @foreach ($items as $b)
                                <a href="{{ route('books.show', $b) }}"
                                    class="w-40 flex-shrink-0 bg-white rounded-lg shadow-sm hover:shadow-lg transition overflow-hidden">
                                    @if ($b->image)
                                        <img src="{{ asset('storage/' . $b->image) }}" alt="{{ $b->title }}"
                                            class="w-full h-40 object-cover">
                                    @else
                                        <div class="w-full h-40 bg-gray-100 flex items-center justify-center">
                                            <svg class="w-10 h-10 text-gray-300" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="p-3 text-sm text-gray-800">
                                        <div class="font-medium line-clamp-2">{{ Str::limit($b->title, 40) }}</div>
                                        <div class="text-xs text-gray-500">{{ $b->author }}</div>
                                        <div class="text-orange-600 font-bold mt-2">${{ number_format($b->price, 2) }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-16 bg-gradient-to-r from-blue-500 to-purple-600 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-4">Start Your Book Journey Today</h2>
            <p class="text-xl mb-8 text-blue-100">Join thousands of readers buying, selling, and exchanging books</p>
            <div class="flex justify-center space-x-4">
                @auth
                    <a href="{{ route('books.create') }}"
                        class="bg-white text-blue-600 px-8 py-3 rounded-lg font-bold hover:bg-gray-100 transition">
                        List Your Books
                    </a>
                @else
                    <a href="{{ route('register') }}"
                        class="bg-white text-blue-600 px-8 py-3 rounded-lg font-bold hover:bg-gray-100 transition">
                        Create Free Account
                    </a>
                @endauth
                <a href="{{ route('books.index') }}"
                    class="bg-transparent text-white border-2 border-white px-8 py-3 rounded-lg font-bold hover:bg-white hover:text-blue-600 transition">
                    Browse Books
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div
                            class="w-8 h-8 bg-gradient-to-br from-orange-500 to-red-500 rounded-lg flex items-center justify-center font-bold">
                            B
                        </div>
                        <span class="text-xl font-bold">Boipoka</span>
                    </div>
                    <p class="text-gray-400 text-sm">Bangladesh's most trusted online book marketplace. Buy, sell, and
                        exchange books with ease.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('books.index') }}" class="hover:text-white">All Books</a></li>
                        <li><a href="{{ route('books.index', ['type' => 'sell']) }}" class="hover:text-white">Books
                                for
                                Sale</a></li>
                        <li><a href="{{ route('books.index', ['type' => 'exchange']) }}"
                                class="hover:text-white">Books for Exchange</a></li>
                        @auth
                            <li><a href="{{ route('books.create') }}" class="hover:text-white">List a Book</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Support</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white">Help Center</a></li>
                        <li><a href="#" class="hover:text-white">Contact Us</a></li>
                        <li><a href="#" class="hover:text-white">Terms & Conditions</a></li>
                        <li><a href="#" class="hover:text-white">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Contact</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>📞 +880 123-456-789</li>
                        <li>📧 support@boipoka.com</li>
                        <li>📍 Dhaka, Bangladesh</li>
                    </ul>
                    <div class="mt-4 flex space-x-3">
                        <a href="#"
                            class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-orange-500 transition">
                            f
                        </a>
                        <a href="#"
                            class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-orange-500 transition">
                            t
                        </a>
                        <a href="#"
                            class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-orange-500 transition">
                            in
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} Boipoka. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>
