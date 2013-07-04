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
use Igorw\Silex\ConfigServiceProvider;
use SilexAssetic\AsseticServiceProvider;

use FlorianWolters\Application\UrlShortener\UrlShortenerControllerResolver;
use FlorianWolters\Application\UrlShortener\Controller\TrimController;
use FlorianWolters\Application\UrlShortener\Service\TrimService;
use FlorianWolters\Application\UrlShortener\Service\QrCodeGeneratorService;
use FlorianWolters\Component\Service\QuickResponse\GoogleInfographics\GoogleInfographicsService;

/**
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2013 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @link      http://github.com/FlorianWolters/PHP-Application-UrlShortener-Silex
 * @todo      Replace static assets with Assetic library.
 */
class UrlShortenerApplication extends Application
{
    /**
     */
    public function __construct()
    {
        parent::__construct();
        $this->registerServiceProviders();
        $this->setControllerResolver();
        $this->registerControllers();
        $this->mountControllerProviders();
    }

    /**
     * @return void
     */
    private function registerServiceProviders()
    {
        $this->register(
            new ConfigServiceProvider(__DIR__ . '/../../../../data/prod.yml')
        );

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

        $pathToWeb = __DIR__ . '/../../../../www/views';

        $this->register(
            new TwigServiceProvider,
            array(
                'twig.path' => $pathToWeb
            )
        );

        $this->register(
            new AsseticServiceProvider,
            array(
                'assetic.path_to_web' => $pathToWeb,
                'assetic.options' => array(
                    'auto_dump_assets' => true,
                    'debug' => false
                )
            )
        );

        $this->register(new UrlGeneratorServiceProvider);
        $this->register(new ValidatorServiceProvider);
    }

    /**
     * @return void
     */
    private function setControllerResolver()
    {
        $this['resolver'] = $this->share(function () {
            return new UrlShortenerControllerResolver($this, $this['logger']);
        });
    }

    /**
     * @return void
     */
    private function registerControllers()
    {
        // This is where all the magic happens. The concrete implementations
        // are created and injected into the service layer and consumer layer.

        // TODO Abstract further by using an IoC container.

        $this['controller.trim'] = $this->share(function () {
            $repository = $this['orm.em']->getRepository(
                'FlorianWolters\Application\UrlShortener\Entity\Trim'
            );

            $basePath = \realpath($this['request']->getBasePath()) . '/' . $this['config']['qr_code']['path'];

            /// TODO Make configurable via IoC container.
            $qrCodeService = new GoogleInfographicsService;
            $qrCodeGenerator = new QrCodeGeneratorService(
                $qrCodeService,
                $basePath
            );

            $service = new TrimService($repository, $qrCodeGenerator);

            return new TrimController($service);
        });
    }

    /**
     * @return void
     */
    private function mountControllerProviders()
    {
        $this->mount('/', new UrlShortenerControllerProvider);
    }
}
