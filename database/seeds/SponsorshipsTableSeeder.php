<?php

use Illuminate\Database\Seeder;

use Faker\Generator as Faker;

use App\Sponsorship;

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
