@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('main-content')
    <section class="container mt-5">
        <div class="row">
            <div class="div mb-3">
                <a href="{{ route('books.index') }}" class="btn btn-primary">GO BACK</a>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Inserisci Libro</h3>
                    </div>
                    <form action="{{ route('books.update', $book) }}" method="POST" class="card-body">
                        @csrf
                        @method('PUT')
                        <div class="d-flex">
                            <div class="mb-3 me-2 col">
                                <label for="title" class="form-label">Titolo</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ $book->title }}">
                            </div>

                            <div class="mb-3 me-2 col">
                                <label for="author" class="form-label">Autore</label>
                                <input type="text" class="form-control" id="author" name="author"
                                    value="{{ $book->author }}">
                            </div>
                            <div class="mb-3 col">
                                <label for="editor" class="form-label">Editore</label>
                                <input type="text" class="form-control" id="editor" name="editor"
                                    value="{{ $book->editor }}">
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="mb-3 me-2 col">
                                <label for="genre" class="form-label">Genere</label>
                                <input type="text" class="form-control" id="genre" name="genre"
                                    value="{{ $book->genre }}">
                            </div>
                            <div class="mb-3 me-2 col">
                                <label for="synopsis" class="form-label">Synopsis</label>
                                <input type="text" class="form-control" id="synopsis" name="synopsis"
                                    value="{{ $book->synopsis }}">
                            </div>
                            <div class="mb-3 me-2 col">
                                <label for="published" class="form-label">Published</label>
                                <input type="date" class="form-control" id="published" name="published"
                                    value="{{ $book->published }}">
                            </div>
                            <div class=" col">
                                <label for="pages" class="form-label">TOT. Pagine</label>
                                <input type="number" class="form-control" id="pages" name="pages"
                                    value="{{ $book->pages }}">
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success px-5">INVIA</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
