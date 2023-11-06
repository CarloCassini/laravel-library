<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// colleghiamo il modello dei books
use App\Models\Book;

class Typology extends Model
{

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }

    use HasFactory;
}