@extends('layouts.app')

@section('main-content')
    <section class="container mt-5">
        <h1>Lista Libri</h1>

        @foreach ($books as $book)
            {{ $book }}
        @endforeach
    </section>
@endsection
