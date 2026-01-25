<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $book->title }}
            </h2>
            @auth
                @if (auth()->id() === $book->user_id)
                    <div class="flex gap-2">
                        <a href="{{ route('books.edit', $book) }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('books.destroy', $book) }}" class="inline"
                            onsubmit="return confirm('Are you sure you want to delete this book?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                                Delete
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Book Image -->
                        <div>
                            @if ($book->image)
                                <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                                    class="w-full rounded-lg shadow-lg">
                            @else
                                <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-32 h-32 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Book Details -->
                        <div>
                            <h1 class="text-3xl font-bold mb-2">{{ $book->title }}</h1>
                            <p class="text-xl text-gray-600 mb-4">by {{ $book->author }}</p>

                            <div class="mb-6">
                                <span
                                    class="text-4xl font-bold text-blue-600">${{ number_format($book->price, 2) }}</span>
                                <span
                                    class="ml-3 px-3 py-1 rounded text-sm font-semibold
                                    {{ $book->listing_type === 'sell'
                                        ? 'bg-green-100 text-green-800'
                                        : ($book->listing_type === 'exchange'
                                            ? 'bg-purple-100 text-purple-800'
                                            : 'bg-blue-100 text-blue-800') }}">
                                    {{ ucfirst($book->listing_type) }}
                                </span>
                                <span
                                    class="ml-2 px-3 py-1 rounded text-sm font-semibold
                                    {{ $book->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($book->status) }}
                                </span>
                            </div>

                            <div class="space-y-3 mb-6">
                                <div class="flex">
                                    <span class="font-semibold w-32">Condition:</span>
                                    <span>{{ ucfirst(str_replace('_', ' ', $book->condition)) }}</span>
                                </div>
                                @if ($book->isbn)
                                    <div class="flex">
                                        <span class="font-semibold w-32">ISBN:</span>
                                        <span>{{ $book->isbn }}</span>
                                    </div>
                                @endif
                                @if ($book->category)
                                    <div class="flex">
                                        <span class="font-semibold w-32">Category:</span>
                                        <span>{{ $book->category }}</span>
                                    </div>
                                @endif
                                @if ($book->publication_year)
                                    <div class="flex">
                                        <span class="font-semibold w-32">Published:</span>
                                        <span>{{ $book->publication_year }}</span>
                                    </div>
                                @endif
                                <div class="flex">
                                    <span class="font-semibold w-32">Language:</span>
                                    <span>{{ ucfirst($book->language) }}</span>
                                </div>
                                <div class="flex">
                                    <span class="font-semibold w-32">Seller:</span>
                                    <span>{{ $book->user->name }}</span>
                                </div>
                            </div>

                            <div class="mb-6">
                                <h3 class="font-semibold text-lg mb-2">Description</h3>
                                <p class="text-gray-700 leading-relaxed">{{ $book->description }}</p>
                            </div>

                            @auth
                                @if (auth()->id() !== $book->user_id && $book->status === 'available')
                                    <div class="flex gap-3">
                                        @if (in_array($book->listing_type, ['sell', 'both']))
                                            <button
                                                class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded">
                                                Buy Now
                                            </button>
                                        @endif

                                        @if (in_array($book->listing_type, ['exchange', 'both']))
                                            <a href="{{ route('exchanges.create', $book) }}"
                                                class="flex-1 bg-purple-500 hover:bg-purple-600 text-white font-bold py-3 px-6 rounded text-center">
                                                Propose Exchange
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            @else
                                <div class="bg-blue-50 border border-blue-200 rounded p-4">
                                    <p class="text-blue-800">
                                        Please <a href="{{ route('login') }}" class="font-semibold underline">log in</a> to
                                        buy or exchange this book.
                                    </p>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
