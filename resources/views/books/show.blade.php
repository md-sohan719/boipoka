@extends('layouts.frontend')

@section('title', $book->title)

@section('content')
    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-8 text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-indigo-600">Home</a>
                <span class="mx-2 text-gray-400">/</span>
                <a href="{{ route('books.index') }}" class="text-gray-500 hover:text-indigo-600">Books</a>
                @if ($book->category)
                    <span class="mx-2 text-gray-400">/</span>
                    <a href="{{ route('books.index', ['category' => $book->category]) }}"
                        class="text-gray-500 hover:text-indigo-600">{{ $book->category }}</a>
                @endif
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-gray-900">{{ Str::limit($book->title, 50) }}</span>
            </nav>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded mb-6">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="grid md:grid-cols-2 gap-12">
                <!-- Left Column - Image -->
                <div>
                    <div class="sticky top-24">
                        @if ($book->image)
                            <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                                class="w-full rounded-2xl shadow-2xl">
                        @else
                            <div
                                class="w-full aspect-[3/4] bg-gradient-to-br from-indigo-100 to-purple-100 rounded-2xl flex items-center justify-center shadow-2xl">
                                <svg class="w-32 h-32 text-indigo-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                </svg>
                            </div>
                        @endif

                        @auth
                            @if (auth()->id() === $book->user_id)
                                <div class="mt-6 flex gap-3">
                                    <a href="{{ route('books.edit', $book) }}"
                                        class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white text-center font-semibold py-3 rounded-lg transition">
                                        Edit Book
                                    </a>
                                    <form method="POST" action="{{ route('books.destroy', $book) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this book?');" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-lg transition">
                                            Delete Book
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>

                <!-- Right Column - Details -->
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-3">{{ $book->title }}</h1>
                    <p class="text-xl text-gray-600 mb-6">by {{ $book->author }}</p>

                    <!-- Price and Status -->
                    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-6 mb-6">
                        <div class="flex items-baseline gap-3 mb-4">
                            <span class="text-5xl font-bold text-indigo-600">${{ number_format($book->price, 2) }}</span>
                            <div class="flex gap-2">
                                @if ($book->listing_type === 'sell')
                                    <span
                                        class="bg-green-500 text-white text-sm px-3 py-1 rounded-full font-semibold">Sell</span>
                                @elseif($book->listing_type === 'exchange')
                                    <span
                                        class="bg-purple-500 text-white text-sm px-3 py-1 rounded-full font-semibold">Exchange</span>
                                @else
                                    <span
                                        class="bg-blue-500 text-white text-sm px-3 py-1 rounded-full font-semibold">Both</span>
                                @endif

                                @if ($book->status === 'available')
                                    <span
                                        class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full font-semibold">Available</span>
                                @else
                                    <span
                                        class="bg-gray-100 text-gray-800 text-sm px-3 py-1 rounded-full font-semibold">{{ ucfirst($book->status) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Book Information -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6 mb-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Book Information</h2>
                        <dl class="space-y-3">
                            <div class="flex border-b border-gray-100 pb-3">
                                <dt class="font-semibold text-gray-700 w-32">Condition:</dt>
                                <dd class="text-gray-900">{{ ucfirst(str_replace('_', ' ', $book->condition)) }}</dd>
                            </div>
                            @if ($book->isbn)
                                <div class="flex border-b border-gray-100 pb-3">
                                    <dt class="font-semibold text-gray-700 w-32">ISBN:</dt>
                                    <dd class="text-gray-900">{{ $book->isbn }}</dd>
                                </div>
                            @endif
                            @if ($book->category)
                                <div class="flex border-b border-gray-100 pb-3">
                                    <dt class="font-semibold text-gray-700 w-32">Category:</dt>
                                    <dd>
                                        <a href="{{ route('books.index', ['category' => $book->category]) }}"
                                            class="text-indigo-600 hover:text-indigo-700 font-medium">
                                            {{ $book->category }}
                                        </a>
                                    </dd>
                                </div>
                            @endif
                            @if ($book->publication_year)
                                <div class="flex border-b border-gray-100 pb-3">
                                    <dt class="font-semibold text-gray-700 w-32">Published:</dt>
                                    <dd class="text-gray-900">{{ $book->publication_year }}</dd>
                                </div>
                            @endif
                            <div class="flex border-b border-gray-100 pb-3">
                                <dt class="font-semibold text-gray-700 w-32">Language:</dt>
                                <dd class="text-gray-900">{{ ucfirst($book->language) }}</dd>
                            </div>
                            <div class="flex">
                                <dt class="font-semibold text-gray-700 w-32">Seller:</dt>
                                <dd class="text-gray-900">{{ $book->user->name }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Description</h2>
                        <p class="text-gray-700 leading-relaxed text-lg">{{ $book->description }}</p>
                    </div>

                    <!-- Action Buttons -->
                    @auth
                        @if (auth()->id() !== $book->user_id && $book->status === 'available')
                            <div
                                class="sticky bottom-0 bg-white border-t-4 border-gray-100 pt-6 -mx-4 px-4 md:mx-0 md:px-0 md:border-0">
                                <div class="flex flex-col sm:flex-row gap-4">
                                    @if (in_array($book->listing_type, ['sell', 'both']))
                                        <button
                                            class="flex-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            Buy Now
                                        </button>
                                    @endif

                                    @if (in_array($book->listing_type, ['exchange', 'both']))
                                        <a href="{{ route('exchanges.create', $book) }}"
                                            class="flex-1 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-bold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                            </svg>
                                            Propose Exchange
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @elseif(auth()->id() !== $book->user_id && $book->status !== 'available')
                            <div class="bg-gray-100 rounded-xl p-6 text-center">
                                <p class="text-gray-700 font-medium">This book is currently not available</p>
                            </div>
                        @endif
                    @else
                        <div
                            class="bg-gradient-to-r from-indigo-50 to-purple-50 border-2 border-indigo-200 rounded-xl p-6 text-center">
                            <p class="text-gray-800 text-lg mb-4">
                                <svg class="w-12 h-12 text-indigo-600 mx-auto mb-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Please log in to buy or exchange this book
                            </p>
                            <div class="flex gap-3 justify-center">
                                <a href="{{ route('login') }}"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-lg transition">
                                    Log In
                                </a>
                                <a href="{{ route('register') }}"
                                    class="bg-white hover:bg-gray-50 text-indigo-600 border-2 border-indigo-600 font-semibold py-3 px-8 rounded-lg transition">
                                    Sign Up
                                </a>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Related Books Section -->
    @if ($book->category)
        <div class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">More {{ $book->category }} Books</h2>
                    <a href="{{ route('books.index', ['category' => $book->category]) }}"
                        class="text-indigo-600 hover:text-indigo-700 font-medium">
                        View All →
                    </a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                    @php
                        $relatedBooks = \App\Models\Book::where('category', $book->category)
                            ->where('id', '!=', $book->id)
                            ->where('status', 'available')
                            ->with('user')
                            ->latest()
                            ->take(5)
                            ->get();
                    @endphp

                    @foreach ($relatedBooks as $relatedBook)
                        <a href="{{ route('books.show', $relatedBook) }}"
                            class="bg-white rounded-lg shadow-sm hover:shadow-lg transition overflow-hidden group">
                            @if ($relatedBook->image)
                                <img src="{{ asset('storage/' . $relatedBook->image) }}" alt="{{ $relatedBook->title }}"
                                    class="w-full h-64 object-cover group-hover:opacity-90 transition">
                            @else
                                <div
                                    class="w-full h-64 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="p-4">
                                <h3
                                    class="font-semibold text-gray-900 line-clamp-2 group-hover:text-indigo-600 transition">
                                    {{ $relatedBook->title }}
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">{{ $relatedBook->author }}</p>
                                <p class="text-indigo-600 font-bold mt-2">${{ number_format($relatedBook->price, 2) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
