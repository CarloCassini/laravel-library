@extends('layouts.app')

@section('main-content')
    <section class="container mt-5">
        <div class="row">
            <h1 class="mb-3">Sezione Dettagli</h1>
            {{-- bottoni --}}
            <div class="d-flex">
                <div>
                    <a href="{{ route('admin.books.index') }}" class="btn btn-primary mb-3 me-3">GO BACK</a>
                </div>
                <div>
                    <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-primary mb-3 me-3">
                        MODIFY
                    </a>
                </div>
            </div>

            <div class="col-6 mx-auto">
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
                                        {{ $book->genre?->name }}
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
                                <li>
                                    <strong>Tags:</strong>
                                    @forelse ($book->typologies as $typology)
                                        <span class="badge"
                                            @if ($typology->color) style = 'background-color: {{ $typology->color }}' @endif>{{ $typology->format }}</span>
                                    @empty
                                        Nessuna tipologia associata
                                    @endforelse
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
