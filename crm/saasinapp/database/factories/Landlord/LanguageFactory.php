<?php

namespace Database\Factories\Landlord;

use App\Models\Landlord\Language;
use Illuminate\Database\Eloquent\Factories\Factory;


class LanguageFactory extends Factory
{
    protected $model = Language::class;

    public function definition(): array
    {
        return [
            'id' => 1,
            'name' => 'English',
            'locale'  => "en",
            'is_default' => 1
        ];
    }
}
