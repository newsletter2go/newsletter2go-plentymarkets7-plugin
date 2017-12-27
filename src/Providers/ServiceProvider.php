<?php

namespace Newsletter2Go\Providers;

use Plenty\Plugin\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{

    /**
     * Register the service provider.
     */

    public function register()
    {
        $this->getApplication()->register(RouteServiceProvider::class);
    }
}
