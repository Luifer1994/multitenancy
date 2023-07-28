<?php

use App\Http\Modules\Tenants\Controllers\TenantController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Cities Routes
|--------------------------------------------------------------------------
*/

Route::prefix('tenants')->group(function () {
    Route::group(['middleware' => 'jwt.verify'], function () {
        Route::controller(TenantController::class)->group(function () {
            Route::get('list', 'index')/* ->middleware('permission:cities-list') */;
            Route::post('create', 'store')/* ->middleware('permission:cities-create') */;
        });
    });
});
