<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Generator as Faker;
use App\Models\Typology;

class TypologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        $_typologies = ['copertina rigida', 'copertina flessibile', 'e-book', 'audio-book'];

        foreach ($_typologies as $_typology) {

            $typology = new Typology();
            $typology->format = $_typology;
            $typology->color = $faker->hexColor();
            $typology->save();

        }


    }
}