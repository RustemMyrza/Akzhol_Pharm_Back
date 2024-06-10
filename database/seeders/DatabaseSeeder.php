<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SocialSeeder::class,
            SeoPageSeeder::class,
            AgreementSeeder::class,
            ContactSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ApplicationSeeder::class,
            BannerSeeder::class,
            SliderSeeder::class,
            CountrySeeder::class,
            CitySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
            FilterSeeder::class,
            PaymentMethodSeeder::class,
            DeliveryContentSeeder::class,
            DealerContentSeeder::class,
            HomeContentSeeder::class,
            AboutUsContentSeeder::class,
            InstructionSeeder::class,
            FeatureSeeder::class,
        ]);
    }
}
