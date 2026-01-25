<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::with('user')->available();

        if ($request->has('type')) {
            if ($request->type === 'sell') {
                $query->forSale();
            } elseif ($request->type === 'exchange') {
                $query->forExchange();
            }
        }

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $books = $query->latest()->paginate(12);

        // Categories for the homepage category list
        $categories = Book::whereNotNull('category')->distinct()->pluck('category');

        // Featured books (latest 6)
        $featured = Book::with('user')->available()->latest()->take(6)->get();

        return view('books.index', compact('books', 'categories', 'featured'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'price' => 'required|numeric|min:0',
            'condition' => 'required|in:new,like_new,very_good,good,acceptable',
            'listing_type' => 'required|in:sell,exchange,both',
            'category' => 'nullable|string|max:100',
            'publication_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'language' => 'required|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('books', 'public');
        }

        $book = Book::create($validated);

        return redirect()->route('books.show', $book)->with('success', 'Book listed successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load('user');
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $this->authorize('update', $book);
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $this->authorize('update', $book);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'price' => 'required|numeric|min:0',
            'condition' => 'required|in:new,like_new,very_good,good,acceptable',
            'listing_type' => 'required|in:sell,exchange,both',
            'category' => 'nullable|string|max:100',
            'publication_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'language' => 'required|string|max:50',
            'status' => 'required|in:available,sold,exchanged,reserved',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }
            $validated['image'] = $request->file('image')->store('books', 'public');
        }

        $book->update($validated);

        return redirect()->route('books.show', $book)->with('success', 'Book updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $this->authorize('delete', $book);

        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
    }

    public function myBooks()
    {
        $books = Auth::user()->books()->latest()->paginate(12);
        return view('books.my-books', compact('books'));
    }
}
