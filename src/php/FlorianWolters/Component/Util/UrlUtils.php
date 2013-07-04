<?php
namespace FlorianWolters\Component\Util;

use \Exception;
use Guzzle\Http\Client;

/**
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2013 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @link      http://github.com/FlorianWolters/PHP-Application-UrlShortener-Silex
 */
class UrlUtils
{
    /**
     * @param string $url
     *
     * @return boolean
     */
    public static function isValidFormat($url)
    {
        return \filter_var(
            $url,
            \FILTER_VALIDATE_URL,
            \FILTER_FLAG_HOST_REQUIRED
        );
    }

    /**
     * @param string $url
     *
     * @return boolean
     */
    public static function isStatusCodeError($url)
    {
        return (false === self::isNotStatusCodeError($url));
    }

    /**
     * @param string $url
     *
     * @return boolean
     */
    public static function isNotStatusCodeError($url)
    {
        if (false === self::isValidFormat($url)) {
            throw new \InvalidArgumentException(
                'The specified argument is not a valid URL.'
            );
        }

        $client = new Client(
            $url,
            array('curl.options' => array(\CURLOPT_NOBODY => true))
        );

        try {
            $statusCode = $client->head()->send()->getStatusCode();
            $result = (399 > $statusCode);
        } catch (Exception $ex) {
            $result = false;
        }

        return $result;
    }
}
