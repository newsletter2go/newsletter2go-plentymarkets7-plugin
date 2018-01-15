<?php

namespace Newsletter2Go\Providers;

use Newsletter2Go\Controllers\ApiController;
use Plenty\Plugin\RouteServiceProvider as BaseRouteServiceProvider;
use Plenty\Plugin\Routing\ApiRouter;

class RouteServiceProvider extends BaseRouteServiceProvider
{
    public function map(ApiRouter $apiRouter)
    {
        $apiRouter->version(['v1'], ['middleware' => 'oauth'], function ($apiRouter) {
            $controllerClass = ApiController::class;
            $apiRouter->get('newsletter2go/test', $controllerClass . '@test');
            $apiRouter->get('newsletter2go/version', $controllerClass . '@version');
            $apiRouter->get('newsletter2go/count', $controllerClass . '@customerCount');
            $apiRouter->get('newsletter2go/customers', $controllerClass . '@customers');
        });
    }
}
