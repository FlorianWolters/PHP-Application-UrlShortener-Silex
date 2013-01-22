<?php
namespace FlorianWolters\Application\UrlShortener\Controller;

use Silex\Application;

use FlorianWolters\Application\UrlShortener\Entity\Url;

class TrimController
{
    public function indexAction(Application $app)
    {
        $url = new Url;
        $url->setOriginalUrl('http://google.de');

        /* @var $formFactory Symfony\Component\Form\FormFactoryInterface */
        $formFactory = $app['form.factory'];
        /* @var $formBuilder Symfony\Component\Form\FormBuilderInterface */
        $formBuilder = $formFactory->createBuilder('form', $url);
        /* @var $form Symfony\Component\Form\FormInterface */
        $form = $formBuilder->add('originalUrl', 'url')
            ->add('trimmedUrl', 'text')
            ->getForm();

        /* @var $request Symfony\Component\HttpFoundation\Request */
        $request = $app['request'];

        if ('POST' === $request->getMethod()) {
            $form->bind($request);

            if (true === $form->isValid()) {
                $data = $form->getData();
                // TODO
            }
        }

        return $app['twig']->render(
            'form.twig',
            ['form' => $form->createView()]
        );
    }
}
