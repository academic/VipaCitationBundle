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
            ->add('author', 'text', [
                'required' => false,
                'attr' => [
                    'class' => 'input-sm'
                    ]
                ]
            )
            ->add('title', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm'
                    ]
                ]
            )
            ->add('editor', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm'
                    ]
                ]
            )
            ->add('pages', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm'
                    ]
                ]
            )
            ->add('publisher', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm'
                    ]
                ]
            )
            ->add('location', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm'
                    ]
                ]
            )
            ->add('type', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm'
                    ]
                ]
            )
            ->add('language', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm'
                    ]
                ]
            )
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