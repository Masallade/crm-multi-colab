<?php

namespace Database\Factories\Landlord;

use App\Models\Landlord\FaqDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FaqDetailFactory extends Factory
{
    protected $model = FaqDetail::class;

    public function definition(): array
    {
        return [
            'faq_id' => 1,
            'question' => 'What is AvantCoreTechnologies SAAS?',
            'answer' => 'SalePro SAAS is a PHP Laravel Script',
            'position' => 1
        ];
    }
}
