<?php
namespace FlorianWolters\Application\UrlShortener\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface ;

class TrimType extends AbstractType
{
    public function buildForm(FormBuilderInterface  $builder, array $options)
    {
        $builder->add('originalUrl', 'url')
            ->add('trimmedUrl', 'text');
    }

    public function getName()
    {
        return 'trim';
    }
}
