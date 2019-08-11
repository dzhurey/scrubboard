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
        $this->mapItemGroupWebRoutes();
        $this->mapItemSubCategoryWebRoutes();
        $this->mapItemWebRoutes();
        $this->mapPriceWebRoutes();
        $this->mapAgentWebRoutes();

        /* API route mapping */
        $this->mapApiPersonWebRoutes();
        $this->mapApiVehicleWebRoutes();
        $this->mapApiCustomerWebRoutes();
        $this->mapApiBankAccountWebRoutes();
        $this->mapApiCourierWebRoutes();
        $this->mapApiItemGroupWebRoutes();
        $this->mapApiItemSubCategoryWebRoutes();
        $this->mapApiItemWebRoutes();
        $this->mapApiPriceWebRoutes();
        $this->mapApiAgentWebRoutes();
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
            ->prefix('bank_accounts')
            ->group(base_path('routes/web/bank_account.php'));
    }

    protected function mapCourierWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->prefix('couriers')
            ->group(base_path('routes/web/courier.php'));
    }

    protected function mapItemGroupWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->prefix('item_groups')
            ->group(base_path('routes/web/item_group.php'));
    }

    protected function mapItemSubCategoryWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->prefix('item_sub_categories')
            ->group(base_path('routes/web/item_sub_category.php'));
    }

    protected function mapItemWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->prefix('items')
            ->group(base_path('routes/web/item.php'));
    }

    protected function mapPriceWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->prefix('prices')
            ->group(base_path('routes/web/price.php'));
    }

    protected function mapAgentWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->prefix('agents')
            ->group(base_path('routes/web/agent.php'));
    }

    /* API Routes */
    protected function mapApiPersonWebRoutes()
    {
        Route::middleware('auth:api')
            ->namespace($this->namespace)
            ->prefix('api/people')
            ->group(base_path('routes/api/person.php'));
    }

    protected function mapApiVehicleWebRoutes()
    {
        Route::middleware('auth:api')
            ->namespace($this->namespace)
            ->prefix('api/vehicles')
            ->group(base_path('routes/api/vehicle.php'));
    }

    protected function mapApiCustomerWebRoutes()
    {
        Route::middleware('auth:api')
            ->namespace($this->namespace)
            ->prefix('api/customers')
            ->group(base_path('routes/api/customer.php'));
    }

    protected function mapApiBankAccountWebRoutes()
    {
        Route::middleware('auth:api')
            ->namespace($this->namespace)
            ->prefix('api/bank_accounts')
            ->group(base_path('routes/api/bank_account.php'));
    }

    protected function mapApiCourierWebRoutes()
    {
        Route::middleware('auth:api')
            ->namespace($this->namespace)
            ->prefix('api/couriers')
            ->group(base_path('routes/api/courier.php'));
    }

    protected function mapApiItemGroupWebRoutes()
    {
        Route::middleware('auth:api')
            ->namespace($this->namespace)
            ->prefix('api/item_groups')
            ->group(base_path('routes/api/item_group.php'));
    }

    protected function mapApiItemSubCategoryWebRoutes()
    {
        Route::middleware('auth:api')
            ->namespace($this->namespace)
            ->prefix('api/item_sub_categories')
            ->group(base_path('routes/api/item_sub_category.php'));
    }

    protected function mapApiItemWebRoutes()
    {
        Route::middleware('auth:api')
            ->namespace($this->namespace)
            ->prefix('api/items')
            ->group(base_path('routes/api/item.php'));
    }

    protected function mapApiPriceWebRoutes()
    {
        Route::middleware('auth:api')
            ->namespace($this->namespace)
            ->prefix('api/prices')
            ->group(base_path('routes/api/price.php'));
    }

    protected function mapApiAgentWebRoutes()
    {
        Route::middleware('auth:api')
            ->namespace($this->namespace)
            ->prefix('api/agents')
            ->group(base_path('routes/api/agent.php'));
    }
}
