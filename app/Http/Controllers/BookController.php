<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function getBooks()
    {
        $books = Book::all();

        return view('books', compact('books'));
    }
}
