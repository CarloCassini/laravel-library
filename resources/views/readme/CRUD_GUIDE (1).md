# REALIZZARE UNA CRUD

## _`Pro Practice`_

questo comando genera Model Seeder Resource Controller;

```
php artisan make:model -msrc
```

## Creare il Resource Model

questo comando genera Model e Resource Controller;

```
php artisan make:model Pasta -r
```

## Creare la Migration

questo comando genera la Migration

```
php artisan make:migration create_pastas_table
```

dovremo poi inserire la struttura della tabella nella funzione `up` che crea la tabella.

```php
// database/migrations/xxxx_xx_xx_xxxxxx_create_pastas_table.php

/**
 * Run the migrations.
 *
 * @return void
 */
public function up()
{
  Schema::create('pastas', function (Blueprint $table) {
    // id() genera una colonna int, primary key, AI, not null
    $table->id();

    $table->string('name', 20);
    $table->integer('number')->unique();
    $table->enum('type', ['lunga', 'corta', 'cortissima']);
    $table->integer('cooking_time')->unsigned();
    $table->integer('weight')->unsigned();
    $table->text('description')->nullable();
    $table->text('image')->nullable();

    // timestamps() genera le colonne created_at ed updated_at
    $table->timestamps();
  });
}
```

Dobbiamo assicurarci che venga cancellata nella funzione `down`, nella quale deve sempre avvenire l'inverso della funzione `up`

```php
// database/migrations/xxxx_xx_xx_xxxxxx_create_pastas_table.php

/**
 * Reverse the migrations.
 *
 * @return void
 */
public function down()
{
  Schema::dropIfExists('pastas');
}
```

A questo punto possiamo lanciare la Migration con il comando

```
php artisan migrate
```

## Creare il Seeder

questo comando creerà il Seeder:

```
php artisan make:seeder PastaSeeder
```

Nel Seeder possiamo importare i dati da un array o generarli con Faker.
Assicuriamoci di aver importato Faker ed il modello da seeddare

```php
// database/seeders/PastaSeeder.php

use App\Models\Pasta;
use Faker\Generator as Faker;
```

Il metodo `run()` permetterà il popolamento della tabella. al suo interno Faker genererà i dati di solito in un ciclo `for`.
NB. Bisogna passare Faker come argomento usando una dependency injection.

```php
// database/seeders/PastaSeeder.php

/**
* Run the database seeds.
*
* @return void
*/
public function run(Faker $faker)
{
  for($i = 0; $i < 50; $i++) {
    $pasta = new Pasta;
    $pasta->name = $faker->firstNameFemale();
    $pasta->number = $faker->unique()->numberBetween(1, 100);
    $pasta->type = $faker->randomElement(['lunga', 'corta', 'cortissima']);
    $pasta->cooking_time = $faker->numberBetween(8, 14);
    $pasta->weight = $faker->randomElement([500, 1000]);
    $pasta->description = $faker->paragraph(8);
    $pasta->img = "https://picsum.photos/300/200";
    $pasta->save();
  }
}
```

nella funzione `run()` del file DatabaseSeeder.php va aggiunta la call per il seeder creato (ed ogni altro seeder che va lanciato col comando `db:seed`)

```php
// database/seeders/DatabaseSeeder.php

public function run()
{
  $this->call([
    PastaSeeder::class,
  ]);
}
```

Possiamo poi popolare il DB col comando:

```
php artisan db:seed
```

#### `N.B.`

Se non modifichi il **_`DatabaseSeeder.php`_** puoi lanciare questo comando per popolare il DB.

```
php artisan db:seed --class=NomeSeeder
```

## Gestire le rotte

dobbiamo importare il controller che si occuperà di gestire la risorsa nel file `web.php`

```php
// routes/web.php

use App\Http\Controllers\PastaController;
```

poi usando il metodo statico resource della classe `Route` generiamo tutte le rotte della CRUD e le associamo al controller preposto alla gestione della risorsa

```php
// routes/web.php

Route::resource('pastas', PastaController::class);
```

## Il Resource Controller

Usando il parametro `-r` nella creazione del modello, questo risulterà già importato nel controller. Diversamente dovremo accertarci che lo sia

```php
// App/Http/Controllers/PastaController.php

use App\Models\Pasta;
```

### R - READ

La lettura delle risorse dal Database

#### index - La lista

nel metodo index del controller recupereremo i risultati con il metodo statico del modello `::all()`, oppure filtrando con `::where(...)->get()`.

Se avessimo bisogno della paginazione, possiamo sostiuire `all()` o `get()` con il metodo `paginate(n_items_per_page)`

```php
// App/Http/Controllers/PastaController.php

/**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
public function index()
{
  $pastas = Pasta::paginate(8);
  return view('pastas.index', compact('pastas'));
}

```

A questo punto stiamo ritornando i dati al template `index.blade.php` nella cartella della risorsa. Dobbiamo perciò crearlo.

Aggiungeremo man mano i link alle altre rotte.

```html
{{-- resources/views/pastas/index.blade.php --}}

<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Nome</th>
      <th scope="col">Numero</th>
      <th scope="col">Tipo</th>
      <th scope="col">Minuti di cottura</th>
      <th scope="col">Grammi</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($pastas as $pasta)
    <tr>
      <th scope="row">{{ $pasta->id }}</th>
      <td>{{ $pasta->name }}</td>
      <td>{{ $pasta->number }}</td>
      <td>{{ $pasta->type }}</td>
      <td>{{ $pasta->cooking_time }}</td>
      <td>{{ $pasta->weight }}</td>
      <td>...</td>
    </tr>
    @endforeach
  </tbody>
</table>

{{-- Se è stata usata la paginazione --}} {{
$pastas->links('pagination::bootstrap-5') }}
```

#### show - Il dettaglio

Andiamo a creare il dettaglio della singola risorsa. Nel metodo `show` del controller:

```php
// App/Http/Controllers/PastaController.php

/**
 * Display the specified resource.
 *
 * @param  \App\Models\Pasta $pasta
 * @return \Illuminate\Http\Response
 */
public function show(Pasta $pasta)
{
  return view('pastas.show', compact('pasta'));
}
```

e la sua vista:

```html
{{-- resources/views/pastas/show.blade.php --}}

<strong>Nome: </strong> {{ $pasta->name }} <br />
<strong>N°: </strong> {{ $pasta->number }} <br />
<strong>Tempo di cottura: </strong> {{ $pasta->cooking_time }} <br />
<strong>Tipo: </strong> {{ $pasta->type }} <br />
<strong>Peso: </strong> {{ $pasta->weight }} <br />
<strong>Descrizione:</strong> {{ $pasta->description }} <br />
```

infine aggiungiamo il link al dettaglio nella cella "actions" della lista

```html
{{-- resources/views/pastas/index.blade.php --}}

<table class="table">
  ...
  <tbody>
    @foreach ($pastas as $pasta)
    <tr>
      <th scope="row">{{ $pasta->id }}</th>
      ...
      <td>
        <a href="{{ route('pastas.show', $pasta) }}"> Dettaglio </a>

        ...
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
```

### C - CREATE

#### create - Il form

La rotta `create` dovrà restituire la vista del form

```php
// App/Http/Controllers/PastaController.php

/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */
public function create()
{
    return view('pastas.create');
}
```

nella vista stamperemo tutti gli input.
Il form dovrà:

- avere method `POST`
- la sua action dovrà puntare alla rotta dello store
- contenere la direttiva `@csrf` per generare il token di sicurezza

```html
{{-- resources/views/pastas/create.blade.php --}}

<form action="{{ route('pastas.store') }}" method="POST">
  @csrf

  <label for="name" class="form-label">Nome</label>
  <input type="text" class="form-control" id="name" name="name" />

  <label for="number" class="form-label">N°</label>
  <input type="text" class="form-control" id="number" name="number" />

  <label for="type" class="form-label">Tipo</label>
  <select class="form-select" id="type" name="type">
    <option value="lunga">Lunga</option>
    <option value="corta">Corta</option>
    <option value="cortissima">Cortissima</option>
  </select>

  <label for="cooking_time" class="form-label">Tempo di cottura</label>
  <input
    type="number"
    class="form-control"
    id="cooking_time"
    name="cooking_time"
  />

  <label for="weight" class="form-label">Peso (g)</label>
  <input type="text" class="form-control" id="weight" name="weight" />

  <label for="img" class="form-label">img</label>
  <input type="text" class="form-control" id="img" name="img" />

  <label for="description" class="form-label">Descrizione</label>
  <textarea
    class="form-control"
    id="description"
    name="description"
    rows="4"
  ></textarea>

  <button type="submit" class="btn btn-primary">Salva</button>
</form>
```

infine aggiungiamo il link al form di creazione vicino alla lista

```html
{{-- resources/views/pastas/index.blade.php --}}

<a href="{{ route('pastas.create') }}" role="button" class="btn btn-primary"
  >Crea pasta</a
>

<table class="table">
  ...
</table>
```

#### store - Il salvataggio

Predisponiamo il modello a ricevere dati da form con la variabile d'istanza protetta `$fillable`

```php
// App\Models\Pasta.php;

class Pasta extends Model
{
    use HasFactory;

    protected $fillable = ["name", "number", "type", "cooking_time", "weight", "img", "description"];
}

```

Nel metodo `store()` gestiremo la logica del salvataggio reindirizzando poi l'utente alla rotta `show()`

```php
// App/Http/Controllers/PastaController.php

/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function store(Request $request)
{
    $data = $request->all();
    $pasta = new Pasta;
    $pasta->fill($data);
    $pasta->save();
    return redirect()->route('pastas.show', $pasta);
}
```

### E - EDIT

#### edit - Il form

La rotta `edit` dovrà restituire la vista del form, inviandole l'istanza da modificare ricevuta tramite dependency injection

```php
// App/Http/Controllers/PastaController.php

/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */
public function edit(Pasta $pasta)
{
  return view('pastas.edit', compact('pasta'));
}
```

nella vista stamperemo tutti gli input.
Il form dovrà:

- avere method `POST`
- la sua action dovrà puntare alla rotta dell'update
- contenere la direttiva `@method('put')`
- contenere la direttiva `@csrf` per generare il token di sicurezza
- gli input dovranno contenere i valori originali dell'istanza

```html
{{-- resources/views/pastas/update.blade.php --}}

<form action="{{ route('pastas.update') }}" method="POST">
  @method('PUT') @csrf

  <label for="name" class="form-label">Nome</label>
  <input
    type="text"
    class="form-control"
    id="name"
    name="name"
    value="{{ $pasta->name }}"
  />

  <label for="number" class="form-label">N°</label>
  <input
    type="text"
    class="form-control"
    id="number"
    name="number"
    value="{{ $pasta->number }}"
  />

  <label for="type" class="form-label">Tipo</label>
  <select class="form-select" id="type" name="type">
    <option value="lunga" @selected($pasta->type == 'lunga')>Lunga</option>
    <option value="corta" @selected($pasta->type == 'corta')>Corta</option>
    <option value="cortissima" @selected($pasta->
      type == 'cortissima')>Cortissima
    </option>
  </select>

  <label for="cooking_time" class="form-label">Tempo di cottura</label>
  <input
    type="number"
    class="form-control"
    id="cooking_time"
    name="cooking_time"
    value="{{ $pasta->cooking_time }}"
  />

  <label for="weight" class="form-label">Peso (g)</label>
  <input
    type="text"
    class="form-control"
    id="weight"
    name="weight"
    value="{{ $pasta->weight }}"
  />

  <label for="img" class="form-label">img</label>
  <input
    type="text"
    class="form-control"
    id="img"
    name="img"
    value="{{ $pasta->img }}"
  />

  <label for="description" class="form-label">Descrizione</label>
  <textarea class="form-control" id="description" name="description" rows="4">
      {{ $pasta->description }}
    </textarea
  >

  <button type="submit" class="btn btn-primary">Salva</button>
</form>
```

infine aggiungiamo il link al form di modifica nella cella "actions" della lista

```html
{{-- resources/views/pastas/index.blade.php --}}

<table class="table">
  ...
  <tbody>
    @foreach ($pastas as $pasta)
    <tr>
      <th scope="row">{{ $pasta->id }}</th>
      ...
      <td>
        <a href="{{ route('pastas.show', $pasta) }}">Dettaglio</a>

        <a href="{{ route('pastas.edit', $pasta) }}">Modifica</a>

        ...
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
```

#### update - La modifica

Nel metodo `update()` gestiremo la logica della modifica reindirizzando poi l'utente alla rotta `show()`

```php
// App/Http/Controllers/PastaController.php

/**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \App\Models\Pasta $pasta
 * @return \Illuminate\Http\Response
 */
public function update(Request $request, Pasta $pasta)
{
    $data = $request->all();
    $pasta->update($data);
    return redirect()->route('pastas.show', $pasta);
}
```

### D - DELETE

#### delete - Button e modale

Dobbiamo aggiungere il `button` per l'eliminazione della risorsa. Attenzione: il click del `button` dovrà far apparire una modale di conferma dell'operazione prima di cancellare effettivamente il record.

NB: l'attributo `data-bs-target` collegherà il `button` alla modale con `id` corrispondente

```html
{{-- resources/views/pastas/index.blade.php --}}

<table class="table">
  ...
  <tbody>
    @foreach ($pastas as $pasta)
    <tr>
      <th scope="row">{{ $pasta->id }}</th>
      ...
      <td>
        <a href="{{ route('pastas.show', $pasta) }}">Dettaglio</a>

        <a href="{{ route('pastas.edit', $pasta) }}">Modifica</a>

        <button
          type="button"
          class="btn btn-danger"
          data-bs-toggle="modal"
          data-bs-target="#delete-modal-{{ $pasta->id }}"
        >
          Elimina
        </button>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
```

Vanno poi generate le modali corrispondenti ai bottoni, da posizionare prima della chiusura del tag `body`.

Il pulsante "Elimina" in ogni modale dovrà essere all'interno di un vero e proprio `form` contenente:

- method `POST`
- action che punta alla rotta del destroy
- la direttiva `@method('DELETE')`
- la direttiva `@csrf` per generare il token di sicurezza

```html
{{-- resources/views/pastas/index.blade.php --}} @foreach ($pastas as $pasta)
<!-- Modal -->
<div
  class="modal fade"
  id="delete-modal-{{ $pasta->id }}"
  tabindex="-1"
  aria-labelledby="delete-modal-{{ $pasta->id }}-label"
  aria-hidden="true"
>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="delete-modal-{{ $pasta->id }}-label">
          Conferma eliminazione
        </h1>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body text-start">
        Sei sicuro di voler eliminare la pasta {{ $pasta->name }} N° {{
        $pasta->number }} con ID {{ $pasta->id }}? <br />
        L'operazione non è reversibile
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          Annulla
        </button>

        <form
          action="{{ route('pastas.destroy', $pasta) }}"
          method="POST"
          class=""
        >
          @method('DELETE') @csrf

          <button type="submit" class="btn btn-danger">Elimina</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach
```

#### destroy - L'eliminazione

Non resta che gestire la logica dell'eliminazione nel controller

```php
// App/Http/Controllers/PastaController.php

/**
 * Remove the specified resource from storage.
 *
 * @param  \App\Models\Pasta $pasta
 * @return \Illuminate\Http\Response
 */
public function destroy(Pasta $pasta)
{
    $pasta->delete();
    return redirect()->route('pastas.index');
}
```

## La validazione

### Il metodo `validate`

Innanzitutto bisogna importare il validator nel controller:

```php
// App/Http/Controllers/PastaController.php

use Illuminate\Support\Facades\Validator;
```

Poi creiamo un metodo privato per la logica di validazione in fondo al controller. Nel metodo dobbiamo ricevere i dati da validare

```php
// App/Http/Controllers/PastaController.php

private function validation($data) {

}
```

Nel metodo statico `make` del `Validator`:

- il primo parametro saranno i dati da validare (array associativo)
- il secondo parametro saranno le regole di validazione (array associativo)
- il terzo parametro (opzionale) saranno messaggi di errore customizzati (array associativo)

```php
// App/Http/Controllers/PastaController.php

private function validation($data) {
  Validator::make(
    $data,
    [
      ... regole di validazione
    ],
    [
      ... messaggi di errore
    ]
  )
}
```

Al metodo make dovrà essere concatenato un metodo `->validate()` per eseguire la validazione, ed il risultato sarà ritornato dal nostro metodo privato.

```php
// App/Http/Controllers/PastaController.php

private function validation($data) {
  return Validator::make(
    $data,
    [
      ... regole di validazione
    ],
    [
      ... messaggi di errore
    ]
  )->validate();
}
```

Il risultato finale potrebbe somigliare a questo:

```php
// App/Http/Controllers/PastaController.php

private function validation($data) {
  $validator = Validator::make(
    $data,
    [
      'name' => 'required|string|max:20',
      'number' => "required|integer|between:1,500",
      "type" => "required|string|in:lunga,corta,cortissima",
      "cooking_time" => "required|integer",
      "weight" => "required|integer",
      "img" => "nullable|string",
      "description" => "nullable|string"
    ],
    [
      'name.required' => 'Il nome è obbligatorio',
      'name.string' => 'Il nome deve essere una stringa',
      'name.max' => 'Il nome deve massimo di 20 caratteri',

      'number.required' => 'Il numero è obbligatorio',
      'number.integer' => 'Il numero deve essere un numero',
      'number.unique' => 'Il numero deve essere unico',
      'number.between' => 'Il numero deve essere compreso tra :min e :max',

      'type.required' => 'Il tipo è obbligatorio',
      'type.string' => 'Il tipo deve essere una stringa',
      'type.in' => 'Il tipo deve un valore compreso tra "lunga", "corta", "cortissima"',

      'cooking_time.required' => 'Il tempo di cottura è obbligatorio',
      'cooking_time.integer' => 'Il tempo di cottura deve essere un numero',

      'weight.required' => 'Il peso è obbligatorio',
      'weight.integer' => 'Il peso deve essere un numero',

      'img.string' => 'L\'immagine deve essere una stringa',

      'description.string' => 'La descrizione deve essere una stringa',
    ]
  )->validate();

  return $validator;
}
```

Nel caso di validazione di campi unici, si può accettare anche l'id del record che si sta validando (verrà passato in caso di modifica) per gestire il controllo in questo modo:

```php
// App/Http/Controllers/PastaController.php

private function validation($data, $id = null) {
  $unique_name_rule = ($id) ? "|unique:pastas,name,$id" : "|unique:pastas";
  $unique_number_rule = ($id) ? "|unique:pastas,number,$id" : "|unique:pastas";

  return Validator::make(
    $data,
    [
      ...
      'name' => "required|string|max:20" . $unique_name_rule,
      'number' => "required|integer|between:1,500" . $unique_number_rule,
      ...
    ],
    [
      ...
    ]
  )->validate();
}
```

### Validazione nel controller

Nel metodo store:

```php
// App/Http/Controllers/PastaController.php

public function store(Request $request)
{
    $data = $this->validation($request->all());
    ...
}
```

Nel metodo update:

```php
// App/Http/Controllers/PastaController.php

public function update(Request $request, Pasta $pasta)
{
  $data = $this->validation($request->all(), $pasta->id);
  ...
}
```

### Validazione nelle viste

Possiamo in via generica stampare tutti gli errori di validazione con

```html
{{-- resources/views/pastas/create.blade.php --}} {{--
resources/views/pastas/edit.blade.php --}} @if ($errors->any())
<div class="alert alert-danger">
  <h4>Correggi i seguenti errori per proseguire:</h4>
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
```

Vanno però anche, per ognuno degli input, specificati i valori `old` (ossia quelli dell'inserimento la cui validazione è fallita) nei form.

#### create

Per ogni input:

- abbiamo a disposizione la direttiva `@error('field_name')` per verificare la validazione dei singoli input. possiamo usarla per stampare la classe `is-invalid` di BS
- aggiungiamo il valore `old` come default
- aggiungiamo il messaggio di errore nel `div.invalid-feedback` successivo all'input (la variabile `$message` è generata automaticamente dalla direttiva `@error`)

```html
<input
  type="text"
  class="form-control @error('number') is-invalid @enderror"
  id="number"
  name="number"
  value="{{ old('number') }}"
/>
@error('number')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
```

#### edit

Per ogni input vale quanto descritto precedentemente nella sezione `create`.
A differenza del `create` possiamo sfruttare il null coalescent operator per i valori di default degli input:

```html
<input
  type="text"
  class="form-control @error('number') is-invalid @enderror"
  id="number"
  name="number"
  value="{{ old('number') ?? $pasta->number }}"
/>
@error('number')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
```
