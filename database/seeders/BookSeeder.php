<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Genre;
use App\Models\Book;
use Faker\Generator as Faker;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $genre = Genre::all()->pluck('id')->toArray();
        for($i = 0; $i <= 100; $i++) {
            $book = new Book();
            
            $book->genre_id = $faker->randomElement($genre);

            $book->title = $faker->word();
            $book->author = $faker->name();
            $book->editor = $faker->lastName();
            $book->synopsis = $faker->paragraph();
            $book->published = $faker->date();
            $book->pages = $faker->numberBetween(1,1000);

            $book->save();
          }
    }
}
