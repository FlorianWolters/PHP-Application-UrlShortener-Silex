<?php
namespace FlorianWolters\Application\UrlShortener\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TrimType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('originalUrl', 'url');
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'trim';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'FlorianWolters\Application\UrlShortener\Entity\Trim'
            )
        );
    }
}
