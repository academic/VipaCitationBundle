<?php

namespace OkulBilisim\AdvancedCitationBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use GuzzleHttp\Client;
use Ojs\JournalBundle\Entity\Citation;
use OkulBilisim\AdvancedCitationBundle\Entity\AdvancedCitation;

class CitationEventSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return array(
            Events::prePersist,
            Events::postUpdate,
        );
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();

        if ($entity instanceof Citation) {
            $advancedCitation = $this->prepareAdvancedCitation($entity);
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
            $advancedCitation = $this->prepareAdvancedCitation($entity, $advancedCitation);
            $entityManager->persist($advancedCitation);
            $entityManager->flush();
        }
    }

    private function prepareAdvancedCitation(Citation $entity, AdvancedCitation $advancedCitation = null)
    {
        $client = new Client(['base_uri' => 'http://parser.dergipark.gov.tr']);
        $response = $client->request('GET', '/', ['query' => ['q' => $entity->getRaw()]]);

        if ($response->getStatusCode() == 200) {
            $json = $response->getBody()->getContents();
            $parsedCitation = json_decode($json, true)[0][1];

            if ($advancedCitation === null) {
                $advancedCitation = new AdvancedCitation();
            }

            $advancedCitation
                ->setCitation($entity)
                ->setAuthor(!empty($parsedCitation['author']) ? $parsedCitation['author'] : null)
                ->setTitle(!empty($parsedCitation['title']) ? $parsedCitation['title'] : null)
                ->setEditor(!empty($parsedCitation['editor']) ? $parsedCitation['editor'] : null)
                ->setPages(!empty($parsedCitation['pages']) ? $parsedCitation['pages'] : null)
                ->setPublisher(!empty($parsedCitation['publisher']) ? $parsedCitation['publisher'] : null)
                ->setLocation(!empty($parsedCitation['location']) ? $parsedCitation['location'] : null)
                ->setType(!empty($parsedCitation['type']) ? $parsedCitation['type'] : null)
                ->setLanguage(!empty($parsedCitation['language']) ? $parsedCitation['language'] : null);

            return $advancedCitation;
        }

        return null;
    }
}