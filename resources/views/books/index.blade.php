@extends('layouts.app')

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
                    <a href="{{ route('books.show' , $book->id)}}" class="btn btn-primary"> dettaglio </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</section>

@endsection