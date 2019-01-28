<?php

namespace Newsletter2Go\Providers;

use IO\Helper\TemplateContainer;
use IO\Helper\ResourceContainer;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\Templates\Twig;
use Plenty\Plugin\ServiceProvider as BaseServiceProvider;

class Newsletter2goServiceProvider extends BaseServiceProvider
{

    /**
     * Register the service provider.
     */

    public function register()
    {
        $this->getApplication()->register(RouteServiceProvider::class);
    }
}
