<?php
namespace FlorianWolters\Application\UrlShortener;

use Silex\Application;
use Silex\ControllerProviderInterface;

/**
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2013 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @link      http://github.com/FlorianWolters/PHP-Application-UrlShortener-Silex
 */
class UrlShortenerControllerProvider implements ControllerProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->match('/', 'controller.trim:indexAction')
            ->method('GET|POST')
            ->bind('trim_create');

        $controllers->post('/encode', 'controller.trim:encodeAction')
            ->bind('encode');

        $controllers->get('/{trimPath}', 'controller.trim:decodeAction')
            ->assert('trimPath', '[A-Za-z0-9]{' . $app['config']['short_url']['length'] . '}')
            ->bind('decode');

        return $controllers;
    }
}
