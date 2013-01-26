<?php
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use FlorianWolters\Application\UrlShortener\UrlShortenerControllerProvider;

\error_reporting(-1);

/**
 * Include the *Composer* autoloader.
 */
require __DIR__ . '/../../vendor/autoload.php';

$app = new Application;

$app->register(
    new DoctrineServiceProvider,
    array(
        "db.options" => array(
            "driver" => "pdo_sqlite",
            "path" => "./../data/UrlShortener.db"
        )
    )
);
$app->register(
    new DoctrineOrmServiceProvider,
    array(
        "orm.proxies_dir" => __DIR__ . "/../data/proxies",
        "orm.em.options" => array(
            "mappings" => array(
                array(
                    "type" => "annotation",
                    "namespace" => "FlorianWolters\Application\UrlShortener\Entity",
                    "path" => __DIR__ . "/../src/php/FlorianWolters/Application/UrlShortener/Entity"
                )
            )
        )
    )
);
$app->register(new FormServiceProvider);
$app->register(new TranslationServiceProvider);
$app->register(
    new TwigServiceProvider,
    array(
        'twig.path' => __DIR__ . '/views'
    )
);
$app->register(new UrlGeneratorServiceProvider);
$app->register(new ValidatorServiceProvider);

$app->mount('/', new UrlShortenerControllerProvider);

$app['debug'] = true;
$app->run();
