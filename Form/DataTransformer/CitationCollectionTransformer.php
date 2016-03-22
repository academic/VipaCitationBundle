<?php

namespace BulutYazilim\AdvancedCitationBundle\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Ojs\JournalBundle\Entity\Citation;
use BulutYazilim\AdvancedCitationBundle\Entity\AdvancedCitation;
use BulutYazilim\AdvancedCitationBundle\Helper\AdvancedCitationHelper;
use Symfony\Component\Form\DataTransformerInterface;

class CitationCollectionTransformer implements DataTransformerInterface
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
            $advanced = $this->manager
                ->getRepository('AdvancedCitationBundle:AdvancedCitation')
                ->findOneBy(['citation' => $citation]);
            if (!$advanced) {
                $advanced = AdvancedCitationHelper::prepareAdvancedCitation($citation);
            }
            $advanced->setCitationRaw($citation->getRaw());
            $collection->add($advanced);
        }

        return $collection;
    }

    /**
     * @param  AdvancedCitation $advancedCitations
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
