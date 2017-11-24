<?php

namespace Newsletter2Go\Providers;


use Plenty\Plugin\ServiceProvider;

class Newsletter2GoServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     */

    public function register()
    {
        $this->getApplication()->register(Newsletter2GoRouteServiceProvider::class);
    }
}
