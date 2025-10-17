<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            TestimonialSeeder::class,
            SettingSeeder::class,
            SliderSeeder::class,
            HomePageFeatureSeeder::class,
            HomePageGallerySeeder::class,
            HomePageSectionTitleSeeder::class,
            AddHomePageHeroSettingsSeeder::class,
            CatalogPageSettingSeeder::class,
            AboutPageSettingSeeder::class,
            BlogPageSettingSeeder::class,
            ContactPageSettingSeeder::class,
            AccountPageSettingSeeder::class,
        ]);
    }
}

