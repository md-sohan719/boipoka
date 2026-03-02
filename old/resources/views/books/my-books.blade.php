<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Books') }}
            </h2>
            <a href="{{ route('books.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                List New Book
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($books as $book)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                        <a href="{{ route('books.show', $book) }}">
                            @if ($book->image)
                                <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                                    class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                    </svg>
                                </div>
                            @endif

                            <div class="p-4">
                                <h3 class="font-bold text-lg mb-1 truncate">{{ $book->title }}</h3>
                                <p class="text-gray-600 text-sm mb-2">by {{ $book->author }}</p>
                                <div class="flex items-center justify-between">
                                    <span
                                        class="text-blue-600 font-bold text-xl">${{ number_format($book->price, 2) }}</span>
                                    <span
                                        class="text-xs px-2 py-1 rounded
                                        {{ $book->status === 'available'
                                            ? 'bg-green-100 text-green-800'
                                            : ($book->status === 'sold'
                                                ? 'bg-red-100 text-red-800'
                                                : ($book->status === 'exchanged'
                                                    ? 'bg-purple-100 text-purple-800'
                                                    : 'bg-yellow-100 text-yellow-800')) }}">
                                        {{ ucfirst($book->status) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">
                                    Listed {{ $book->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg mb-4">You haven't listed any books yet.</p>
                        <a href="{{ route('books.create') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                            List Your First Book
                        </a>
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
