<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            [
                DocumentTypeSeeder::class,
                UserSeeder::class,
                CountrySeeder::class,
                DepartmentSeeder::class
            ]
        );
        Artisan::call('passport:install');
        Artisan::call('create-permissions');
    }
}
