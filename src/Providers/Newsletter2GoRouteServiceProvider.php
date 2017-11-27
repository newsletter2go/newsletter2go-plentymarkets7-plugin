<?php

namespace Newsletter2Go\Providers;


use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;

class Newsletter2GoRouteServiceProvider extends RouteServiceProvider
{
    public function map(Router $router)
    {
        $router->get('newsletter2go/test','Newsletter2Go\Controllers\Newsletter2GoController@test');
        $router->get('newsletter2go/version','Newsletter2Go\Controllers\Newsletter2GoController@version');
        $router->get('newsletter2go/count','Newsletter2Go\Controllers\Newsletter2GoController@customerCount');
        $router->get('newsletter2go/customers','Newsletter2Go\Controllers\Newsletter2GoController@customers');
    }
}
