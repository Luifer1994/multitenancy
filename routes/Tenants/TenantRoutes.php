<?php

use App\Http\Modules\Tenants\Controllers\TenantController;
use App\Jobs\ConfigPassportTenantJob;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Cities Routes
|--------------------------------------------------------------------------
*/

Route::prefix('tenants')->group(function () {
   /*  Route::group(['middleware' => 'auth:api'], function () { */
        Route::controller(TenantController::class)->group(function () {
            Route::get('list', 'index')->middleware('permission:tenants-list');
            Route::post('create', 'store')->middleware('permission:tenants-create');
        });
   /*  }); */
});

Route::get('test', function () {
    dispatch(new ConfigPassportTenantJob('foob'))/* ->onConnection('central') */;
    return 'test';
});
