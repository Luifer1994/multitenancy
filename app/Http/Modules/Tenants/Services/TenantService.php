<?php

namespace App\Http\Modules\Tenants\Services;

use App\Http\Modules\Tenants\Models\Tenant;
use App\Http\Modules\Tenants\Repositories\TenantRepository;
use App\Http\Modules\Tenants\Requests\CreateTenantRequest;
use Database\Seeders\TenantSeeder;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\ClientRepository;

class TenantService
{
    protected   $TenantRepository;
    protected   $PermissionRepository;

    public function __construct(TenantRepository $TenantRepository)
    {
        $this->TenantRepository = $TenantRepository;
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
        $userCreatedId = auth()->user()->id;
        $newTenant = $this->TenantRepository->save(new Tenant(array_merge($request->all(), ['user_created_id' => $userCreatedId])));
        $domain = $request->id . '.localhost';

        $newTenant->domains()->create(['domain' => $domain]);

        $newTenant->run(function () use ($domain, $newTenant) {
            Artisan::call('db:seed', ['--class' => TenantSeeder::class]);
            $clientRepo = new ClientRepository();
            $clientRepo->createPasswordGrantClient(null, $newTenant->id, $domain, 'users');
            $clientRepo->createPersonalAccessClient(null, $newTenant->id, $domain, 'users');
        });

        return [
            'status' => true,
            'message' => 'Tenant created successfully.',
            'data' => $newTenant,
        ];
    } catch (\Throwable $th) {
        return [
            'status' => false,
            'message' => $th->getMessage(),
            'data' => null,
        ];
    }
}

}
