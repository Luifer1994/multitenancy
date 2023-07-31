<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(
            [
                DocumentTypeSeeder::class,
                UserSeeder::class,
                CountrySeeder::class,
                DepartmentSeeder::class
            ]
        );

        Artisan::call('create-permission-users');
        Artisan::call('create-permission-dashboard');
        Artisan::call('create-permission-roles-and-permissions');
        Artisan::call('create-permission-cities');
        Artisan::call('create-permission-document-types');
    }
}
