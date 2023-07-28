<?php

namespace App\Http\Modules\Tenants\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Tenants\Repositories\TenantRepository;
use App\Http\Modules\Tenants\Requests\CreateTenantRequest;
use App\Http\Modules\Tenants\Services\TenantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TenantController extends Controller
{
    protected $TenantRepository;
    protected $TenantService;

    public function __construct(TenantRepository $TenantRepository, TenantService $TenantService)
    {
        $this->TenantRepository = $TenantRepository;
        $this->TenantService    = $TenantService;
    }

    /**
     * Get all tenants.
     *
     * @return JsonResponse
     * @author Luifer Almendrales
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->TenantRepository->getAllTenants();

            return $this->successResponse($data, 'Tenants retrieved successfully.');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Create a new tenant.
     *
     * @param CreateTenantRequest $request
     * @return JsonResponse
     */
    public function store(CreateTenantRequest $request): JsonResponse
    {
        try {
            $newTenant = $this->TenantService->createTenant($request);
            if (!$newTenant['status'])
                return $this->errorResponse($newTenant['message'], Response::HTTP_BAD_REQUEST);

            return $this->successResponse($newTenant['data'], $newTenant['message'], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
