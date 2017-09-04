<?php
namespace Newsletter2Go\Providers;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;
use Plenty\Plugin\Routing\ApiRouter;

/**
 * Class Newsletter2GoRouteServiceProvider
 * @package Newsletter2Go\Providers
 */
class Newsletter2GoRouteServiceProvider extends RouteServiceProvider
{
	/**
	 * @param Router $router
     * @param ApiRouter $api
	 */
//	public function map(Router $router, ApiRouter $api)
//	{
//        $api->get('newsletter2go/export', 'Newsletter2Go\Controllers\ApiController@export');
//	}

    public function map(Router $router)
    {
        $router->get('newsletter2go/export', [
            'middleware' => 'oauth',
            'uses'       => 'Newsletter2Go\Controllers\ApiController@export'
        ]);
    }
}
