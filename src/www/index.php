<?php

use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use FlorianWolters\Application\UrlShortener\UrlShortenerControllerProvider;

require_once __DIR__ . '/../../vendor/autoload.php';

$app = new Application;

$app->register(new DoctrineServiceProvider, [
    "db.options" => [
        "driver" => "pdo_sqlite",
        "path" => "./../data/UrlShortener.db",
    ]
]);
$app->register(new DoctrineOrmServiceProvider, [
    "orm.proxies_dir" => __DIR__ . "/../data/proxies",
    "orm.em.options" => [
        "mappings" => [
            [
                "type" => "annotation",
                "namespace" => "FlorianWolters\Application\UrlShortener\Entity",
                "path" => __DIR__ . "/../src/php/FlorianWolters/Application/UrlShortener/Entity",
            ]
        ]
    ]
]);
$app->register(new FormServiceProvider);
$app->register(new TranslationServiceProvider);
$app->register(new TwigServiceProvider, [
    'twig.path' => __DIR__ . '/views',
]);
$app->register(new UrlGeneratorServiceProvider);

$app->mount('/', new UrlShortenerControllerProvider);

$app['debug'] = true;
$app->run();
