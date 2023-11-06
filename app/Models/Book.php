<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// importiamo il modello delle typology
use App\Models\Typology;

class Book extends Model
{
    use HasFactory;

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function typologies()
    {
        return $this->belongsToMany(Typology::class);
    }

    protected $fillable = [

        'title',
        'genre_id',
        'author',
        'editor',
        'synopsis',
        'published',
        'pages',
    ];
}