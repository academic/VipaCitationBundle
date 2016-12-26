<?php

namespace Ojs\CitationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExtraCitationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'choice', [
                    'required' => true,
                    'choices'   => [
                        'article' => 'article',
                        'book' => 'book',
                        'booklet' => 'booklet',
                        'conference' => 'conference',
                        'inbook' => 'inbook',
                        'incollection' => 'incollection',
                        'inproceedings' => 'inproceedings',
                        'manual' => 'manual',
                        'masterthesis' => 'masterthesis',
                        'misc' => 'misc',
                        'phdthesis' => 'phdthesis',
                        'proceedings' => 'proceedings',
                        'techreport' => 'techreport',
                        'unpublished' => 'unpublished',
                    ],
                    'attr' => [
                        'class' => 'input-sm citation-type',
                        'data-name' => 'type'
                    ]
                ]
            )
            ->add('author', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'author'
                    ]
                ]
            )
            ->add('title', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'title'
                    ]
                ]
            )
            ->add('editor', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'editor'
                    ]
                ]
            )
            ->add('pages', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'pages'
                    ]
                ]
            )
            ->add('crossref', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'crosref'
                    ]
                ]
            )
            ->add('publisher', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'publisher'
                    ]
                ]
            )
            ->add('location', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'location'
                    ]
                ]
            )
            ->add('language', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'language'
                    ]
                ]
            )
            ->add('address', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'address'
                    ]
                ]
            )
            ->add('annote', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'annote'
                    ]
                ]
            )
            ->add('booktitle', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'booktitle'
                    ]
                ]
            )
            ->add('chapter', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'chapter'
                    ]
                ]
            )
            ->add('crossref', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'crossref'
                    ]
                ]
            )
            ->add('edition', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'edition'
                    ]
                ]
            )
            ->add('eprint', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'eprint'
                    ]
                ]
            )
            ->add('howpublished', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'howpublished'
                    ]
                ]
            )
            ->add('key', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'key'
                    ]
                ]
            )
            ->add('month', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'month'
                    ]
                ]
            )
            ->add('note', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'note'
                    ]
                ]
            )
            ->add('number', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'number'
                    ]
                ]
            )
            ->add('organization', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'organization'
                    ]
                ]
            )
            ->add('school', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'school'
                    ]
                ]
            )
            ->add('series', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'series'
                    ]
                ]
            )
            ->add('url', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'url'
                    ]
                ]
            )
            ->add('volume', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'volume'
                    ]
                ]
            )
            ->add('year', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'year'
                    ]
                ]
            )
            ->add('journal', 'text', [
                    'required' => false,
                    'attr' => [
                        'class' => 'input-sm',
                        'data-name' => 'journal'
                    ]
                ]
            )
            ->add('citationRaw', 'text', [
                    'required' => false,
                    'attr' => [
                        'data-name' => 'citationRaw'
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
            'data_class' => 'Ojs\CitationBundle\Entity\AdvancedCitation',
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
        return 'ojs_extra_citation_type';
    }
}
