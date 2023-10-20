<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
        for($i = 0; $i <= 100; $i++) {
            $book = new Book();
            
            $book->title = $faker->word();
            $book->author = $faker->name();
            $book->editor = $faker->lastName();
            $book->genre = $faker->word();
            $book->synopsis = $faker->paragraph();
            $book->published = $faker->date();
            $book->pages = $faker->numberBetween(1,1000);

            $book->save();
          }
    }
}
