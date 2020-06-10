<?php

use Illuminate\Database\Seeder;
use App\View;
use App\Apartment;
use Faker\Generator as Faker;


class ViewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 200; $i++) { 
            $view = new View;
            $apartment = Apartment::inRandomOrder()->first();
            $view->apartment_id = $apartment->id;
            $view->save();
        } 
    }
}
