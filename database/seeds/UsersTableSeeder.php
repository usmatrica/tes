<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Surya Putrawan',
            'username' => 'surya',
            'password' => bcrypt('halo'),
            'email' => 'suryaputrawan@gmail.com',
        ]);
    }
}
