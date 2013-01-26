<?php
use FlorianWolters\Application\UrlShortener\UrlShortenerApplication;

\error_reporting(-1);

/**
 * Include the *Composer* autoloader.
 */
require __DIR__ . '/../../vendor/autoload.php';

$app = new UrlShortenerApplication;
$app['debug'] = true;
$app->run();
