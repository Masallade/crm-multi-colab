<?php

namespace Database\Factories\Landlord;

use App\Models\Landlord\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;


class FaqFactory extends Factory
{
    protected $model = Faq::class;

    public function definition(): array
    {
        return [
            'id'=> 1,
            'language_id'=> 1,
            'heading'=> 'Frequently Asked Questions',
            'sub_heading'=> 'Have questions? we have answered common ones below.',
        ];
    }
}
