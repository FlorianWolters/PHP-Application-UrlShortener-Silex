<?php
namespace FlorianWolters\Application\UrlShortener;

use Silex\Application;
use Silex\ControllerProviderInterface;

class UrlShortenerControllerProvider implements ControllerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        $controllers->match(
            '/',
            __NAMESPACE__ . '\Controller\TrimController::indexAction'
        )
        ->method('GET|POST')
        ->bind('trim_create');

        return $controllers;
    }
}
