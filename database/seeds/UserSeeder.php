<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        return User::create([
            'id' => 1,
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '0725684235',
            'email_verified_at' => '2020-09-21 00:10:49',
            'isdelete' => false,
            'password' => Hash::make('123456789'),
        ]);
    }
}
