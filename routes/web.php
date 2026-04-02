<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// All system business logic placed strictly under global auth wrapper
Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Catalogue Read Route - accessible to all authenticated users (Members/Admins/Librarians)
    Route::get('/books', [BookController::class, 'index'])->name('books.index');

    // Routes explicitly mapped for Members (Borrowing logic restricts stock dynamically)
    Route::middleware('role:member')->group(function () {
        Route::post('/books/{book}/borrow', [BorrowController::class, 'store'])->name('borrows.store');
        Route::get('/my-books', [BorrowController::class, 'index'])->name('borrows.index');
    });

    // Subsystem for Administrative Operations (Books CRUD, User Info)
    Route::middleware('role:admin,librarian')->group(function () {
        Route::get('/manage/members', [AdminController::class, 'membersList'])->name('admin.members');
        
        // Strict explicit bindings for book management overriding route::resource
        Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
        Route::post('/books', [BookController::class, 'store'])->name('books.store');
        Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
        Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    });

    // Top Level Subsystem strictly for Admin
    Route::middleware('role:admin')->group(function () {
        Route::post('/manage/librarians', [AdminController::class, 'storeLibrarian'])->name('admin.storeLibrarian');
        Route::get('/manage/roles', [AdminController::class, 'rolesIndex'])->name('admin.roles');
    });
});

require __DIR__.'/auth.php';
