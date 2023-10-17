<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Init project

1. Installa le dipendenze di frontend

```
npm install
```

2. Fai partire il compilatore per i file di frontend

```
npm run dev
```

3. Installa le dipendenze di backend in un nuovo terminale

```
composer install
```

4. Fai partire il server di sviluppo backend

```
php artisan serve
```

5. Copia il file `.env.example` e chiamalo `.env`. Poi esegui il comando per generare la chiave

```
php artisan key:generate
```

## Connessione al DB

1. Avvio MAMP

2. Apro [PHPMyAdmin](http://localhost/phpMyAdmin/?lang=en)

3. Creo un nuovo DB (es. `103_rent`)

4. nel file `.env` aggiungo i parametri di connessione presenti sulla [pagina iniziale di MAMP](http://localhost/MAMP/)

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=103_rent
DB_USERNAME=root
DB_PASSWORD=root
```

## Creazione di una Migration

Per creare una tabella lanciare il comando

```
php artisan make:migration create_houses_table
```

Aggiungi poi tutte le colonne che rappresentano la tabella nella funzione `up()`. I tipi di dato disponibili sono [qui](https://laravel.com/docs/9.x/migrations#available-column-types)

```php
// create_houses_table

public function up()
  {
    Schema::create('houses', function (Blueprint $table) {
      $table->id();
      $table->tinyInteger('rooms')->unsigned();
      $table->tinyInteger('bathrooms')->unsigned();
      $table->smallInteger('square_meters')->unsigned();
      $table->enum('type', ['appartment', 'independent', 'villa']);
      $table->string('address', 100);
      $table->string('city', 50);
      $table->string('state', 50);
      $table->string('zipcode', 15);
      $table->text('description');
      $table->float('price', 5, 2);
      $table->timestamps();
    });
  }
```

Eseguo la migrazione appena creata con il comando

```
php artisan migrate
```

## Aggiunta di dati

Aggiungo un paio di righe da [PHPMyAdmin](http://localhost/phpMyAdmin/?lang=en) per visualizzare dati di esempio

## Creazione di un Model

Creo un Model che rappresenti la tabella appena realizzata con il comando

```
php artisan make:model House
```

## Creazione di un Controller per la risorsa

Creo un Controller per la risorsa `House` con il comando

```
php artisan make:controller HouseController
```

Importo il controller nel file `routes/web.php` per assegnargli delle rotte

```php
// web.php

use App\Http\Controllers\HouseController;

// ...

// # Rotte risorsa house
Route::get('/house', [HouseController::class, 'index'])->name('house.index');
```

Realizzo una funzione contenente la logica del metodo legato in `routes/web.php` dentro il controller `HouseController.php`. Dovremo

1. importare il modello `House`
2. nel metodo `index()` recuperare tutte gli elementi della tabella e passarli ad una vista

```php
// HouseController.php

use App\Models\House;

// ...

class HouseController extends Controller
{
  public function index()
  {
    $houses = House::all();
    return view('house.index', compact('houses'));
  }
}
```

## Creazione di una vista per visualizzare i dati

creo un file `resources\views\house\index.blade.php` e estendo il layout `app.blade.php`.
In un forelse stamperò tutti i dati ricevuti

```php
@extends('layouts.app')

@section('main-content')
  <section class="container mt-5">

    @forelse($houses as $house)
      <p>
        <strong>Type</strong>: {{ $house->type }} <br>
        <strong>Rooms</strong>: {{ $house->rooms }} <br>
        <strong>Bathrooms</strong>: {{ $house->bathrooms }}
      </p>
      <hr>
    @empty
      <h2>Non ci sono risultati</h2>
    @endforelse
  </section>
@endsection

```
