<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div
                class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 rounded-2xl shadow-2xl overflow-hidden mb-8">
                <div class="p-8 md:p-12">
                    <div class="flex items-center justify-between flex-wrap gap-6">
                        <div class="text-white">
                            <h1 class="text-3xl md:text-4xl font-bold mb-2">
                                Welcome back, {{ auth()->user()->name }}! 👋
                            </h1>
                            <p class="text-indigo-100 text-lg">
                                Ready to discover new books or share your collection?
                            </p>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('books.index') }}"
                                class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Browse Books
                            </a>
                            <a href="{{ route('books.create') }}"
                                class="inline-flex items-center px-6 py-3 bg-indigo-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:bg-indigo-900 transform hover:-translate-y-0.5 transition-all">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                List a Book
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Access -->
            @if (auth()->user()->isAdmin())
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-xl overflow-hidden mb-8">
                    <div class="p-6">
                        <div class="flex items-center justify-between flex-wrap gap-4">
                            <div class="flex items-center gap-4">
                                <div class="bg-white bg-opacity-20 rounded-xl p-3">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div class="text-white">
                                    <h3 class="text-xl font-bold">Admin Access</h3>
                                    <p class="text-blue-100 text-sm">You have administrator privileges</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.dashboard') }}"
                                class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Go to Admin Panel
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- My Books -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-indigo-100 rounded-xl p-3">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-gray-600 text-sm font-medium mb-1">My Books</h3>
                    <p class="text-3xl font-bold text-gray-900 mb-2">{{ auth()->user()->books()->count() }}</p>
                    <a href="{{ route('books.my-books') }}"
                        class="text-indigo-600 hover:text-indigo-700 text-sm font-medium inline-flex items-center">
                        View all
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <!-- Active Exchanges -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-purple-100 rounded-xl p-3">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-gray-600 text-sm font-medium mb-1">Active Exchanges</h3>
                    <p class="text-3xl font-bold text-gray-900 mb-2">
                        {{ auth()->user()->sentExchanges()->where('status', 'pending')->count() + auth()->user()->receivedExchanges()->where('status', 'pending')->count() }}
                    </p>
                    <a href="{{ route('exchanges.index') }}"
                        class="text-purple-600 hover:text-purple-700 text-sm font-medium inline-flex items-center">
                        View all
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <!-- Available Books -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-pink-100 rounded-xl p-3">
                            <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-gray-600 text-sm font-medium mb-1">Available Books</h3>
                    <p class="text-3xl font-bold text-gray-900 mb-2">{{ \App\Models\Book::available()->count() }}</p>
                    <a href="{{ route('books.index') }}"
                        class="text-pink-600 hover:text-pink-700 text-sm font-medium inline-flex items-center">
                        Browse now
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Quick Actions</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('books.create') }}"
                        class="flex items-center gap-4 p-4 rounded-xl border-2 border-gray-200 hover:border-indigo-500 hover:bg-indigo-50 transition-all group">
                        <div class="bg-indigo-100 group-hover:bg-indigo-200 rounded-lg p-3 transition-colors">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Add Book</h3>
                            <p class="text-sm text-gray-600">List new book</p>
                        </div>
                    </a>

                    <a href="{{ route('books.index') }}"
                        class="flex items-center gap-4 p-4 rounded-xl border-2 border-gray-200 hover:border-purple-500 hover:bg-purple-50 transition-all group">
                        <div class="bg-purple-100 group-hover:bg-purple-200 rounded-lg p-3 transition-colors">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Browse</h3>
                            <p class="text-sm text-gray-600">Find books</p>
                        </div>
                    </a>

                    <a href="{{ route('books.my-books') }}"
                        class="flex items-center gap-4 p-4 rounded-xl border-2 border-gray-200 hover:border-pink-500 hover:bg-pink-50 transition-all group">
                        <div class="bg-pink-100 group-hover:bg-pink-200 rounded-lg p-3 transition-colors">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">My Books</h3>
                            <p class="text-sm text-gray-600">Manage listings</p>
                        </div>
                    </a>

                    <a href="{{ route('exchanges.index') }}"
                        class="flex items-center gap-4 p-4 rounded-xl border-2 border-gray-200 hover:border-green-500 hover:bg-green-50 transition-all group">
                        <div class="bg-green-100 group-hover:bg-green-200 rounded-lg p-3 transition-colors">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Exchanges</h3>
                            <p class="text-sm text-gray-600">View requests</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
