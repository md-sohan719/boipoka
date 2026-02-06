<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Boipoka') }} - Book Exchange Platform</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-800">Boipoka</span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('books.index') }}" class="text-gray-600 hover:text-indigo-600 font-medium">Browse
                        Books</a>
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="text-gray-600 hover:text-indigo-600 font-medium">Dashboard</a>
                        <a href="{{ route('books.my-books') }}" class="text-gray-600 hover:text-indigo-600 font-medium">My
                            Books</a>
                        <a href="{{ route('books.create') }}"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 font-medium">Add
                            Book</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 font-medium">Login</a>
                        <a href="{{ route('register') }}"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 font-medium">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-5xl md:text-6xl font-bold mb-6">
                    Welcome to Boipoka
                </h1>
                <p class="text-xl md:text-2xl mb-10 text-indigo-100">
                    Your trusted platform to buy, sell, and exchange books with fellow readers
                </p>

                <!-- Search Bar -->
                <div class="max-w-2xl mx-auto mb-8">
                    <form action="{{ route('books.index') }}" method="GET" class="relative">
                        <input type="text" name="search" placeholder="Search for books, authors, ISBN..."
                            class="w-full px-6 py-4 pr-32 rounded-full text-gray-900 text-lg focus:outline-none focus:ring-4 focus:ring-white/30 shadow-xl">
                        <button type="submit"
                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-2 rounded-full font-semibold transition">
                            Search
                        </button>
                    </form>
                </div>

                <!-- Quick Stats -->
                <div class="flex justify-center gap-8 flex-wrap text-sm">
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg px-6 py-3">
                        <div class="text-2xl font-bold">1000+</div>
                        <div class="text-indigo-100">Books Listed</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg px-6 py-3">
                        <div class="text-2xl font-bold">500+</div>
                        <div class="text-indigo-100">Active Users</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg px-6 py-3">
                        <div class="text-2xl font-bold">200+</div>
                        <div class="text-indigo-100">Exchanges Made</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8">
        <div class="grid md:grid-cols-3 gap-6">
            <a href="{{ route('books.index', ['type' => 'sell']) }}"
                class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all p-8 transform hover:-translate-y-1">
                <div
                    class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center mb-4 group-hover:bg-blue-200 transition">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Buy Books</h3>
                <p class="text-gray-600">Find great deals on books from other readers</p>
            </a>

            <a href="{{ route('books.index', ['type' => 'exchange']) }}"
                class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all p-8 transform hover:-translate-y-1">
                <div
                    class="w-14 h-14 bg-purple-100 rounded-lg flex items-center justify-center mb-4 group-hover:bg-purple-200 transition">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Exchange Books</h3>
                <p class="text-gray-600">Trade books with other members and discover new reads</p>
            </a>

            <a href="{{ auth()->check() ? route('books.create') : route('register') }}"
                class="group bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl shadow-lg hover:shadow-2xl transition-all p-8 transform hover:-translate-y-1 text-white">
                <div
                    class="w-14 h-14 bg-white/20 rounded-lg flex items-center justify-center mb-4 group-hover:bg-white/30 transition">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Sell Your Books</h3>
                <p class="text-indigo-100">List your books and start selling today</p>
            </a>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Browse by Category</h2>
            <p class="text-xl text-gray-600">Find your next favorite book</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @forelse($categories as $category)
                <a href="{{ route('books.index', ['category_id' => $category->id]) }}"
                    class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all p-6 text-center">
                    <div class="text-5xl mb-3">{{ $category->icon ?? '📚' }}</div>
                    <h3 class="font-semibold text-gray-900 group-hover:text-indigo-600 transition">
                        {{ $category->name }}</h3>
                </a>
            @empty
                <div class="col-span-full text-center text-gray-500 py-8">
                    <p>No categories available at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Why Choose Boipoka?</h2>
                <p class="text-xl text-gray-600">The best platform for book enthusiasts</p>
            </div>

            <div class="grid md:grid-cols-3 gap-12">
                <div class="text-center">
                    <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Safe & Secure</h3>
                    <p class="text-gray-600">Your transactions are protected with our secure platform</p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Fast & Easy</h3>
                    <p class="text-gray-600">List your books in minutes and start trading immediately</p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Community</h3>
                    <p class="text-gray-600">Join a vibrant community of passionate readers</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center max-w-3xl mx-auto">
                <h2 class="text-4xl font-bold mb-6">Ready to Start Your Book Journey?</h2>
                <p class="text-xl text-indigo-100 mb-10">Join thousands of book lovers on Boipoka today</p>
                @guest
                    <div class="flex justify-center gap-4 flex-wrap">
                        <a href="{{ route('register') }}"
                            class="bg-white text-indigo-600 hover:bg-gray-100 px-8 py-4 rounded-full font-bold text-lg inline-flex items-center transition">
                            Create Free Account
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                        <a href="{{ route('books.index') }}"
                            class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-indigo-600 px-8 py-4 rounded-full font-bold text-lg inline-flex items-center transition">
                            Browse Books
                        </a>
                    </div>
                @else
                    <a href="{{ route('books.create') }}"
                        class="bg-white text-indigo-600 hover:bg-gray-100 px-8 py-4 rounded-full font-bold text-lg inline-flex items-center transition">
                        List Your First Book
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </a>
                @endguest
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold">Boipoka</span>
                    </div>
                    <p class="text-gray-400">Your trusted book exchange platform</p>
                </div>

                <div>
                    <h3 class="font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('books.index') }}" class="hover:text-white">Browse Books</a></li>
                        <li><a href="{{ route('books.index', ['type' => 'sell']) }}" class="hover:text-white">Buy
                                Books</a></li>
                        <li><a href="{{ route('books.index', ['type' => 'exchange']) }}"
                                class="hover:text-white">Exchange Books</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold mb-4">Account</h3>
                    <ul class="space-y-2 text-gray-400">
                        @auth
                            <li><a href="{{ route('dashboard') }}" class="hover:text-white">Dashboard</a></li>
                            <li><a href="{{ route('books.my-books') }}" class="hover:text-white">My Books</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="hover:text-white">Login</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-white">Register</a></li>
                        @endauth
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold mb-4">Support</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white">About Us</a></li>
                        <li><a href="#" class="hover:text-white">Contact</a></li>
                        <li><a href="#" class="hover:text-white">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white">Terms of Service</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Boipoka. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>
