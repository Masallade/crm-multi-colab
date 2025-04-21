<?php

namespace Database\Factories\Landlord;

use App\Models\Landlord\TenantSignupDescription;
use Illuminate\Database\Eloquent\Factories\Factory;


class TenantSignupDescriptionFactory extends Factory
{
    protected $model = TenantSignupDescription::class;

    public function definition(): array
    {
        return  [
            'language_id' => 1,
            'heading' => 'Customer Sign Up',
            'sub_heading' => 'SalePro is packed with all the features you\'ll need to seamlessly run your business',
        ];
    }
}
