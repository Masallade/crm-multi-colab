<?php

namespace Database\Seeders;

use App\Models\Landlord\Hero;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'language_id' => 1,
            'heading' => 'AvantCoreTechnologies - best HRM SaaS with payroll, attendance and project management.',
            'sub_heading' => 'Unlock the full potential of your business with AvantCoreTechnologies SaaS application. Streamline HR processes, effortlessly manage attendance, and seamlessly conquer projects. Enhance collaboration and productivity in one interactive platform, making your organization more efficient and successful than ever before.',
            'button_text' => 'Try for free',
            'image' => '202310010734541.png',
        ];

        Hero::create($data);
    }
}
