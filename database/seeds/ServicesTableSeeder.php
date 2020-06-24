<?php

use Illuminate\Database\Seeder;

use Faker\Generator as Faker;

use App\Service;


class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $servizi = ['WiFi', 'Parking Place', 'Pool', 'Reception', 'Turkish Bath', 'Sea View'];
        foreach ($servizi as $servizio){
            $service = new Service;
            $service->name = $servizio;
            $service->save();
        }
    }
}
