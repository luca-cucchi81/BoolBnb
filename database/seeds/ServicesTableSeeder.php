<?php

use Illuminate\Database\Seeder;
use App\Service;
use Faker\Generator as Faker;

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
        foreach ($servizi as $servizietto){
            $service = new Service;
            $service->name = $servizietto;
            $service->save();
        }  
    }       
}
