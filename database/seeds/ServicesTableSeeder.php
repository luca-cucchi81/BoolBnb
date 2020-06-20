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
        $servizi = ['WiFi', 'Posto Auto', 'Piscina', 'Portineria', 'Sauna', 'Vista Mare'];
        foreach ($servizi as $servizio){
            $service = new Service;
            $service->name = $servizio;
            $service->save();
        }
    }
}
