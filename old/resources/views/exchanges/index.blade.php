<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book Exchanges') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Received Requests -->
            <div class="mb-8">
                <h3 class="text-2xl font-bold mb-4">Received Exchange Requests</h3>

                @forelse($receivedRequests as $exchange)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <span
                                        class="px-3 py-1 rounded text-sm font-semibold
                                        {{ $exchange->status === 'pending'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : ($exchange->status === 'accepted'
                                                ? 'bg-green-100 text-green-800'
                                                : ($exchange->status === 'rejected'
                                                    ? 'bg-red-100 text-red-800'
                                                    : 'bg-blue-100 text-blue-800')) }}">
                                        {{ ucfirst($exchange->status) }}
                                    </span>
                                    <span
                                        class="ml-2 text-sm text-gray-600">{{ $exchange->created_at->diffForHumans() }}</span>
                                </div>

                                @if ($exchange->status === 'pending')
                                    <div class="flex gap-2">
                                        <form method="POST" action="{{ route('exchanges.accept', $exchange) }}">
                                            @csrf
                                            <button type="submit"
                                                class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                                                Accept
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('exchanges.reject', $exchange) }}">
                                            @csrf
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                @endif

                                @if ($exchange->status === 'accepted')
                                    <form method="POST" action="{{ route('exchanges.complete', $exchange) }}">
                                        @csrf
                                        <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                            Mark as Completed
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <div class="grid md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600 mb-2">From:
                                        <strong>{{ $exchange->requester->name }}</strong></p>
                                    <div class="border rounded p-3">
                                        <p class="font-semibold">{{ $exchange->requesterBook->title }}</p>
                                        <p class="text-sm text-gray-600">by {{ $exchange->requesterBook->author }}</p>
                                        <p class="text-sm text-gray-600">Condition:
                                            {{ ucfirst(str_replace('_', ' ', $exchange->requesterBook->condition)) }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-600 mb-2">Your Book:</p>
                                    <div class="border rounded p-3 bg-blue-50">
                                        <p class="font-semibold">{{ $exchange->ownerBook->title }}</p>
                                        <p class="text-sm text-gray-600">by {{ $exchange->ownerBook->author }}</p>
                                        <p class="text-sm text-gray-600">Condition:
                                            {{ ucfirst(str_replace('_', ' ', $exchange->ownerBook->condition)) }}</p>
                                    </div>
                                </div>
                            </div>

                            @if ($exchange->message)
                                <div class="mt-4 p-3 bg-gray-50 rounded">
                                    <p class="text-sm text-gray-600 mb-1"><strong>Message:</strong></p>
                                    <p class="text-sm">{{ $exchange->message }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <p class="text-gray-500">No received exchange requests yet.</p>
                    </div>
                @endforelse
            </div>

            <!-- Sent Requests -->
            <div>
                <h3 class="text-2xl font-bold mb-4">Sent Exchange Requests</h3>

                @forelse($sentRequests as $exchange)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <span
                                        class="px-3 py-1 rounded text-sm font-semibold
                                        {{ $exchange->status === 'pending'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : ($exchange->status === 'accepted'
                                                ? 'bg-green-100 text-green-800'
                                                : ($exchange->status === 'rejected'
                                                    ? 'bg-red-100 text-red-800'
                                                    : 'bg-blue-100 text-blue-800')) }}">
                                        {{ ucfirst($exchange->status) }}
                                    </span>
                                    <span
                                        class="ml-2 text-sm text-gray-600">{{ $exchange->created_at->diffForHumans() }}</span>
                                </div>

                                @if ($exchange->status === 'accepted')
                                    <form method="POST" action="{{ route('exchanges.complete', $exchange) }}">
                                        @csrf
                                        <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                            Mark as Completed
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <div class="grid md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600 mb-2">Your Book:</p>
                                    <div class="border rounded p-3 bg-blue-50">
                                        <p class="font-semibold">{{ $exchange->requesterBook->title }}</p>
                                        <p class="text-sm text-gray-600">by {{ $exchange->requesterBook->author }}</p>
                                        <p class="text-sm text-gray-600">Condition:
                                            {{ ucfirst(str_replace('_', ' ', $exchange->requesterBook->condition)) }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-600 mb-2">To:
                                        <strong>{{ $exchange->owner->name }}</strong></p>
                                    <div class="border rounded p-3">
                                        <p class="font-semibold">{{ $exchange->ownerBook->title }}</p>
                                        <p class="text-sm text-gray-600">by {{ $exchange->ownerBook->author }}</p>
                                        <p class="text-sm text-gray-600">Condition:
                                            {{ ucfirst(str_replace('_', ' ', $exchange->ownerBook->condition)) }}</p>
                                    </div>
                                </div>
                            </div>

                            @if ($exchange->message)
                                <div class="mt-4 p-3 bg-gray-50 rounded">
                                    <p class="text-sm text-gray-600 mb-1"><strong>Your Message:</strong></p>
                                    <p class="text-sm">{{ $exchange->message }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <p class="text-gray-500">You haven't sent any exchange requests yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
