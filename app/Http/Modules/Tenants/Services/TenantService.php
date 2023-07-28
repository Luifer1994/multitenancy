<?php

namespace App\Http\Modules\Tenants\Services;

use App\Http\Modules\Tenants\Models\Tenant;
use App\Http\Modules\Tenants\Repositories\TenantRepository;
use App\Http\Modules\Tenants\Requests\CreateTenantRequest;
use Database\Seeders\CountrySeeder;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\DocumentTypeSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TenantService
{
    protected   $TenantRepository;
    protected   $PermissionRepository;

    public function __construct(TenantRepository $TenantRepository)
    {
        $this->TenantRepository       = $TenantRepository;
    }

    /**
     * Create a new tenant.
     *
     * @param CreateTenantRequest $request
     * @return array
     */
    public function createTenant(CreateTenantRequest $request): array
    {
        try {
            $request->merge([
                'user_created_id' => auth()->user()->id,
            ]);

            $newTenant = $this->TenantRepository->save(new Tenant($request->all()));

            $newTenant->domains()->create([
                'domain' => $request->id . '.localhost',
            ]);


            $newTenant->run(function () {
                Artisan::call('db:seed', ['--class' => DocumentTypeSeeder::class]);
                Artisan::call('db:seed', ['--class' => UserSeeder::class]);
                Artisan::call('db:seed', ['--class' => CountrySeeder::class]);
                Artisan::call('db:seed', ['--class' => DepartmentSeeder::class]);
                Artisan::call('create-permissions');
            });


            return [
                'status'    => true,
                'message'   => 'Tenant created successfully.',
                'data'      => $newTenant,
            ];
        } catch (\Throwable $th) {
            return [
                'status'    => false,
                'message'   => $th->getMessage(),
                'data'      => null,
            ];
        }
    }
}
