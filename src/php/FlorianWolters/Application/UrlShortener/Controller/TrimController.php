<?php
namespace FlorianWolters\Application\UrlShortener\Controller;

use Silex\Application;

use FlorianWolters\Application\UrlShortener\Entity\Trim;
use FlorianWolters\Application\UrlShortener\Type\TrimType;

class TrimController
{
    public function indexAction(Application $app)
    {
        $trim = new Trim;

        /* @var $formFactory Symfony\Component\Form\FormFactoryInterface */
        $formFactory = $app['form.factory'];
        /* @var $form Symfony\Component\Form\FormInterface */
        $form = $formFactory->create(new TrimType, $trim);

        /* @var $request Symfony\Component\HttpFoundation\Request */
        $request = $app['request'];

        if ('POST' === $request->getMethod()) {
            $form->bind($request);

            if (true === $form->isValid()) {
                $trim = $form->getData();
                $app['orm.em']->persist($trim);
                $app['orm.em']->flush();

                return $app->redirect('new_trim');
            }
        }

        return $app['twig']->render(
            'form.twig',
            array('form' => $form->createView())
        );
    }
}
