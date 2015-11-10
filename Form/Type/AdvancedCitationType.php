<?php

namespace OkulBilisim\AdvancedCitationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvancedCitationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author', 'text')
            ->add('title', 'text')
            ->add('editor', 'text')
            ->add('pages', 'text')
            ->add('publisher', 'text')
            ->add('location', 'text')
            ->add('type', 'text')
            ->add('language', 'text')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $defaults = ['data_class' => 'OkulBilisim\AdvancedCitationBundle\Entity\AdvancedCitation'];
        $resolver->setDefaults($defaults);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'okulbilisim_advancedcitation_type';
    }
}