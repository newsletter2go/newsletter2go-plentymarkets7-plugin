<?php
namespace Newsletter2Go\Providers;

use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Templates\Twig;

/**
 * Class Newsletter2GoServiceProvider
 * @package Newsletter2Go\Providers
 */
class Newsletter2GoServiceProvider extends ServiceProvider
{

	/**
	 * Register the service provider.
	 */
	public function register()
	{
		$this->getApplication()->register(Newsletter2GoRouteServiceProvider::class);
	}

	public function boot(Twig $twig)
	{
		// Register Twig String Loader to use function: template_from_string
		$twig->addExtension('Twig_Extension_StringLoader');
	}
}
