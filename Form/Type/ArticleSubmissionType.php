<?php

namespace OkulBilisim\AdvancedCitationBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use Ojs\JournalBundle\Entity\Journal;
use Ojs\JournalBundle\Entity\SubjectRepository;
use Ojs\JournalBundle\Form\Type\ArticleAuthorType;
use Ojs\JournalBundle\Form\Type\ArticleFileType;
use OkulBilisim\AdvancedCitationBundle\Form\DataTransformer\CitationCollectionTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleSubmissionType extends AbstractType
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'articleType',
                'entity',
                array(
                    'label' => 'article.type',
                    'class' => 'Ojs\JournalBundle\Entity\ArticleTypes',
                    'required' => false
                )
            )
            ->add('translations', 'a2lix_translations',[
                'locales' => $options['locales'],
                'default_locale' => $options['default_locale'],
                'required_locales' => [$options['default_locale']],
                'fields' => [
                    'title' => [
                        'field_type' => 'text'
                    ],
                    'keywords' => [
                        'required' => true,
                        'label' => 'keywords',
                        'field_type' => 'tags'
                    ],
                    'abstract' => [
                        'required' => true,
                        'label' => 'article.abstract',
                        'attr' => array('class' => ' form-control wysihtml5'),
                        'field_type' => 'textarea'
                    ]
                ]
            ])
            ->add(
                'subjects',
                'entity',
                array(
                    'class' => 'OjsJournalBundle:Subject',
                    'multiple' => true,
                    'required' => true,
                    'property' => 'indentedSubject',
                    'label' => 'journal.subjects',
                    'attr' => [
                        'style' => 'height: 100px'
                    ],
                    'choices' => $options['journal']->getSubjects(),
                )
            )
            ->add('citations', 'collection', array(
                    'type' => new AdvancedCitationType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'label' => 'article.citations'
                )
            )
            ->add('articleFiles', 'collection', array(
                    'type' => new ArticleFileType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'options' => array(
                        'locales' => $options['locales']
                    ),
                    'label' => 'article.files'
                )
            )
            ->add('articleAuthors', 'collection', array(
                    'type' => new ArticleAuthorType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'label' => 'article.authors'
                )
            )
        ;

        $builder->get('citations')->addModelTransformer(new CitationCollectionTransformer($this->manager));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'locales' => [],
                'default_locale' => '',
                'journal' => new Journal(),
                'validation_groups' => false,
                'cascade_validation' => true,
                'data_class' => 'Ojs\JournalBundle\Entity\Article',
                'citationTypes' => [],
                'attr' => [
                    'novalidate' => 'novalidate',
                    'class' => 'form-validate',
                ],
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ojs_article_submission';
    }
}
