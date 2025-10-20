<?php

namespace Database\Seeders;

use App\Models\Landlord\Feature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'icon' => 'fa fa-address-card-o',
                'name' => 'Employee Management,Payroll Processing.',
                'position' => 1
            ],
            [
                'icon' => 'fa fa-address-book',
                'name' => 'Recruitment and Onboarding, Performance Management.',
                'position' => 2
            ],
            [
                'icon' => 'fa fa-balance-scale',
                'name' => 'Leave and Attendence Management.',
                'position' => 3
            ],
            [
                'icon' => 'fa fa-briefcase',
                'name' => 'Project Management, Document Management.',
                'position' => 4
            ],
        ];

        Feature::insert($data);
    }
}
