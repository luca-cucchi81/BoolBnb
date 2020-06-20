<?php

use Illuminate\Database\Seeder;

use Faker\Generator as Faker;

use App\Message;
use App\Apartment;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 200; $i++) {
            $message = new Message;
            $apartment = Apartment::inRandomOrder()->first();
            $message->apartment_id = $apartment->id;
            $message->sender = $faker->email();
            $message->body = $faker->paragraph(3, true);
            $message->read = 0;
            $message->save();
        }
    }
}
