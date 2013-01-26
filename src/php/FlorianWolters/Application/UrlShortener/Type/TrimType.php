<?php
namespace FlorianWolters\Application\UrlShortener\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TrimType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('originalUrl', 'url')
            ->add('trimPath', 'text');
    }

    public function getName()
    {
        return 'trim';
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'FlorianWolters\Application\UrlShortener\Entity\Trim'
            )
        );
    }
}
