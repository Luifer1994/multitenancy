<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        $storagePath = storage_path('auth');

        if (!is_dir($storagePath)) {
            mkdir($storagePath);
        }

        Passport::loadKeysFrom($storagePath);

        Route::group([
            'as' => 'passport.',
            'middleware' => [
                'universal',
                InitializeTenancyByDomain::class
            ],
            'prefix' => config('passport.path', 'oauth'),
            'namespace' => 'Laravel\Passport\Http\Controllers',
        ], function () {
            $this->loadRoutesFrom(__DIR__ . "/../../vendor/laravel/passport/src/../routes/web.php");
        });
    }

    /**
     * Register any authentication / authorization services.
     */
    public function register(): void
    {
       // Passport::ignoreRoutes();
    }
}
