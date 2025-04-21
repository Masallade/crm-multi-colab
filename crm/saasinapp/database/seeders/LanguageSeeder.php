<?php

namespace Database\Seeders;

use App\Models\Landlord\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'id' => 1,
            'name' => 'English',
            'locale'  => "en",
            'is_default' => 1
        ];

        Language::create($data);
    }
}
