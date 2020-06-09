<?php

use Illuminate\Database\Seeder;
use App\InfoUser;
use App\User;
use Faker\Generator as Faker;

class InfoUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $users = User::doesntHave('info')->get();

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
