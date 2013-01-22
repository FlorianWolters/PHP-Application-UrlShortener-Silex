<?php
use Silex\Application;

use Silex\Provider\FormServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;

use FlorianWolters\Application\UrlShortener\UrlShortenerControllerProvider;

require_once __DIR__ . '/../../vendor/autoload.php';

$app = new Application;

$app->register(new FormServiceProvider);
$app->register(new TranslationServiceProvider);
$app->register(new TwigServiceProvider, [
    'twig.path' => __DIR__ . '/views',
]);
$app->register(new UrlGeneratorServiceProvider); 

$app->mount('/', new UrlShortenerControllerProvider);

$app['debug'] = true;
$app->run();
