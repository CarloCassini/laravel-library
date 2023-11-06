@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('main-content')
    <section class="container mt-5">
        <a href="{{ route('admin.books.create') }}" class="btn btn-warning my-3"> create new book</a>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Lista Libri</th>
                    <th scope="col">Genere</th>
                    <th scope="col">Autore</th>
                    <th scope="col">Editore</th>
                    <th scope="col">Sinossi</th>
                    <th scope="col">Published</th>
                    <th scope="col">Pagine</th>
                    <th scope="col">typologies</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr>
                        <th scope="row">{{ $book->id }}</th>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->genre?->name }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->editor }}</td>
                        <td>{{ $book->synopsis }}</td>
                        <td>{{ $book->published }}</td>
                        <td>{{ $book->pages }}</td>

                        <td>
                            @foreach ($book->typologies as $typology)
                                {{ $typology->format }}
                            @endforeach
                        </td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('admin.books.show', $book->id) }}" class="btn me-1">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.books.edit', $book) }}" class="btn me-1">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                {{-- MODAL FOR DELETE --}}
                                <button class="btn btn-primary me-1" data-bs-toggle="modal"
                                    data-bs-target="#DeleteModal-{{ $book->id }}">
                                    <i class="fa-solid fa-trash-can-arrow-up"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div>
            {{ $books->links('pagination::bootstrap-5') }}
        </div>
    </section>
@endsection

@section('modals')
    @foreach ($books as $book)
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
    @endforeach
@endsection
