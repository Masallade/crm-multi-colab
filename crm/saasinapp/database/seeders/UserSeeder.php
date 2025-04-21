<?php

namespace Database\Seeders;

use App\Models\Landlord\Hero;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'first_name'=>'Mr',
                'last_name'=>'Employee',
                'username'=> 'employee',
                'email'=> 'employee@gmail.com',
                'password'=> bcrypt('employee'),
                'role_users_id'=> 2,
                'is_active'=> true,
                'contact_no'=> 987654321
            ],
            [
                'first_name'=>'Mr',
                'last_name'=>'Client',
                'username'=> 'client',
                'email'=> 'client@gmail.com',
                'password'=> bcrypt('client'),
                'role_users_id'=> 3,
                'is_active'=> true,
                'contact_no'=> 123987456
            ]
        ];

        User::insert($data);
    }
}
