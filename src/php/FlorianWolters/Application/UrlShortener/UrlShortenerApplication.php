<?php
namespace FlorianWolters\Application\UrlShortener;

use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;

class UrlShortenerApplication extends Application
{
    public function __construct()
    {
        $this->registerServiceProviders();
        $this->mountControllerProviders();
    }

    private function registerServiceProviders()
    {
        parent::__construct();
        $this->register(
            new DoctrineServiceProvider,
            array(
                'db.options' => array(
                    'driver' => 'pdo_sqlite',
                    'path' => './../data/UrlShortener.db'
                )
            )
        );
        $this->register(
            new DoctrineOrmServiceProvider,
            array(
                'orm.proxies_dir' => __DIR__ . '/../../../../data/proxies',
                'orm.em.options' => array(
                    'mappings' => array(
                        array(
                            'type' => 'annotation',
                            'namespace' => __NAMESPACE__ . '\Entity',
                            'path' => __DIR__ . '/Entity'
                        )
                    )
                )
            )
        );
        $this->register(new FormServiceProvider);
        $this->register(new TranslationServiceProvider);
        $this->register(
            new TwigServiceProvider,
            array(
                'twig.path' => __DIR__ . '/../../../../www/views'
            )
        );
        $this->register(new UrlGeneratorServiceProvider);
        $this->register(new ValidatorServiceProvider);
    }

    private function mountControllerProviders()
    {
        $this->mount('/', new UrlShortenerControllerProvider);
    }
}
