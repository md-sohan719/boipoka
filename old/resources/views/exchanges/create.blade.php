<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Propose Book Exchange') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Exchange Request</h3>

                    <form method="POST" action="{{ route('exchanges.store') }}">
                        @csrf
                        <input type="hidden" name="owner_book_id" value="{{ $book->id }}">

                        <div class="grid md:grid-cols-2 gap-6 mb-6">
                            <!-- Book they want -->
                            <div>
                                <h4 class="font-semibold mb-3 text-gray-700">Book You Want:</h4>
                                <div class="border-2 border-blue-500 rounded-lg p-4 bg-blue-50">
                                    @if ($book->image)
                                        <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                                            class="w-full h-48 object-cover rounded mb-3">
                                    @endif
                                    <p class="font-bold text-lg">{{ $book->title }}</p>
                                    <p class="text-gray-600">by {{ $book->author }}</p>
                                    <p class="text-sm text-gray-600 mt-2">
                                        Condition: {{ ucfirst(str_replace('_', ' ', $book->condition)) }}
                                    </p>
                                    <p class="text-sm text-gray-600">Owner: {{ $book->user->name }}</p>
                                </div>
                            </div>

                            <!-- Book to offer -->
                            <div>
                                <h4 class="font-semibold mb-3 text-gray-700">Select Your Book to Offer:</h4>

                                @if ($myBooks->count() > 0)
                                    <div class="space-y-3">
                                        @foreach ($myBooks as $myBook)
                                            <label class="block">
                                                <input type="radio" name="requester_book_id"
                                                    value="{{ $myBook->id }}" class="mr-2" required>
                                                <div
                                                    class="inline-block border rounded-lg p-3 hover:bg-gray-50 cursor-pointer w-full">
                                                    <p class="font-semibold">{{ $myBook->title }}</p>
                                                    <p class="text-sm text-gray-600">by {{ $myBook->author }}</p>
                                                    <p class="text-sm text-gray-600">
                                                        Condition:
                                                        {{ ucfirst(str_replace('_', ' ', $myBook->condition)) }}
                                                    </p>
                                                    <p class="text-sm text-blue-600">
                                                        ${{ number_format($myBook->price, 2) }}</p>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                                        <p class="text-gray-600 mb-3">You don't have any books available for exchange.
                                        </p>
                                        <a href="{{ route('books.create') }}"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block">
                                            List a Book
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if ($myBooks->count() > 0)
                            <!-- Message -->
                            <div class="mb-6">
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                    Message to Owner (Optional)
                                </label>
                                <textarea name="message" id="message" rows="4" placeholder="Add a personal message to the book owner..."
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('books.show', $book) }}" class="text-gray-600 hover:text-gray-800">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-6 rounded">
                                    Send Exchange Request
                                </button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
