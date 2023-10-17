@extends('layouts.app')

@section('main-content')
    <section class="container mt-5">
        <h1>Lista Libri</h1>
        <div class="row row-cols-2 g-4">
            @foreach ($books as $book)
                <div class="col">
                    <div class="card">
                        <div class="card-header text-center">
                            {{ $book->title }}
                        </div>
                        <div class="d-flex">
                            <div class="card-body" style="max-width: 60%">
                                <ul class="list-unstyled">
                                    <li>
                                        <strong>
                                            Autore :
                                        </strong>
                                        <span>
                                            {{ $book->author }}
                                        </span>
                                    </li>
                                    <li>
                                        <strong>
                                            Editore :
                                        </strong>
                                        <span>
                                            {{ $book->editor }}
                                        </span>
                                    </li>
                                    <li>
                                        <strong>
                                            Genere :
                                        </strong>
                                        <span>
                                            {{ $book->genre }}
                                        </span>
                                    </li>
                                    <li>
                                        <strong>
                                            Sinossi :
                                        </strong>
                                        <span>
                                            {{ $book->synopsis }}
                                        </span>
                                    </li>
                                    <li>
                                        <strong>
                                            Published :
                                        </strong>
                                        <span>
                                            {{ $book->published }}
                                        </span>
                                    </li>
                                    <li>
                                        <strong>
                                            Pagine :
                                        </strong>
                                        <span>
                                            {{ $book->pages }}
                                        </span>
                                    </li>
                                </ul>
                            </div>

                            <div class="m-auto">
                                <a href="#" class="btn btn-primary">DETAIL BOOK</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
