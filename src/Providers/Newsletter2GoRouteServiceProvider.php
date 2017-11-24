<?php

namespace Newsletter2Go\Providers;


use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;

class Newsletter2GoRouteServiceProvider extends RouteServiceProvider
{
    public function map(Router $router)
    {
        $router->get('newsletter2go/export','Newsletter2Go\Controllers\Newsletter2GoController@test');
        $router->get('newsletter2go/customers','Newsletter2Go\Controllers\Newsletter2GoController@customers');
    }
}
