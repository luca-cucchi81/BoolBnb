<?php

use Illuminate\Database\Seeder;

use Faker\Generator as Faker;

use App\Image;
use App\Apartment;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 120; $i++) {
            $image = new Image;
            $apartment = Apartment::inRandomOrder()->first();
            $image->apartment_id = $apartment->id;
            $image->path = 'https://picsum.photos/200/300';
            $image->save();
        }

    }
}
