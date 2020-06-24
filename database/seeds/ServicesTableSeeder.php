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
        $servizi = ['WiFi' => '<i class="fas fa-wifi"></i>', 'Parking Place' => '<i class="fas fa-parking"></i>', 'Pool' => '<i class="fas fa-swimmer"></i>', 'Reception' => '<i class="fas fa-concierge-bell"></i>', 'Turkish Bath' => '<i class="fas fa-hot-tub"></i>', 'Sea View' => '<i class="fas fa-water"></i>'];
        foreach ($servizi as $key => $servizio){
            $service = new Service;
            $service->name = $key;
            $service->icon = $servizio;
            $service->save();
        }
    }
}
