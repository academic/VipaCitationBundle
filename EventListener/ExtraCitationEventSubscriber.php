<?php

namespace Vipa\CitationBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Vipa\CoreBundle\Events\TypeEvent;
use Vipa\JournalBundle\Event\Article\ArticleEvents;
use Vipa\JournalBundle\Event\CitationEditEvent;
use Vipa\JournalBundle\Event\CitationEvents;
use Vipa\CitationBundle\Form\Type\ExtraCitationSubmissionType;
use Vipa\JournalBundle\Event\CitationNewEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

class ExtraCitationEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * ExtraCitationEventSubscriber constructor.
     * @param Router $router
     * @param EntityManager $manager
     */
    public function __construct(Router $router, EntityManager $manager)
    {
        $this->router = $router;
        $this->manager = $manager;
    }
    
    public static function getSubscribedEvents()
    {
        return array(
            CitationEvents::CITATION_NEW => 'onNewViewRequested',
            CitationEvents::CITATION_EDIT => 'onEditViewRequested',
            ArticleEvents::INIT_SUBMIT_FORM => 'onSubmissionFormRequested',
        );
    }

    public function onNewViewRequested(CitationNewEvent $editEvent)
    {
        $parameters = [
            'articleId' => $editEvent->getArticleId(),
            'journalId' => $editEvent->getJournalId()
        ];

        $url = $this->router->generate('vipa_citation_new', $parameters);
        $editEvent->setResponse(new RedirectResponse($url, 302));
    }

    public function onEditViewRequested(CitationEditEvent $editEvent)
    {
        $parameters = [
            'id' => $editEvent->getCitationId(),
            'articleId' => $editEvent->getArticleId(),
            'journalId' => $editEvent->getJournalId()
        ];

        $url = $this->router->generate('vipa_citation_edit', $parameters);
        $editEvent->setResponse(new RedirectResponse($url, 302));
    }

    public function onSubmissionFormRequested(TypeEvent $event)
    {
        $event->setType(new ExtraCitationSubmissionType($this->manager));
    }
}
