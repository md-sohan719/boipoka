@extends('layouts.frontend')

@section('title', 'Browse Books')

@section('content')
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Discover Your Next Favorite Book</h1>
                <p class="text-xl text-indigo-100 mb-8">Browse thousands of books from readers across the country</p>

                <!-- Search Bar -->
                <form action="{{ route('books.index') }}" method="GET" class="max-w-2xl mx-auto">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search for books, authors, ISBN..."
                            class="w-full px-6 py-4 pr-32 rounded-full text-gray-900 text-lg focus:outline-none focus:ring-4 focus:ring-white/30 shadow-xl">
                        <button type="submit"
                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-2 rounded-full font-semibold transition">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-wrap items-center gap-4">
                <span class="font-semibold text-gray-700">Filter by:</span>

                <!-- Type Filter -->
                <div class="flex gap-2">
                    <a href="{{ route('books.index') }}"
                        class="px-4 py-2 rounded-lg {{ !request('type') ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition">
                        All Books
                    </a>
                    <a href="{{ route('books.index', ['type' => 'sell']) }}"
                        class="px-4 py-2 rounded-lg {{ request('type') === 'sell' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition">
                        For Sale
                    </a>
                    <a href="{{ route('books.index', ['type' => 'exchange']) }}"
                        class="px-4 py-2 rounded-lg {{ request('type') === 'exchange' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition">
                        For Exchange
                    </a>
                </div>

                @if (request('category') || request('type') || request('search'))
                    <a href="{{ route('books.index') }}" class="text-red-600 hover:text-red-700 font-medium ml-auto">
                        Clear Filters
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    @if ($categories->isNotEmpty())
        <div class="bg-gray-50 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Browse by Category</h2>
                <div class="flex flex-wrap gap-3">
                    @foreach ($categories as $cat)
                        <a href="{{ route('books.index', ['category_id' => $cat->id]) }}"
                            class="px-5 py-2 rounded-full {{ request('category_id') == $cat->id ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-indigo-50' }} shadow-sm hover:shadow transition">
                            @if ($cat->icon)
                                <span class="mr-1">{{ $cat->icon }}</span>
                            @endif{{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Books Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    @if (request('category_id'))
                        @php
                            $selectedCategory = $categories->firstWhere('id', request('category_id'));
                        @endphp
                        {{ $selectedCategory ? $selectedCategory->name : 'Category' }} Books
                    @elseif (request('category'))
                        {{ request('category') }} Books
                    @elseif(request('type') === 'sell')
                        Books for Sale
                    @elseif(request('type') === 'exchange')
                        Books for Exchange
                    @elseif(request('search'))
                        Search Results for "{{ request('search') }}"
                    @else
                        All Books
                    @endif
                </h2>
                <p class="text-gray-600 mt-1">{{ $books->total() }} books found</p>
            </div>
        </div>

        @if ($books->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @foreach ($books as $book)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-all overflow-hidden group">
                        <a href="{{ route('books.show', $book) }}" class="block">
                            <div class="relative overflow-hidden">
                                @if ($book->image)
                                    <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                                        class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div
                                        class="w-full h-64 bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                                        <svg class="w-20 h-20 text-indigo-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                        </svg>
                                    </div>
                                @endif

                                <!-- Badges -->
                                <div class="absolute top-2 left-2 flex flex-col gap-2">
                                    @if ($book->listing_type === 'exchange')
                                        <span
                                            class="bg-purple-600 text-white text-xs px-2 py-1 rounded-full font-semibold">Exchange</span>
                                    @elseif($book->listing_type === 'sell')
                                        <span
                                            class="bg-green-600 text-white text-xs px-2 py-1 rounded-full font-semibold">For
                                            Sale</span>
                                    @else
                                        <span
                                            class="bg-blue-600 text-white text-xs px-2 py-1 rounded-full font-semibold">Both</span>
                                    @endif

                                    @if ($book->condition === 'new' || $book->condition === 'like_new')
                                        <span
                                            class="bg-yellow-400 text-gray-900 text-xs px-2 py-1 rounded-full font-semibold">Like
                                            New</span>
                                    @endif
                                </div>
                            </div>

                            <div class="p-4">
                                <h3
                                    class="font-semibold text-gray-900 line-clamp-2 mb-1 group-hover:text-indigo-600 transition">
                                    {{ $book->title }}
                                </h3>
                                <p class="text-sm text-gray-600 mb-3">{{ $book->author }}</p>

                                <div class="flex items-center justify-between">
                                    <span
                                        class="text-lg font-bold text-indigo-600">${{ number_format($book->price, 2) }}</span>
                                    @if ($book->user)
                                        <span class="text-xs text-gray-500">by {{ $book->user->name }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $books->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No books found</h3>
                <p class="text-gray-600 mb-6">Try adjusting your search or filters</p>
                <a href="{{ route('books.index') }}"
                    class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 inline-block">
                    Browse All Books
                </a>
            </div>
        @endif
    </div>

    <!-- Featured Categories Section (if on main page) -->
    @if (
        !request()->has('search') &&
            !request()->has('type') &&
            !request()->has('category') &&
            !request()->has('category_id') &&
            isset($categoryBooks) &&
            count($categoryBooks) > 0)
        <div class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @foreach ($categoryBooks as $catId => $data)
                    @if ($data['books']->count() > 0)
                        <div class="mb-12">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-3xl font-bold text-gray-900">
                                    @if ($data['category']->icon)
                                        <span class="mr-2">{{ $data['category']->icon }}</span>
                                    @endif{{ $data['category']->name }}
                                </h2>
                                <a href="{{ route('books.index', ['category_id' => $data['category']->id]) }}"
                                    class="text-indigo-600 hover:text-indigo-700 font-medium">
                                    View All →
                                </a>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                                @foreach ($data['books']->take(6) as $book)
                                    <a href="{{ route('books.show', $book) }}"
                                        class="bg-white rounded-lg shadow-sm hover:shadow-md transition overflow-hidden group">
                                        @if ($book->image)
                                            <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                                                class="w-full h-48 object-cover group-hover:opacity-90 transition">
                                        @else
                                            <div
                                                class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-300" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="p-3">
                                            <h3
                                                class="font-semibold text-sm text-gray-900 line-clamp-2 group-hover:text-indigo-600">
                                                {{ $book->title }}
                                            </h3>
                                            <p class="text-xs text-gray-600 mt-1">{{ $book->author }}</p>
                                            <p class="text-indigo-600 font-bold mt-2">${{ number_format($book->price, 2) }}
                                            </p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endif
@endsection
