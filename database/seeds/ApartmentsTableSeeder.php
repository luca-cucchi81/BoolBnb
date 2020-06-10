<?php

use Illuminate\Database\Seeder;
use App\Apartment;
use App\User;
use App\Service;
use App\Sponsorship;
use Faker\Generator as Faker;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ApartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 30; $i++) { 
            $apartment = new Apartment;
            $user = User::inRandomOrder()->first(); //abbiamo selezionato uno user random
            $apartment->user_id = $user->id; //a user_id abbioamo assegnato l'id dello user random
            $apartment->title = $faker->sentence(6, true);
            $apartment->description = $faker->paragraph(3, true);
            $apartment->rooms = $faker->randomDigitNotNull();
            $apartment->beds = $faker->randomDigitNotNull();
            $apartment->bathrooms = $faker->randomDigitNotNull();
            $apartment->square_meters = $faker->randomNumber(3, true);
            $apartment->address = $faker->address();
            $apartment->latitude = $faker->latitude($min = -90, $max = 90);
            $apartment->longitude = $faker->longitude($min = -180, $max = 180);
            $apartment->main_img = 'https://picsum.photos/200/300';
            $apartment->visibility = 1;
            $now = Carbon::now()->format('Y-m-d-H-i-s');
            $apartment->slug = Str::slug($apartment->title, '-') . $now;
            $apartment->save();
            $services = Service::inRandomOrder()->limit(rand(1, 6))->get(); // abbiamo preso un numero random di servizi
            $apartment->services()->attach($services); //all'appartamento gli abbiamo assegnato il numero random di servizi
            $sponsorship = Sponsorship::inRandomOrder()->first(); 
            $apartment->sponsorships()->attach($sponsorship); 
        } 
    }
}
