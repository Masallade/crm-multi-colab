<?php

namespace Database\Seeders;

use App\Models\Landlord\TenantSignupDescription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSignupDescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'language_id' => 1,
            'heading' => 'Customer Sign Up',
            'sub_heading' => 'SalePro is packed with all the features you\'ll need to seamlessly run your business',
        ];

        TenantSignupDescription::create($data);
    }
}
