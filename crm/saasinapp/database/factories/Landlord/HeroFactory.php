<?php

namespace Database\Factories\Landlord;

use App\Models\Landlord\Hero;
use Illuminate\Database\Eloquent\Factories\Factory;


class HeroFactory extends Factory
{
    protected $model = Hero::class;

    public function definition(): array
    {
        return [
            'language_id' => 1,
            'heading' => 'AvantCoreTechnologies is a HRM software.',
            'sub_heading' => 'Take care of all your products, sales, purchases, stores related tasks from an easy-to-use platform, from anywhere you want, anytime you want',
            'button_text' => 'Try for free',
            'image' => 'logo.png',
        ];
    }
}
