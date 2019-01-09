<?php
namespace Newsletter2Go\Providers;
use IO\Helper\TemplateContainer;
use IO\Helper\ResourceContainer;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Templates\Twig;

class MapsServiceProvider extends ServiceProvider
{
    public function register()
    {

    }
    public function boot(Twig $twig, Dispatcher $eventDispatcher)
    {
        $eventDispatcher->listen('IO.Resources.Import', function (ResourceContainer $container)
        {
            $container->addScriptTemplate('Newsletter2Go::Content.Scripts');
        }, 0);
    }
}