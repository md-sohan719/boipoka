<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookExchange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookExchangeController extends Controller
{
    public function index()
    {
        $sentRequests = Auth::user()->exchangeRequests()->with(['requesterBook', 'ownerBook', 'owner'])->latest()->get();
        $receivedRequests = Auth::user()->receivedExchangeRequests()->with(['requesterBook', 'ownerBook', 'requester'])->latest()->get();

        return view('exchanges.index', compact('sentRequests', 'receivedRequests'));
    }

    public function create(Book $book)
    {
        // Get user's books that can be exchanged
        $myBooks = Auth::user()->books()
            ->available()
            ->forExchange()
            ->where('id', '!=', $book->id)
            ->get();

        return view('exchanges.create', compact('book', 'myBooks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'requester_book_id' => 'required|exists:books,id',
            'owner_book_id' => 'required|exists:books,id',
            'message' => 'nullable|string|max:1000',
        ]);

        $ownerBook = Book::findOrFail($validated['owner_book_id']);

        // Check if requester owns the requester book
        $requesterBook = Book::findOrFail($validated['requester_book_id']);
        if ($requesterBook->user_id !== Auth::id()) {
            return back()->withErrors(['error' => 'You can only offer your own books for exchange.']);
        }

        // Check if owner book is available for exchange
        if (!in_array($ownerBook->listing_type, ['exchange', 'both']) || $ownerBook->status !== 'available') {
            return back()->withErrors(['error' => 'This book is not available for exchange.']);
        }

        $validated['requester_id'] = Auth::id();
        $validated['owner_id'] = $ownerBook->user_id;

        BookExchange::create($validated);

        return redirect()->route('exchanges.index')->with('success', 'Exchange request sent successfully!');
    }

    public function show(BookExchange $exchange)
    {
        // Ensure user is part of the exchange
        if ($exchange->requester_id !== Auth::id() && $exchange->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $exchange->load(['requesterBook', 'ownerBook', 'requester', 'owner']);

        return view('exchanges.show', compact('exchange'));
    }

    public function accept(BookExchange $exchange)
    {
        if ($exchange->owner_id !== Auth::id()) {
            abort(403, 'Only the book owner can accept this exchange.');
        }

        if ($exchange->status !== 'pending') {
            return back()->withErrors(['error' => 'This exchange request is no longer pending.']);
        }

        $exchange->update(['status' => 'accepted']);

        // Mark both books as reserved
        $exchange->requesterBook->update(['status' => 'reserved']);
        $exchange->ownerBook->update(['status' => 'reserved']);

        return redirect()->route('exchanges.show', $exchange)->with('success', 'Exchange request accepted!');
    }

    public function reject(BookExchange $exchange)
    {
        if ($exchange->owner_id !== Auth::id()) {
            abort(403, 'Only the book owner can reject this exchange.');
        }

        if ($exchange->status !== 'pending') {
            return back()->withErrors(['error' => 'This exchange request is no longer pending.']);
        }

        $exchange->update(['status' => 'rejected']);

        return redirect()->route('exchanges.index')->with('success', 'Exchange request rejected.');
    }

    public function complete(BookExchange $exchange)
    {
        if ($exchange->owner_id !== Auth::id() && $exchange->requester_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        if ($exchange->status !== 'accepted') {
            return back()->withErrors(['error' => 'This exchange has not been accepted yet.']);
        }

        $exchange->update(['status' => 'completed']);

        // Mark both books as exchanged
        $exchange->requesterBook->update(['status' => 'exchanged']);
        $exchange->ownerBook->update(['status' => 'exchanged']);

        return redirect()->route('exchanges.index')->with('success', 'Exchange completed successfully!');
    }
}
