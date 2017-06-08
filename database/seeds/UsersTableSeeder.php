<?php

use App\Models\User;
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
            'name' => 'User Client',
            'email' => 'user@example.com',
            'password' => bcrypt('123456'),
            'remember_token' => str_random(10),
        ]);
        factory(User::class, 5)->create();
    }
}
