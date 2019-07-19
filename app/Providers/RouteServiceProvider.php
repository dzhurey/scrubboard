<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapPersonWebRoutes();
        $this->mapVehicleWebRoutes();
        $this->mapCustomerWebRoutes();
        $this->mapBankAccountWebRoutes();
        $this->mapCourierWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "user" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapPersonWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->prefix('people')
            ->group(base_path('routes/web/person.php'));
    }

    protected function mapVehicleWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->prefix('vehicles')
            ->group(base_path('routes/web/vehicle.php'));
    }

    protected function mapCustomerWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->prefix('customers')
            ->group(base_path('routes/web/customer.php'));
    }

    protected function mapBankAccountWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->prefix('banks')
            ->group(base_path('routes/web/bank_account.php'));
    }

    protected function mapCourierWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->prefix('couriers')
            ->group(base_path('routes/web/courier.php'));
    }
}
