<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    require base_path('routes/Auth/AuthRoutes.php');
    require base_path('routes/Users/UserRoutes.php');
    require base_path('routes/RolesAndPermissions/RolesAndPermissionRoutes.php');
    require base_path('routes/Cities/CityRoutes.php');
    require base_path('routes/DocumentTypes/DocumentTypeRoutes.php');
});
