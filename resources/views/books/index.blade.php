<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Browse Books') }}
            </h2>
            @auth
                <a href="{{ route('books.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    List a Book
                </a>
                <x-app-layout>
                    <x-slot name="header">
                        <div class="flex justify-between items-center">
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                {{ __('Boipoka — Books Marketplace') }}
                            </h2>
                            @auth
                                <a href="{{ route('books.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    List a Book
                                </a>
                            @endauth
                        </div>
                    </x-slot>

                    <!-- Hero -->
                    <div class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white">
                        <div class="max-w-7xl mx-auto py-20 px-4 sm:px-6 lg:px-8">
                            <div class="lg:flex lg:items-center lg:justify-between">
                                <div class="lg:w-1/2">
                                    <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl">Buy, Sell & Exchange
                                        Books</h1>
                                    <p class="mt-4 text-lg text-indigo-100">Discover secondhand treasures, sell books you no
                                        longer need, or swap with other readers.</p>

                                    <form method="GET" action="{{ route('books.index') }}" class="mt-6 flex">
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            placeholder="Search by title, author, ISBN..."
                                            class="w-full rounded-l-md px-4 py-3 text-gray-800" />
                                        <button type="submit"
                                            class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 rounded-r-md">Search</button>
                                    </form>
                                </div>

                                <div class="hidden lg:block lg:w-1/2">
                                    <div class="grid grid-cols-2 gap-4">
                                        @foreach ($featured as $f)
                                            <a href="{{ route('books.show', $f) }}"
                                                class="block bg-white rounded-lg overflow-hidden shadow-lg text-gray-800">
                                                @if ($f->image)
                                                    <img src="{{ asset('storage/' . $f->image) }}" alt="{{ $f->title }}"
                                                        class="w-full h-40 object-cover">
                                                @else
                                                    <div class="w-full h-40 bg-gray-200"></div>
                                                @endif
                                                <div class="p-3">
                                                    <div class="font-semibold">{{ Str::limit($f->title, 40) }}</div>
                                                    <div class="text-sm text-gray-600">{{ $f->author }}</div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                            <!-- Categories -->
                            <div class="mb-8">
                                <h3 class="text-2xl font-semibold mb-4">Categories</h3>
                                <div class="flex flex-wrap gap-3">
                                    @foreach ($categories as $cat)
                                        <a href="{{ route('books.index', ['category' => $cat]) }}"
                                            class="px-4 py-2 rounded-md bg-gray-100 hover:bg-gray-200 text-sm">{{ $cat }}</a>
                                    @endforeach
                                </div>
                            </div>

                            @if (session('success'))
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <!-- Books Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @forelse($books as $book)
                                    <div
                                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                                        <a href="{{ route('books.show', $book) }}">
                                            @if ($book->image)
                                                <img src="{{ asset('storage/' . $book->image) }}"
                                                    alt="{{ $book->title }}" class="w-full h-56 object-cover">
                                            @else
                                                <div class="w-full h-56 bg-gray-200 flex items-center justify-center">
                                                </div>
                                            @endif
                                            <div class="p-4">
                                                <h3 class="font-bold text-lg mb-1 truncate">{{ $book->title }}</h3>
                                                <p class="text-gray-600 text-sm mb-2">by {{ $book->author }}</p>
                                                <div class="flex items-center justify-between">
                                                    <span
                                                        class="text-blue-600 font-bold text-lg">${{ number_format($book->price, 2) }}</span>
                                                    <span
                                                        class="text-xs px-2 py-1 rounded
                                                    {{ $book->listing_type === 'sell'
                                                        ? 'bg-green-100 text-green-800'
                                                        : ($book->listing_type === 'exchange'
                                                            ? 'bg-purple-100 text-purple-800'
                                                            : 'bg-blue-100 text-blue-800') }}">
                                                        {{ ucfirst($book->listing_type) }}
                                                    </span>
                                                </div>
                                                <p class="text-xs text-gray-500 mt-2">Condition:
                                                    {{ ucfirst(str_replace('_', ' ', $book->condition)) }}</p>
                                            </div>
                                        </a>
                                    </div>
                                @empty
                                    <div class="col-span-full text-center py-12">
                                        <p class="text-gray-500 text-lg">No books found. Be the first to list a book!</p>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Pagination -->
                            <div class="mt-6">
                                {{ $books->links() }}
                            </div>
                        </div>
                    </div>
                </x-app-layout>
