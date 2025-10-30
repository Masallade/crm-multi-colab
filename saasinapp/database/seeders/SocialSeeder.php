<?php

namespace Database\Seeders;

use App\Models\Landlord\Hero;
use App\Models\Landlord\Social;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data =[
            [
                'name' => 'facebook',
                'link' => 'https://facebook.com/avantcoretech',
                'icon' => 'fa fa-facebook',
                'position' => 1,
            ],
            [
                'name' => 'twitter',
                'link' => 'https://twitter.com/avantcoretech',
                'icon' => 'fa fa-twitter',
                'position' => 2,
            ],
            [
                'name' => 'youtube',
                'link' => 'https://youtube.com/avantcoretech',
                'icon' => 'fa fa-youtube',
                'position' => 3,
            ],
        ];

        Social::insert($data);

    }
}
