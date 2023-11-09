@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('main-content')
    <div class="container mt-3">
        {{-- per gli errori --}}
        @if ($errors->any())
            <div class="alert alert-warning">
                <h5>correggi i seguenti errori</h5>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
    <section class="container mt-3">
        <div class="row">
            <div class="div mb-3">
                <a href="{{ route('admin.books.index') }}" class="btn btn-primary">GO BACK</a>

                {{-- MODAL FOR DELTE --}}
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#DeleteModal-{{ $book->id }}">
                    <i class="fa-solid fa-trash-can-arrow-up"></i>
                </button>


            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Inserisci Libro</h3>
                    </div>
                    <form action="{{ route('admin.books.update', $book) }}" method="POST" class="card-body">
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
                                <label for="genre_id" class="form-label">Genere</label>
                                <select name="genre_id" id="genre_id"
                                    class="form-select @error('genre_id') is-invalid @enderror">
                                    <option value="">Non categorizzato</option>
                                    @foreach ($genres as $genre)
                                        <option value="{{ $genre->id }}"
                                            @if (old('genre_id') ?? $book->genre_id == $genre->id) selected @endif>{{ $genre->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('genre_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
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
                        <label class="form-label ">Typology</label>
                        {{-- todo -> inserire checkbox --}}
                        {{-- add checkbox --}}
                        <div class="form-check @error('typology') is-invalid @enderror p-0">
                            <div class="d-flex ">
                                @foreach ($typologies as $typology)
                                    <div class="me-3">

                                        <input type="checkbox" id="typology-{{ $typology->id }}"
                                            value="{{ $typology->id }}" name="typologies[]" class="form-check-control"
                                            @if (in_array($typology->id, old('typologies', $book_typologies ?? []))) checked @endif>
                                        <label for="typology-{{ $typology->id }}">
                                            {{ $typology->format }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            @error('typologies')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
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


@section('modals')
    <div class="modal fade" id="DeleteModal-{{ $book->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">STAI ELIMINANDO
                        <strong>{{ $book->title }}</strong>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Sei sicuro di voler cancellare <strong>"{{ $book->title }}"</strong> dal
                    DataBase??
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ANNULLA</button>
                    {{-- TASTO PER CANCELALRE --}}
                    <form action="{{ route('admin.books.destroy', $book) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">DELETE</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
