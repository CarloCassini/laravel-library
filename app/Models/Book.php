<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function genre(){
        return $this->belongsTo(Genre::class);
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