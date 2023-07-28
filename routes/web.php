<?php

use App\Http\Modules\Tenants\Models\Tenant;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
   $tenant1 = Tenant::create([
        'id' => 'foo', // This is the tenant id
        'name' => 'foo',
        'document_number' => '111',
        'document_type_id' => 1,
        'user_created_id' => 1,
    ]);

    $tenant1->domains()->create([
        'domain' => 'foo.localhost',
    ]);

    /* return 'Tenant created!'. $tenant1; */

    return view('welcome');
});
