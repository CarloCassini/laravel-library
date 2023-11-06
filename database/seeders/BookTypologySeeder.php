<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// uso faker
use Faker\Generator as Faker;

// importiamo i due models 
use App\Models\Book;
use App\Models\Typology;

class BookTypologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $books = Book::all();
        $typologies = Typology::all()->pluck("id")->toArray();

        foreach ($books as $book) {
            $book->typologies()
                ->attach($faker->randomElements($typologies, random_int(0, 4)));
        }
    }
}