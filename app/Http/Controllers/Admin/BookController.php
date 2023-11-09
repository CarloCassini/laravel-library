<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Typology;
use Illuminate\Http\Request;

use App\Http\Requests\CreateBookRequest;
use App\Http\Requests\UpdateBookRequest;

use Illuminate\Support\Arr;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *+ @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::paginate(10);
        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     *+ @return \Illuminate\Http\Response
     */
    public function create()
    {
        $typologies = Typology::all();
        $genres = Genre::all();
        return view('admin.books.create', compact('genres', 'typologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CreateBookRequest  $request
     * *@return \Illuminate\Http\Response
     */
    public function store(CreateBookRequest $request)
    {
        $data = $request->validated();
        $book = new Book();
        $book->fill($data);
        $book->save();

        if (Arr::exists($data, "typologies"))
            $book->typologies()->attach($data["typologies"]);
        return redirect()->route('admin.books.show', $book)->with('success', '');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     ** @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view("admin.books.show", compact("book"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $genres = Genre::all();
        $typologies = Typology::all();
        $book_typologies = $book->typologies->pluck('id')->toArray();
        return view("admin.books.edit", compact("book", 'typologies', 'genres', 'book_typologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $data = $request->Validated();
        $book->update($data);

        if (Arr::exists($data, "typologies"))
            $book->typologies()->sync($data["typologies"]);
        else
            $book->typologies()->detach();

        return redirect()->route("admin.books.show", $book)->with("success", "");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     ** @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->typologies()->detach();
        $book->delete();
        return redirect()->route("admin.books.index")->with("success", "");
    }
}