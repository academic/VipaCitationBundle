<?php

namespace Ojs\AdvancedCitationBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Ojs\CoreBundle\Events\TwigEvent;
use Ojs\CoreBundle\Events\TwigEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig_Environment;
use Symfony\Component\Yaml\Parser;

class TwigEventSubscriber implements EventSubscriberInterface
{
    /** @var EntityManager */
    private $em;

    /** @var Twig_Environment */
    private $twig;

    private $kernelRootDir;

    /**
     * TwigEventSubscriber constructor.
     * @param EntityManager $em
     * @param Twig_Environment $twig
     */
    public function __construct(EntityManager $em, Twig_Environment $twig, $kernelRootDir)
    {
        $this->em = $em;
        $this->twig = $twig;
        $this->kernelRootDir = $kernelRootDir;
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
            TwigEvents::OJS_NEW_ARTICLE_SUBMISSIN_SCRIPT => 'onNewArticleSubmissionScript',
            TwigEvents::OJS_JOURNAL_ARTICLE_EVENT_FORM => 'onJournalArticleEventForm',
        );
    }

    public function onCitationView(TwigEvent $event)
    {
        $yamlParser = new Parser();
        $citationParams = $yamlParser->parse(
            file_get_contents(
                $this->kernelRootDir.
                '/config/bibliography_params.yml'
            )
        );
        $advancedCitation = $this->em
            ->getRepository('AdvancedCitationBundle:AdvancedCitation')
            ->findOneBy(['citation' => $event->getOptions()['citation']]);

        $template = $this->twig->render(
            'AdvancedCitationBundle:AdvancedCitation:table.html.twig',
            [
                'advancedCitation' => $advancedCitation,
                'citationParams' => $citationParams
            ]
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

    public function onNewArticleSubmissionScript(TwigEvent $event)
    {
        $yamlParser = new Parser();
        $bibliographyParams = $yamlParser->parse(
            file_get_contents(
                $this->kernelRootDir.
                '/config/bibliography_params.yml'
            )
        );
        $template = $this->twig->render(
            'AdvancedCitationBundle:AdvancedCitation:script.html.twig',
            [
                'bibliographyParams' => json_encode($bibliographyParams)
            ]
        );

        $event->setTemplate($template);
    }
    public function onJournalArticleEventForm(TwigEvent $event)
    {
        $template = $this->twig->render(
            'AdvancedCitationBundle:ArticleSubmission:form.html.twig',
            [
                'form' => $event->getOptions()['form'],
                'dispatch' => $event->getOptions()['dispatch']
            ]
        );

        $event->setTemplate($template);
    }
}
