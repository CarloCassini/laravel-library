@extends('layouts.app')

@section('main-content')
    <section class="container mt-5">
        <h1>{{ $title }}</h1>
        <a href="{{ route('admin.books.index') }}">
            vai a vedere i libri
        </a>

    </section>
@endsection
