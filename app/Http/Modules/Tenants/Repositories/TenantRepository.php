<?php

namespace App\Http\Modules\Tenants\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Tenants\Models\Tenant;

class TenantRepository extends RepositoryBase
{
    protected  $TenantModel;

    public function __construct(Tenant $TenantModel)
    {
        parent::__construct($TenantModel);
        $this->TenantModel = $TenantModel;
    }

    /**
     * Get all tenants.
     *
     * @return object
     * @author Luifer Almendrales
     */
    public function getAllTenants(): object
    {
        return $this->TenantModel->paginate(10);
    }
}
