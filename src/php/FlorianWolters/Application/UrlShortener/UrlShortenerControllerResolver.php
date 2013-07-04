<?php
namespace FlorianWolters\Application\UrlShortener;

use Silex\ControllerResolver;

/**
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2013 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @link      http://github.com/FlorianWolters/PHP-Application-UrlShortener-Silex
 */
class UrlShortenerControllerResolver extends ControllerResolver
{
    /**
     * @param string $controller
     * @return array
     *
     * @throws \LogicException
     * @throws \InvalidArgumentException
     */
    protected function createController($controller)
    {
        if (false !== strpos($controller, '::')) {
            return parent::createController($controller);
        }

        if (false === strpos($controller, ':')) {
            throw new \LogicException(
                sprintf('Unable to parse the controller name "%s".', $controller)
            );
        }

        list($service, $method) = explode(':', $controller, 2);

        if (false === isset($this->app[$service])) {
            throw new \InvalidArgumentException(
                sprintf('Service "%s" does not exist.', $controller)
            );
        }

        return array($this->app[$service], $method);
    }
}
