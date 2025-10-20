<?php

namespace Database\Seeders;

use App\Models\Landlord\SeoSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SeoSetting::create([
            'meta_title' => "HRM SaaS with payroll, attendance and project management",
            'meta_description' => "Enhance collaboration and productivity in one interactive platform, making your organization more efficient and successful than ever before.",
            'og_title' => "AvantCoreTechnologies - best HRM SaaS with payroll, attendance and project management.",
            'og_description' => "Streamline HR processes, effortlessly manage attendance, and seamlessly conquer projects. Enhance collaboration and productivity in one interactive platform, making your organization more efficient and successful than ever before.",
            'og_image' => "202311060839221.png",
        ]);
    }
}
