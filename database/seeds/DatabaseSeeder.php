<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(InfoUsersTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(SponsorshipsTableSeeder::class);
        $this->call(ApartmentsTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
        $this->call(ImagesTableSeeder::class);
    }
}
