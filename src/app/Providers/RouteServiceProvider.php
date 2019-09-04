<?php

namespace Rocklegend\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Cartalyst\Sentry\Facades\Laravel\Sentry;
use \Redirect;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = null;

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {

        // $router->filter('auth', function()
        // {
        //     if(isset($_SERVER['HTTP_USER_AGENT']) && strstr($_SERVER['HTTP_USER_AGENT'],'facebookexternalhit')){
        //       //it's probably Facebook's bot
        //     }else {
        //         if (!Sentry::check()) {

        //             return Redirect::guest('login');
        //         }
        //     }
        // });

        // $router->filter('guest', function()
        // {
        //     if (Sentry::check()) return Redirect::to('/');
        // });

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        include app_path('Http/routes.php');
    }
}
