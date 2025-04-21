<?php

namespace Database\Factories\Landlord;

use App\Models\Landlord\Feature;
use Illuminate\Database\Eloquent\Factories\Factory;


class FeatureFactory extends Factory
{
    protected $model = Feature::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'icon' => 'test',
            'position' => 0,
        ];
    }
}
