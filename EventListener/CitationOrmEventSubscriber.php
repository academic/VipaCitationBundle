<?php

namespace OkulBilisim\AdvancedCitationBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use GuzzleHttp\Client;
use Ojs\JournalBundle\Entity\Citation;
use OkulBilisim\AdvancedCitationBundle\Entity\AdvancedCitation;
use OkulBilisim\AdvancedCitationBundle\Helper\AdvancedCitationHelper;

class CitationOrmEventSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return array(
            // Events::prePersist,
            // Events::postUpdate,
        );
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();

        if ($entity instanceof Citation) {
            $advancedCitation = AdvancedCitationHelper::prepareAdvancedCitation($entity);
            $entityManager->persist($advancedCitation);
        }
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();

        if ($entity instanceof Citation) {
            $advancedCitation = $entityManager
                ->getRepository('AdvancedCitationBundle:AdvancedCitation')
                ->findOneBy(['citation' => $entity]);
            $advancedCitation = AdvancedCitationHelper::prepareAdvancedCitation($entity, $advancedCitation);
            $entityManager->persist($advancedCitation);
            $entityManager->flush();
        }
    }


}