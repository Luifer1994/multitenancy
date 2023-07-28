<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
       /*  $this->configureRateLimiting(); */

        $this->routes(function () {
            $this->mapApiRoutes();
            $this->mapWebRoutes();
        });
    }

    protected function mapWebRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            Route::middleware('web')
                ->domain($domain)
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        }
    }

    protected function mapApiRoutes()
    {
        foreach ($this->centralDomains() as $domain) {

            Route::prefix('api')
                ->domain($domain)
                ->namespace($this->namespace)
                ->group(function(){
                    $this->loadRoutesFrom(base_path('routes/Users/UserRoutes.php'));
                    $this->loadRoutesFrom(base_path('routes/Auth/AuthRoutes.php'));
                    $this->loadRoutesFrom(base_path('routes/RolesAndPermissions/RolesAndPermissionRoutes.php'));
                    $this->loadRoutesFrom(base_path('routes/Cities/CityRoutes.php'));
                    $this->loadRoutesFrom(base_path('routes/DocumentTypes/DocumentTypeRoutes.php'));
                    $this->loadRoutesFrom(base_path('routes/Tenants/TenantRoutes.php'));
                });
        }
    }

    protected function centralDomains(): array
    {
        return config('tenancy.central_domains');
    }
}
