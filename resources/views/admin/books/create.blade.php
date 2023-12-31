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
                <a href="{{ route('admin.books.index') }}" class="btn btn-primary">GO BACK</a>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Inserisci Libro</h3>
                    </div>
                    <form action="{{ route('admin.books.store') }}" method="POST" class="card-body">
                        @csrf
                        <div class="d-flex">
                            <div class="mb-3 me-2 col">
                                <label for="title" class="form-label">Titolo</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>

                            <div class="mb-3 me-2 col">
                                <label for="author" class="form-label">Autore</label>
                                <input type="text" class="form-control" id="author" name="author">
                            </div>
                            <div class="mb-3 col">
                                <label for="editor" class="form-label">Editore</label>
                                <input type="text" class="form-control" id="editor" name="editor">
                            </div>
                        </div>
                        <div>
                            <label for="genre_id" class="form-label">Genere</label>
                            <select name="genre_id" id="genre_id"
                                class="form-select @error('genre_id') is-invalid @enderror">
                                <option value="">Nessun Genere</option>
                                @foreach ($genres as $genre)
                                    <option value="{{ $genre->id }}" @if (old('genre_id') == $genre->id) selected @endif>
                                        {{ $genre->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('genre_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="mb-3 me-2 col">
                                <label for="synopsis" class="form-label">Synopsis</label>
                                <input type="text" class="form-control" id="synopsis" name="synopsis">
                            </div>
                            <div class="mb-3 me-2 col">
                                <label for="published" class="form-label">Published</label>
                                <input type="date" class="form-control" id="published" name="published">
                            </div>
                            <div class=" col">
                                <label for="pages" class="form-label">TOT. Pagine</label>
                                <input type="number" class="form-control" id="pages" name="pages">
                            </div>
                        </div>
                        <div>
                            {{-- add checkbox --}}
                            <label class="form-label">Typology</label>

                            <div class="form-check @error('typology') is-invalid @enderror p-0">
                                @foreach ($typologies as $typology)
                                    <input type="checkbox" id="typology-{{ $typology->id }}" value="{{ $typology->id }}"
                                        name="typologies[]" class="form-check-control"
                                        @if (in_array($typology->id, old('typologies', $book_typologies ?? []))) checked @endif>
                                    <label for="typology-{{ $typology->id }}">
                                        {{ $typology->format }}
                                    </label>
                                    <br>
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
