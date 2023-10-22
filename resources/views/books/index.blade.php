@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('main-content')
    <section class="container mt-5">
        <a href="{{ route('books.create') }}" class="btn btn-warning my-3"> create new book</a>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Lista Libri</th>
                    <th scope="col">Autore</th>
                    <th scope="col">Editore</th>
                    <th scope="col">Genere</th>
                    <th scope="col">Sinossi</th>
                    <th scope="col">Published</th>
                    <th scope="col">Pagine</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr>
                        <th scope="row">{{ $book->id }}</th>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->editor }}</td>
                        <td>{{ $book->genre }}</td>
                        <td>{{ $book->synopsis }}</td>
                        <td>{{ $book->published }}</td>
                        <td>{{ $book->pages }}</td>
                        <td>
                            <a href="{{ route('books.show', $book->id) }}" class="btn btn-primary me-2">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('books.edit', $book) }}" class="btn btn-primary me-2">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('books.destroy', $book) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn me-2">
                                    <i class="fa-solid fa-trash-can-arrow-up"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endsection
