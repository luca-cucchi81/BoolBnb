<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

use App\Apartment;
use App\User;
use App\Service;
use App\Sponsorship;

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
            $user = User::inRandomOrder()->first(); // Selezione di uno user casuale
            $apartment->user_id = $user->id;
            $apartment->title = $faker->sentence(6, true);
            $apartment->description = $faker->paragraph(3, true);
            $apartment->rooms = $faker->randomDigitNotNull();
            $apartment->beds = $faker->randomDigitNotNull();
            $apartment->bathrooms = $faker->randomDigitNotNull();
            $apartment->square_meters = $faker->randomNumber(3, true);
            $apartment->address = $faker->address();
            $apartment->lat = $faker->latitude($min = -90, $max = 90);
            $apartment->lng = $faker->longitude($min = -180, $max = 180);
            $apartment->main_img = 'https://picsum.photos/200/300';
            $apartment->visibility = 1;

            $now = Carbon::now()->format('Y-m-d-H-i-s');
            $apartment->slug = Str::slug($apartment->title, '-') . $now;

            $apartment->save();

            $services = Service::inRandomOrder()->limit(rand(1, 6))->get(); // Numero casuale di servizi da 1 a 6
            $apartment->services()->attach($services); // Attach nella tabella pivot

            $sponsorship = Sponsorship::inRandomOrder()->first();
            $apartment->sponsorships()->attach($sponsorship);
        }
    }
}
