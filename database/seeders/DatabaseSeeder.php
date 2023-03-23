<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Database\Seeders\MenuSeeder;
use Database\Seeders\UnitSeeder;
use Database\Seeders\EstimateStatusSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            EstimateStatusSeeder::class,
            MenuSeeder::class,
            UnitSeeder::class,
            DepartmentSeeder::class,
            AccessTypeSeeder::class,
            DepartmentSeeder::class,
            DesignationSeeder::class,
            sorCategoryTypeSeeder::class,
            UserTypeSeeder::class,
            OfficeSeeder::class,
            SorCategoriesSeeder::class
        ]);

    }
}
