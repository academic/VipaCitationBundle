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
            ->add('author', 'text', ['required' => false])
            ->add('title', 'text', ['required' => false])
            ->add('editor', 'text', ['required' => false])
            ->add('pages', 'text', ['required' => false])
            ->add('publisher', 'text', ['required' => false])
            ->add('location', 'text', ['required' => false])
            ->add('type', 'text', ['required' => false])
            ->add('language', 'text', ['required' => false])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $defaults = [
            'data_class' => 'OkulBilisim\AdvancedCitationBundle\Entity\AdvancedCitation',
            'attr' => [
                'novalidate' => 'novalidate',
                'class' => 'form-validate',
            ],
        ];

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