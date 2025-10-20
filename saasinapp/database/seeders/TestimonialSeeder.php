<?php

namespace Database\Seeders;

use App\Models\Landlord\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Joe Saint',
                'description' => 'Can be set up very well and efficiently. Best HRM software. I like it. We hope this will help us to succeed in our future endeavors. No bugs found so far. Support is best.',
                'business_name' => 'VivaSoft.LTD',
                'position' => 1,
                'image' => '202310010821561.jpg',
            ],
            [
                'name' => 'Mark Williamson',
                'description' => 'Great Customer Support Ever! The support guy was really helpful !',
                'business_name' => 'OrangeToolz.com',
                'position' => 2,
                'image' => '202310010823181.jpeg',
            ],
            [
                'name' => 'Brenda Ballion',
                'description' => 'This is perfect product for your HRM.',
                'business_name' => 'BrainStation23',
                'position' => 3,
                'image' => '202310010824391.jpg',
            ],

        ];

        Testimonial::insert($data);
    }
}
