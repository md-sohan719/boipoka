<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookExchangeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Book routes
Route::resource('books', BookController::class)->except(['index', 'show']);
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
Route::get('/my-books', [BookController::class, 'myBooks'])->middleware('auth')->name('books.my-books');

// Exchange routes
Route::middleware('auth')->group(function () {
    Route::get('/exchanges', [BookExchangeController::class, 'index'])->name('exchanges.index');
    Route::get('/exchanges/create/{book}', [BookExchangeController::class, 'create'])->name('exchanges.create');
    Route::post('/exchanges', [BookExchangeController::class, 'store'])->name('exchanges.store');
    Route::get('/exchanges/{exchange}', [BookExchangeController::class, 'show'])->name('exchanges.show');
    Route::post('/exchanges/{exchange}/accept', [BookExchangeController::class, 'accept'])->name('exchanges.accept');
    Route::post('/exchanges/{exchange}/reject', [BookExchangeController::class, 'reject'])->name('exchanges.reject');
    Route::post('/exchanges/{exchange}/complete', [BookExchangeController::class, 'complete'])->name('exchanges.complete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [App\Http\Controllers\Admin\AdminController::class, 'users'])->name('users');
    Route::get('/books', [App\Http\Controllers\Admin\AdminController::class, 'books'])->name('books');
    Route::get('/exchanges', [App\Http\Controllers\Admin\AdminController::class, 'exchanges'])->name('exchanges');

    Route::delete('/users/{user}', [App\Http\Controllers\Admin\AdminController::class, 'deleteUser'])->name('users.delete');
    Route::delete('/books/{book}', [App\Http\Controllers\Admin\AdminController::class, 'deleteBook'])->name('books.delete');
    Route::patch('/users/{user}/role', [App\Http\Controllers\Admin\AdminController::class, 'updateUserRole'])->name('users.update-role');
});

require __DIR__ . '/auth.php';
