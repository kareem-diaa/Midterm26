<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowController extends Controller
{
    /**
     * Security Constraint: IDOR Prevention. Ensures Members can ONLY view their own bound records.
     */
    public function index()
    {
        $borrows = auth()->user()->borrows()->with('book')->get();
        return view('borrows.index', compact('borrows'));
    }

    /**
     * Security Constraints: Race Condition prevention using Database Transactions & Pessimistic Locking.
     */
    public function store(Request $request, Book $book)
    {
        return DB::transaction(function () use ($book) {
            // lockForUpdate() ensures concurrent requests wait, preventing double-booking logic flaws
            $bookToBorrow = Book::where('id', $book->id)->lockForUpdate()->first();

            if ($bookToBorrow->copies <= 0) {
                return redirect()->back()->with('status', 'Book Currently Unavailable'); // Match the exam message requirement
            }

            // IDOR Prevention: Create record strictly under the authenticated ID
            auth()->user()->borrows()->create([
                'book_id' => $bookToBorrow->id,
            ]);

            // Database decrement directly via eloquent
            $bookToBorrow->decrement('copies');

            return redirect()->route('borrows.index')->with('status', 'Book successfully borrowed.');
        });
    }
}
