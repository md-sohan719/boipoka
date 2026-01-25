<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Book') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('books.update', $book) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Title *</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Author -->
                        <div class="mb-4">
                            <label for="author" class="block text-sm font-medium text-gray-700">Author *</label>
                            <input type="text" name="author" id="author"
                                value="{{ old('author', $book->author) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('author')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description
                                *</label>
                            <textarea name="description" id="description" rows="4" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $book->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <!-- Price -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Price ($)
                                    *</label>
                                <input type="number" name="price" id="price" step="0.01" min="0"
                                    value="{{ old('price', $book->price) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- ISBN -->
                            <div>
                                <label for="isbn" class="block text-sm font-medium text-gray-700">ISBN</label>
                                <input type="text" name="isbn" id="isbn"
                                    value="{{ old('isbn', $book->isbn) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('isbn')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <!-- Condition -->
                            <div>
                                <label for="condition" class="block text-sm font-medium text-gray-700">Condition
                                    *</label>
                                <select name="condition" id="condition" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select Condition</option>
                                    <option value="new"
                                        {{ old('condition', $book->condition) === 'new' ? 'selected' : '' }}>New
                                    </option>
                                    <option value="like_new"
                                        {{ old('condition', $book->condition) === 'like_new' ? 'selected' : '' }}>Like
                                        New</option>
                                    <option value="very_good"
                                        {{ old('condition', $book->condition) === 'very_good' ? 'selected' : '' }}>Very
                                        Good</option>
                                    <option value="good"
                                        {{ old('condition', $book->condition) === 'good' ? 'selected' : '' }}>Good
                                    </option>
                                    <option value="acceptable"
                                        {{ old('condition', $book->condition) === 'acceptable' ? 'selected' : '' }}>
                                        Acceptable</option>
                                </select>
                                @error('condition')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Listing Type -->
                            <div>
                                <label for="listing_type" class="block text-sm font-medium text-gray-700">Listing Type
                                    *</label>
                                <select name="listing_type" id="listing_type" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select Type</option>
                                    <option value="sell"
                                        {{ old('listing_type', $book->listing_type) === 'sell' ? 'selected' : '' }}>For
                                        Sale Only</option>
                                    <option value="exchange"
                                        {{ old('listing_type', $book->listing_type) === 'exchange' ? 'selected' : '' }}>
                                        For Exchange Only</option>
                                    <option value="both"
                                        {{ old('listing_type', $book->listing_type) === 'both' ? 'selected' : '' }}>
                                        Both</option>
                                </select>
                                @error('listing_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                <input type="text" name="category" id="category"
                                    value="{{ old('category', $book->category) }}"
                                    placeholder="e.g., Fiction, Science, History"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('category')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Publication Year -->
                            <div>
                                <label for="publication_year"
                                    class="block text-sm font-medium text-gray-700">Publication Year</label>
                                <input type="number" name="publication_year" id="publication_year" min="1000"
                                    max="{{ date('Y') }}"
                                    value="{{ old('publication_year', $book->publication_year) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('publication_year')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Language -->
                        <div class="mb-4">
                            <label for="language" class="block text-sm font-medium text-gray-700">Language *</label>
                            <input type="text" name="language" id="language"
                                value="{{ old('language', $book->language) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('language')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                            <select name="status" id="status" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="available"
                                    {{ old('status', $book->status) === 'available' ? 'selected' : '' }}>Available
                                </option>
                                <option value="sold"
                                    {{ old('status', $book->status) === 'sold' ? 'selected' : '' }}>Sold</option>
                                <option value="exchanged"
                                    {{ old('status', $book->status) === 'exchanged' ? 'selected' : '' }}>Exchanged
                                </option>
                                <option value="reserved"
                                    {{ old('status', $book->status) === 'reserved' ? 'selected' : '' }}>Reserved
                                </option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Image -->
                        @if ($book->image)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                                <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                                    class="w-48 h-auto rounded shadow">
                            </div>
                        @endif

                        <!-- Image -->
                        <div class="mb-6">
                            <label for="image" class="block text-sm font-medium text-gray-700">New Book Image
                                (optional)</label>
                            <input type="file" name="image" id="image" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-md file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-blue-50 file:text-blue-700
                                          hover:file:bg-blue-100">
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('books.show', $book) }}"
                                class="text-gray-600 hover:text-gray-800">Cancel</a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                                Update Book
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
