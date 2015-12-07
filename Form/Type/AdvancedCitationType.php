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
            ->add('address', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm'
                    ]
                ]
            )
            ->add('annote', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm'
                    ]
                ]
            )
            ->add('booktitle', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm'
                    ]
                ]
            )
            ->add('chapter', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm'
                    ]
                ]
            )
            ->add('crossref', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm'
                    ]
                ]
            )
            ->add('edition', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm'
                    ]
                ]
            )
            ->add('eprint', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm'
                    ]
                ]
            )
            ->add('howpublished', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm'
                    ]
                ]
            )
            ->add('key', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm'
                    ]
                ]
            )
            ->add('month', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm'
                    ]
                ]
            )
            ->add('note', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm'
                    ]
                ]
            )
            ->add('number', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm'
                    ]
                ]
            )
            ->add('organization', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm'
                    ]
                ]
            )
            ->add('school', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm'
                    ]
                ]
            )
            ->add('series', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm'
                    ]
                ]
            )
            ->add('url', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm'
                    ]
                ]
            )
            ->add('volume', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm'
                    ]
                ]
            )
            ->add('year', 'text', [
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