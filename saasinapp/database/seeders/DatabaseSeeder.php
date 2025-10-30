<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            LandlordUserSeeder::class,
            LandlordGeneralSettingSeeder::class,
            LanguageSeeder::class,
            HeroSeeder::class,
            SocialSeeder::class,
            ModuleSeeder::class,
            FaqSeeder::class,
            TestimonialSeeder::class,
            TenantSignupDescriptionSeeder::class,
            PageSeeder::class,
            LandlordPermissionsSeeder::class,
            PackageSeeder::class,
            FeatureSeeder::class,
            BlogSeeder::class,
            SeoSeeder::class,
        ]);
    }
}
