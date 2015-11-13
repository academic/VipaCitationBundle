<?php

namespace OkulBilisim\AdvancedCitationBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Ojs\CoreBundle\Events\TwigEvent;
use Ojs\CoreBundle\Events\TwigEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig_Environment;

class TwigEventSubscriber implements EventSubscriberInterface
{
    /** @var EntityManager */
    private $em;

    /** @var Twig_Environment */
    private $twig;

    /**
     * TwigEventSubscriber constructor.
     * @param EntityManager $em
     * @param Twig_Environment $twig
     */
    public function __construct(EntityManager $em, Twig_Environment $twig)
    {
        $this->em = $em;
        $this->twig = $twig;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            TwigEvents::OJS_SUBMISSION_CITATION_VIEW => 'onCitationView',
            TwigEvents::OJS_SUBMISSION_CITATION_FORM_EXTRA => 'onCitationFormExtrasRequested',
        );
    }

    public function onCitationView(TwigEvent $event)
    {
        $advancedCitation = $this->em
            ->getRepository('AdvancedCitationBundle:AdvancedCitation')
            ->findOneBy(['citation' => $event->getOptions()['citation']]);

        $template = $this->twig->render(
            'AdvancedCitationBundle:AdvancedCitation:table.html.twig',
            ['advancedCitation' => $advancedCitation]
        );

        $event->setTemplate($template);
    }

    public function onCitationFormExtrasRequested(TwigEvent $event)
    {
        $template = $this->twig->render(
            'AdvancedCitationBundle:AdvancedCitation:raw.html.twig'
        );

        $event->setTemplate($template);
    }
}