<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
class LandlordUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'first_name'=>'Mr',
            'last_name'=>'Admin',
            'username'=> 'admin',
            'email'=> 'admin@gmail.com',
            'password'=> bcrypt('admin'),
            'is_active'=> true,
            'is_super_admin'=> true,
        ]);
    }
}


