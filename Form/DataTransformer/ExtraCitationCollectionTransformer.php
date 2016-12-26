<?php

namespace Ojs\CitationBundle\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Ojs\JournalBundle\Entity\Citation;
use Ojs\CitationBundle\Entity\AdvancedCitation;
use Ojs\CitationBundle\Entity\ExtraCitation;
use Ojs\CitationBundle\Helper\ExtraCitationHelper;
use Symfony\Component\Form\DataTransformerInterface;

class ExtraCitationCollectionTransformer  implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param  ArrayCollection|null $citations
     * @return ArrayCollection
     */
    public function transform($citations)
    {
        if (null === $citations) {
            return new ArrayCollection();
        }
        $collection = new ArrayCollection();
        /** @var Citation $citation */
        foreach ($citations as $citation) {
          $extra = $this->manager
                ->getRepository('OjsCitationBundle:AdvancedCitation')
                ->findOneBy(['citation' => $citation]);

            if (!$extra) {
                $extra = ExtraCitationHelper::prepareExtraCitation($citation);
            }

            $extra->setCitationRaw($citation->getRaw());
            $collection->add($extra);
        }

        return $collection;
    }

    /**
     * @param  ExtraAdvancedCitation $advancedCitations
     * @return ArrayCollection
     */
    public function reverseTransform($advancedCitations)
    {
        if (!$advancedCitations) {
            return new ArrayCollection();
        }

        $collection = new ArrayCollection();

        /** @var AdvancedCitation $advancedCitation */
        foreach ($advancedCitations as $advancedCitation) {
            $citation = $advancedCitation->getCitation();

            if(is_null($citation)){
                $citation = new Citation();
                $advancedCitation->setCitation($citation);
            }
            if (empty($citation->getRaw())) {
                $citation->setRaw($advancedCitation->getCitationRaw());
            }

            if (empty($citation->getType())) {
                $citation->setType($advancedCitation->getType());
            }

            $this->manager->persist($citation);
            $this->manager->persist($advancedCitation);
            $collection->add($citation);
        }

        return $collection;
    }
}
