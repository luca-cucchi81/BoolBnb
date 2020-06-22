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
        $sponsorizzazioni = ['2.99' => 1, '5.99' => 3, '9.99' => 6];
        foreach ($sponsorizzazioni as $key => $sponsorizzazione){
            $sponsorship = new Sponsorship;
            $sponsorship->price = $key;
            $sponsorship->duration = $sponsorizzazione;
            $sponsorship->save();
        }
    }
}
