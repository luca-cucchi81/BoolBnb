<?php

use Illuminate\Database\Seeder;

use Faker\Generator as Faker;

use App\User;
use App\InfoUser;

class InfoUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $users = User::doesntHave('info')->get(); // Utenti che non hanno ancora info
        foreach ($users as $user) {
            $info = new InfoUser;
            $info->user_id = $user->id;
            $info->name = $faker->firstName();
            $info->lastname = $faker->lastName();
            $info->birthday = $faker->date();
            $info->photo = 'https://picsum.photos/200/200';
            $info->save();
        }
    }
}
