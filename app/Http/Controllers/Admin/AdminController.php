<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use App\Models\BookExchange;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_books' => Book::count(),
            'total_exchanges' => BookExchange::count(),
            'pending_exchanges' => BookExchange::where('status', 'pending')->count(),
            'buyers' => User::where('role', 'buyer')->count(),
            'sellers' => User::where('role', 'seller')->count(),
            'admins' => User::where('role', 'admin')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Display all users.
     */
    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Display all books.
     */
    public function books()
    {
        $books = Book::with('user')->latest()->paginate(20);
        return view('admin.books.index', compact('books'));
    }

    /**
     * Display all exchanges.
     */
    public function exchanges()
    {
        $exchanges = BookExchange::with(['requester', 'owner', 'book'])
            ->latest()
            ->paginate(20);
        return view('admin.exchanges.index', compact('exchanges'));
    }

    /**
     * Delete a user.
     */
    public function deleteUser(User $user)
    {
        if ($user->isAdmin() && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'Cannot delete the last admin user.');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    /**
     * Delete a book.
     */
    public function deleteBook(Book $book)
    {
        $book->delete();
        return back()->with('success', 'Book deleted successfully.');
    }

    /**
     * Update user role.
     */
    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:buyer,seller,admin',
        ]);

        $user->update(['role' => $request->role]);
        return back()->with('success', 'User role updated successfully.');
    }
}
