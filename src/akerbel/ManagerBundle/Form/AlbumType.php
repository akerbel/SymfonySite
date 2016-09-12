<?php

namespace akerbel\ManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionResolver\OptionResolverInterface;

class AlbumType extends AbstractType// implements FormBuilderInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title')
                ->add('description')
                ->add('sort');
    }
    
    public function setDefaultOptions(OptionResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'akerbel\ManagerBundle\Entity\Album'));
    }
    
    public function getname()
    {
        return 'akerbel_managerbundle_album';
    }
}
