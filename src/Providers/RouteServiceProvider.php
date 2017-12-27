<?php

namespace Newsletter2Go\Providers;

use Newsletter2Go\Controllers\ApiController;
use Plenty\Plugin\RouteServiceProvider as BaseRouteServiceProvider;
use Plenty\Plugin\Routing\Router;

class RouteServiceProvider extends BaseRouteServiceProvider
{
    public function map(Router $router)
    {
        $controllerClass = ApiController::class;
        $router->get('newsletter2go/test', $controllerClass . '@test');
        $router->get('newsletter2go/version', $controllerClass . '@version');
        $router->get('newsletter2go/count', $controllerClass . '@customerCount');
        $router->get('newsletter2go/customers', $controllerClass . '@customers');
    }
}
