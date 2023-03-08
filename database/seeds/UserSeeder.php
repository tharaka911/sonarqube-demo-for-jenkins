<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
               'name'=>'Admin',
               'email'=>'admin@gmail.com',
               'user_type'=>'admin',
               'password'=> bcrypt('123456'),
               'status'=>1,
            ]
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
