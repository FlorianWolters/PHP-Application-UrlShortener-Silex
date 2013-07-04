<?php
namespace FlorianWolters\Application\UrlShortener\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use FlorianWolters\Application\UrlShortener\Entity\Trim;
use FlorianWolters\Application\UrlShortener\Service\TrimServiceInterface;
use FlorianWolters\Application\UrlShortener\Type\TrimType;
use FlorianWolters\Component\Util\UrlUtils;

/**
 * @author    Florian Wolters <wolters.fl@gmail.com>
 * @copyright 2013 Florian Wolters
 * @license   http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @link      http://github.com/FlorianWolters/PHP-Application-UrlShortener-Silex
 */
class TrimController
{
    /**
     * @var TrimServiceInterface
     */
    private $service;

    /**
     * @param TrimServiceInterface $service
     */
    public function __construct(TrimServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request     $request
     * @param Application $app
     *
     * @return string
     */
    public function indexAction(Request $request, Application $app)
    {
        $trimResult = null;
        $trim = new Trim($app['config']['short_url']['length']);

        /* @var $formFactory Symfony\Component\Form\FormFactoryInterface */
        $formFactory = $app['form.factory'];
        /* @var $form Symfony\Component\Form\FormInterface */
        $form = $formFactory->create(new TrimType, $trim);

        if ('POST' === $request->getMethod()) {
            $form->bind($request);

            if (true === $form->isValid()) {
                $trim = $form->getData();
                $trimResult = $this->encodeAction($app, $trim);
            }
        }

        return $app['twig']->render(
            'page.twig',
            array(
                'form' => $form->createView(),
                'page' => $app['config']['page'],
                'trim' => $trimResult,
                'trim_all' => $this->service->findAllTrims()
            )
        );
    }

    /**
     * @param Application $app
     * @param Trim        $trim
     *
     * @return Trim
     * @todo Move to service layer.
     */
    public function encodeAction(Application $app, Trim $trim)
    {
        if (true === UrlUtils::isStatusCodeError($trim->getOriginalUrl())) {
            // TODO Display message in template.
            return $app->abort(
                404,
                'The URL ' . $trim->getOriginalUrl() . ' does not seem to exist.'
            );
        }

        $persistentTrim = $this->service->findTrimByOriginalUrl(
            $trim->getOriginalUrl()
        );

        if (null === $persistentTrim) {
            // TODO Here or in the service layer?
            $trim->setCreatedFromIp($app['request']->getClientIp());
            $this->service->saveTrim($trim);
        }

        return $trim;
    }

    /**
     * @param Application $app
     * @param string      $trimPath
     *
     * @return RedirectResponse
     * @todo Move to service layer.
     */
    public function decodeAction(Application $app, $trimPath)
    {
        $trim = $this->service->findTrimByTrimPath($trimPath);
        if (null === $trim) {
            return $app->abort(
                404,
                'The URL ' . $trimPath . ' does not exist.'
            );
        }

        $this->service->updateTrim($trim);

        return $app->redirect($trim->getOriginalUrl());
    }
}
