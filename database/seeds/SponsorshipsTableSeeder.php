<?php

use Illuminate\Database\Seeder;
use App\Sponsorship;
use Faker\Generator as Faker;

class SponsorshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 3; $i++) { 
            $sponsorship = new Sponsorship;
            $sponsorship->duration = $faker->randomDigitNotNull();
            $sponsorship->price = $faker->randomNumber(2, true);
            $sponsorship->save();
        } 
    }
}
